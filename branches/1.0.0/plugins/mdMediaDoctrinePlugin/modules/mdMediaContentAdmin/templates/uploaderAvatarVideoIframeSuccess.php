<div id="videoAvatarUpload">
<span>Seleccionar avatar para el Video </span>
<div style="clear: both;"></div>
<form id="videoAvatarForm" method="post" action="<?php echo url_for('@mdVideoAvatarUpload') ?>" enctype="multipart/form-data" >
    <table>
        <tbody>
            <tr>
                <td><label for="file0"><?php echo __('mdMediaManager_text_selectFile');?></label></td>
                <td><input id="file0" name="upload" type="file" size="20" class="" /></td>
            </tr>
        </tbody>
    </table>
    <div style="float:right">
        <input type="hidden" value="<?php echo $mediaConcrete->getId() ?>" name="videoId" />
        <input type="submit" name="uploadSubmit" value="<?php echo __('mdMediaManager_text_upload'); ?>" class="button" onclick="hideAvatarUploadForm();" />
    </div>
</form>
</div>

<script>
    function hideAvatarUploadForm(){
        document.getElementById('videoAvatarUpload').style.display = 'none';
        parent.document.getElementById('videoAvatarLoading').style.display = 'block';
    }

    function showAvatarUploadForm(){
        parent.document.getElementById('videoAvatarLoading').style.display = 'none';
        document.getElementById('videoAvatarUpload').style.display = 'block';
        parent.document.getElementById('player_avatar').style.backgroundImage = 'url(<?php echo $mediaConcrete->getAvatarVideo(array(mdWebOptions::WIDTH => 225, mdWebOptions::HEIGHT => 125, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>)';
        
        if(typeof(parent.updateMediaContainer)== 'function'){
            parent.updateMediaContainer();
        }
        
    }

<?php if(isset($showUploader) && $showUploader == 1): ?>
    showAvatarUploadForm();

<?php endif; ?>
</script>