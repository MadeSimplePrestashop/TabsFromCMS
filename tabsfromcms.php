<?php

if (!defined('_PS_VERSION_'))
    exit;

class tabsFromCms extends Module {
    /* @var boolean error */

    protected $_errors = false;

    public function __construct() {
        $this->name = 'tabsfromcms';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'Kuzmany.biz';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Tabs from CMS');
        $this->description = $this->l('Add tab for attach cms content to products.');
    }

    public function install() {
        if (!parent::install() OR ! $this->alterTable('add') OR ! $this->registerHook('actionAdminControllerSetMedia') OR ! $this->registerHook('actionProductUpdate') OR ! $this->registerHook('displayAdminProductsExtra') OR ! $this->registerHook('productTab') OR ! $this->registerHook('productTabContent'))
            return false;
        return true;
    }

    public function uninstall() {
        if (!parent::uninstall() OR ! $this->alterTable('remove'))
            return false;
        return true;
    }

    public function alterTable($method) {
        switch ($method) {
            case 'add':
                $sql = 'ALTER TABLE ' . _DB_PREFIX_ . 'product ADD `id_cms_1` INT NOT NULL';
                Db::getInstance()->Execute($sql);
                $sql = 'ALTER TABLE ' . _DB_PREFIX_ . 'product ADD `id_cms_2` INT NOT NULL';
                Db::getInstance()->Execute($sql);
                $sql = 'ALTER TABLE ' . _DB_PREFIX_ . 'product ADD `id_cms_3` INT NOT NULL';
                Db::getInstance()->Execute($sql);
                break;

            case 'remove':
                $sql = 'ALTER TABLE ' . _DB_PREFIX_ . 'product DROP COLUMN `id_cms_1`';
                Db::getInstance()->Execute($sql);
                $sql = 'ALTER TABLE ' . _DB_PREFIX_ . 'product DROP COLUMN `id_cms_2`';
                Db::getInstance()->Execute($sql);
                $sql = 'ALTER TABLE ' . _DB_PREFIX_ . 'product DROP COLUMN `id_cms_3`';
                Db::getInstance()->Execute($sql);
                break;
        }

        return true;
    }

    public function prepareNewTab() {
        $id_lang = $this->context->language->id;
        $cms_array = CMS::listCms($id_lang);
        $ids_cms = array('' => '');
        foreach ($cms_array as $cms) {
            $ids_cms[$cms['id_cms']] = $cms['meta_title'];
        }
        $this->context->smarty->assign(array(
            'custom_fields' => $this->getCustomField((int) Tools::getValue('id_product')),
            'languages' => $this->context->controller->_languages,
            'default_language' => (int) Configuration::get('PS_LANG_DEFAULT'),
            'ids_cms' => $ids_cms
        ));
    }

    private function get_hook_content($template) {
        $ids_cms = $this->getCustomField((int) Tools::getValue('id_product'));
        if (empty($ids_cms))
            return '';
        $ret = '';
        for ($i = 1; $i < 4; $i++) {
            $id_cms = $ids_cms['id_cms_' . $i];
            $cms = new CMS($id_cms, $this->context->language->id);
            if (!$cms->meta_title)
                continue;
            //return '<pre>'.print_r($values, true).'</pre>';
            $this->context->smarty->assign(array(
                'producttabfromcms_title' => $cms->meta_title,
                'producttabfromcms_link_rewrite' => $cms->link_rewrite,
                'producttabfromcms_content' => $cms->content,
            ));
            $ret.= $this->display(__FILE__, $template);
        }
        return $ret;
    }

    // ---------------  HOOKS -------------------------------------------
    public function hookProductTab($params) {
        return $this->get_hook_content('product_tab.tpl');
    }

    public function hookProductTabContent($params) {
        return $this->get_hook_content('product_tab_content.tpl');
    }

    public function hookDisplayAdminProductsExtra($params) {
        if (Validate::isLoadedObject($product = new Product((int) Tools::getValue('id_product')))) {
            $this->prepareNewTab();

            return $this->display(__FILE__, 'tabsfromcms.tpl');
        }
    }

    public function hookActionProductUpdate($params) {

        if (!Tools::getValue('tabsfromcms'))
            return;

        $id_product = (int) Tools::getValue('id_product');
        if (!Db::getInstance()->update('product', array('id_cms_1' => pSQL(Tools::getValue('id_cms_1'))), 'id_product = ' . $id_product))
            $this->context->controller->_errors[] = Tools::displayError('Error: ') . mysql_error();
        if (!Db::getInstance()->update('product', array('id_cms_2' => pSQL(Tools::getValue('id_cms_2'))), 'id_product = ' . $id_product))
            $this->context->controller->_errors[] = Tools::displayError('Error: ') . mysql_error();
        if (!Db::getInstance()->update('product', array('id_cms_3' => pSQL(Tools::getValue('id_cms_3'))), 'id_product = ' . $id_product))
            $this->context->controller->_errors[] = Tools::displayError('Error: ') . mysql_error();
    }

    public function getCustomField($id_product) {
        return Db::getInstance()->getRow('SELECT id_cms_1, id_cms_2,id_cms_3 FROM ' . _DB_PREFIX_ . 'product WHERE id_product = ' . (int) $id_product);
    }

}
