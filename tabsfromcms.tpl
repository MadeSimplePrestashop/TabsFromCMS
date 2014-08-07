<input type="hidden" name="tabsfromcms" value="1" />
<div  class="panel product-tab">
    <h3>{l s='Tabs from CMS' mod='tabsfromcms'}</h3>
    <div class="separation"></div>
    <div class="form-group">
        <label class="control-label col-lg-3">{l s='Add CMS page to product tab'}</label>
        <div class="col-lg-5">{html_options name='id_cms_1' options=$ids_cms selected=$custom_fields.id_cms_1}</div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3">{l s='Add CMS page to product tab'}</label>
        <div class="col-lg-5">{html_options name='id_cms_2' options=$ids_cms selected=$custom_fields.id_cms_2}</div>
    </div>
</tr>
<div class="form-group">
    <label class="control-label col-lg-3">{l s='Add CMS page to product tab'}</label>
    <div class="col-lg-5">{html_options name='id_cms_3' options=$ids_cms selected=$custom_fields.id_cms_3}</div>
</div>

<div class="panel-footer">
    <a href="{$link->getAdminLink('AdminProducts')}" class="btn btn-default"><i class="process-icon-cancel"></i> {l s='Cancel'}</a>
    <button type="submit" name="submitAddproduct" class="btn btn-default pull-right"><i class="process-icon-save"></i> {l s='Save'}</button>
    <button type="submit" name="submitAddproductAndStay" class="btn btn-default pull-right"><i class="process-icon-save"></i> {l s='Save and stay'}</button>
</div>
</div>