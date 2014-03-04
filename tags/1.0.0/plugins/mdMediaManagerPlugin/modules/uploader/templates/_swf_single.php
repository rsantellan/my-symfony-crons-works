<div id="singleupload_view" style="display:none">
    <div id="uploadForms">
    <form id="uploadForm_0" method="post" action="<?php echo url_for('mdMediaContentAdmin/uploadBasicContent'); ?>" enctype="multipart/form-data" target="uploadFrame">
        <div id="uploadFormContents_0">
            <input type="hidden" name="objId" value="<?php echo $manager->getMdObject()->getId(); ?>" />
            <input type="hidden" name="objClass" value="<?php echo $manager->getMdObject()->getObjectClass(); ?>" />

            <table>
                <tbody>
                    <tr>
                        <td><label for="file0"><?php echo __('mdMediaManager_text_selectFile');?></label></td>
                        <td><input id="file0" name="upload" type="file" size="20" class="file required" /></td>
                    </tr>

                    <tr>
                        <td><label for="name0"><?php echo __('mdMediaManager_text_nameFile');?></label></td>

                        <td><input id="name0" name="filename" type="text" size="42" maxlength="255" class="text required" /></td>
                    </tr>

                    <?php if($manager->getCountAlbums() > 1): ?>

                    <tr>
                        <td><label for="name0"><?php echo __('mdMediaManager_text_album');?></label></td>
                        <td>
                            <?php $albums = $manager->getAlbums(); ?>
                            <select name="album_id">
                                <?php foreach($albums as $album): ?>
                                <option value="<?php echo $album->id; ?>" <?php echo (($album->id == $album_id) ? "selected=selected" : ""); ?>><?php echo $album->title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <?php else: ?>

                        <input type="hidden" name="album_id" value="<?php echo (int)$album_id; ?>" />

                    <?php endif; ?>
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
