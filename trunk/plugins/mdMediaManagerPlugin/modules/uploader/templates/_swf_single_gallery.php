<div id="singleupload_view" style="display:none">
    <div id="uploadForms">
    <form id="uploadForm_0" method="post" action="<?php echo url_for('mdImageFileGallery/uploadBasicContent'); ?>" enctype="multipart/form-data" target="uploadFrame">
        <div id="uploadFormContents_0">
            <input type="hidden" name="category" value="<?php echo $category; ?>" />

            <table>
                <tbody>
                    <tr>
                        <td><label for="file0"><?php echo __('mdMediaManager_text_selectFile');?></label></td>
                        <td><input id="file0" name="upload" type="file" size="20" class="file required" /></td>
                    </tr>
                </tbody>
            </table>

            <input type="submit" name="uploadSubmit" value="<?php echo __('mdMediaManager_text_upload'); ?>" class="button" onclick="startUpload(); return false;" />
            <input type="button" id="cancel" name="cancel" value="<?php echo __('mdMediaManager_text_cancel'); ?>" class="button" onclick="swfUpload();" />
        </div>
    </form>
    </div>
    <!-- File will be uploaded into this -->
    <iframe id="uploadFrame" name="uploadFrame" src="javascript:''" width="1" height="1" frameborder="0"></iframe>

</div>
<script>
    var __MD_OBJECT_CATEGORY     = "<?php echo $category; ?>";
</script>