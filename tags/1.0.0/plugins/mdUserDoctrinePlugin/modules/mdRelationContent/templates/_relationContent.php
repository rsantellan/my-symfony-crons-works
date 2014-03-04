<?php if($hasRelations): ?>

<p><?php echo __('mdUserDoctrine_text_contentProject'); ?></p>

<table id="flex1" style="display:none"></table>

<div class="clear"></div>

<form id="mdRelationContentForm" action="">
    <input type="hidden" id="_MD_Content_Id" name="_MD_Content_Id" value="<?php echo $_MD_Content_Id; ?>" />
    <input type="hidden" id="_MD_Object_Id" name="_MD_Object_Id" value="<?php echo $_MD_Object_Id; ?>" />
    <input type="hidden" id="_MD_Object_Class_Name" name="_MD_Object_Class_Name" value="<?php echo $_MD_Object_Class_Name; ?>" />
</form>

<div class="window-relation-content">
    <div id="dialog-modal" title="Basic modal dialog" style="display: none">
        <iframe id="iframe-relation-content" width="650" height="450" src="" frameborder="1">
        Si ves este mensaje, significa que tu navegador no soporta esta característica o está deshabilitada. Pero puedes acceder a esta información aquí <a href="http://www.htmlquick.com/reference/tags/a.html">tag HTML a</a>.
        </iframe>
    </div>
</div><!-- End demo -->

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo url_for('mdRelationContent/retrieveContentData'); ?>',
        dataType: 'json',
        colModel : [
                {display: 'Id', name : '_MD_Object_Id', width : 80, sortable : false, hide: true},
                {display: 'Clase', name : '_MD_Object_Class_Name', width : 100, sortable : false, hide: true},
                {display: '<?php echo __('mdUserDoctrine_text_type'); ?>', name : 'tipo', width : 100, sortable : false, align: 'left'},
                {display: '<?php echo __('mdUserDoctrine_text_detail'); ?>', name : 'detalle', width : 380, sortable : false, align: 'left'}
            ],
        buttons : [
                {name: 'Add', bclass: 'add', onpress : mdRelationContent.getInstance().addRow},
                {name: 'Delete', bclass: 'delete', onpress : mdRelationContent.getInstance().deleteRow},
                {name: 'Edit', bclass: 'add', onpress : mdRelationContent.getInstance().editRow},
                {separator: true}
            ],
        sortname: "tipo",
        sortorder: "asc",
        title: '<?php echo __('mdUserDoctrine_text_content'); ?>',
        showTableToggleBtn: true,
        usepager: true,        
        rp: 15,
        width: 538,
        onSubmit: mdRelationContent.getInstance().addFormData,
        onSuccess: mdRelationContent.getInstance().sortData
    });
</script>

<?php endif; ?>
