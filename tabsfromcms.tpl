<input type="hidden" name="tabsfromcms" value="1" />
<div  class="panel product-tab"  >
    <h3>{l s='Tabs from CMS' mod='tabsfromcms'}</h3>
    <div class="separation"></div>
    <table>
        <tr>
            <td class="col-left">
                <label>{l s='Add CMS page to product tab'}</label>
            </td>
            <td>
                {html_options name='id_cms_1' options=$ids_cms selected=$custom_fields.id_cms_1}
            </td>
        </tr>
        <tr>
            <td class="col-left">
                <label>{l s='Add CMS page to product tab'}</label>
            </td>
            <td>
                {html_options name='id_cms_2' options=$ids_cms selected=$custom_fields.id_cms_2}
            </td>
        </tr>
        <tr>
            <td class="col-left">
                <label>{l s='Add CMS page to product tab'}</label>
            </td>
            <td>
                {html_options name='id_cms_3' options=$ids_cms selected=$custom_fields.id_cms_3}
            </td>
        </tr>
    </table>
</div>