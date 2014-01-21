<div ajax-url="<?php echo url_for('mdUserManagement/closedBox?id='.$mdPassportForm->getObject()->getMdUserId()) ?>">
    <ul class="md_objects" >
        <li class="md_objects open" id='md_object_<?php echo $mdPassportForm->getObject()->getMdUserId() ?>'>
            <div id="show_error"></div>
            <?php include_partial('md_user_basic_form', array('mdUserForm' => $mdUserForm)) ?>
            <div class="clear"></div>
            <?php include_partial('md_passport_basic_form', array('mdPassportForm' => $mdPassportForm)) ?>
            <div class="clear"></div>
            <?php include_partial('md_user_profile_basic_form', array('form' => $mdUserProfile)); ?>
            
            <div id="start_profiles" class="start_profiles">
                <?php if( sfConfig::get( 'sf_plugins_user_attributes', false ) ):  ?>
                    <?php $profiles = $mdUserProfile->getObject()->getAllUsedProfiles();?>
                    <?php foreach($profiles as $prof):?>
                        <?php $profForm = $mdUserProfile->getObject()->getAttributesFormOfMdProfile($prof->getMdProfile()->getName()); ?>
                        <?php include_partial('md_profile_form_container', array('form'=>$profForm,'name'=> $prof->getMdProfile()->getDisplay(), 'mdProfileId' => $prof->getMdProfile()->getId(), 'mdUserProfileId' => $mdUserProfile->getObject()->getId() )) ?>
                    <?php endforeach;?>

                <?php endif; ?>
                
                
                <div class="clear"></div>
                <hr/>
                
                <?php if( sfConfig::get( 'sf_plugins_user_attributes', false ) ):  ?>
                    <div class="clear"></div>
                    <div class=""><a href="javascript:void(0)" onclick="mdUserManagement.getInstance().addNewProfileToUser('<?php echo $mdPassportForm->getObject()->getId(); ?>', '<?php echo $mdPassportForm->getObject()->getMdUserId() ?>','<?php echo url_for('mdUserManagement/addNewProfile')?>'); return false;"><?php echo __('mdUserDoctrine_text_addProfile');?></a></div>
                    <div id="new_user_profile_container_<?php echo $mdPassportForm->getObject()->getMdUserId() ?>" style="display:none"></div>
                    <hr/>
                <?php endif;?>
                
                
                
                <?php if( sfConfig::get( 'sf_plugins_user_media', false ) ):  ?>
                    <div id="user_images" class="md_object_images">
                        <?php include_component('mdMediaContentAdmin', 'showAlbums', array('object' => $mdUserProfile->getObject())) ?>
                    </div>
                <?php endif; ?>
                <div class="clear"></div>

            </div>

            <div class="clear"></div>
            <?php if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) ):  ?>
                <?php include_component('mdUserPermission', 'mdUserPermission', array('groups' => mdGroupHandler::retrieveAllMdGroupsOfMdPassport($mdPassportForm->getObject()->getId()), 'id'=>$mdPassportForm->getObject()->getId())); ?>
            <?php endif; ?>
            <div class="clear"></div>
            <?php if( sfConfig::get('sf_plugins_user_relation_content_manage', false)): ?>
                <?php include_component('mdRelationContent','relationContent', array('_MD_Content_Id' => $mdUserProfile->getObject()->retrieveMdContent()->getId(), '_MD_Object_Id' => $mdUserProfile->getObject()->getId(), '_MD_Object_Class_Name' => $mdUserProfile->getObject()->getObjectClass(), '_MD_Dynamic_Content_Type' => $mdUserProfile->getObject()->getObjectClass())); ?>
                <br/>
            <?php endif; ?>
            <div class="clear"></div>
            <?php if( sfConfig::get('sf_plugins_user_manage_news_feed', false)): ?>
              <?php include_component("mdNewsfeedBackendAdmin", "showMdNewfeeds", array('id'=> $mdPassportForm->getObject()->getMdUserId()));?>
            <?php endif; ?>
            <div class="clear"></div>
            <div class="bloques">
                <?php if($sf_user->getMdPassport()->getMdUserId() != $mdPassportForm->getObject()->getMdUserId()):?>
                    <div class="clear"></div>
                    <div class="md_blocks">
                        <a id="delete_user" href="<?php echo url_for('mdUserManagement/deleteUserAjax') ?>" onclick="mdUserManagement.getInstance().deleteUserWithConfirmation('<?php echo __("mdUserDoctrine_text_confirmRemove")?>',<?php echo $mdPassportForm->getObject()->getMdUserId() ?>); return false;"><?php echo __('mdUserDoctrine_text_delete');?></a>
                    </div>
                <?php endif;?>
            </div>
            <div class="clear"></div>
            <div style="float: right" id="md_user_save_cancel_button">
                <input type="button" value="<?php echo __('mdUserDoctrine_text_save') ?>"  onclick="mdUserManagement.getInstance().saveMdUser(<?php echo $mdUserForm->getObject()->getId() ?>,<?php echo $mdPassportForm->getObject()->getId() ?>, <?php echo $mdUserProfile->getObject()->getId() ?>);"/>
                <a class="" href="javascript:void(0);" onclick="mastodontePlugin.UI.BackendBasic.getInstance().close();"><?php echo __('mdUserDoctrine_text_cancel') ?></a>
            </div>
            <div class="clear"></div>
        </li><!--LI PRODUCTO A EDITAR-->
    </ul>
</div>
<script type="text/javascript">
    $(function() {
		$( "input:button, a", "#md_user_save_cancel_button" ).button();
    });
</script>
