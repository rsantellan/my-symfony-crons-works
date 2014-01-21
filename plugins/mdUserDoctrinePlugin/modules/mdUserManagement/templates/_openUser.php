<?php use_helper('mdAsset') ?>
<?php die('openUser');?>
<li class="md_objects open" id='md_object_<?php echo $mdPassportForm->getObject()->getMdUserId() ?>'>
    <div id="show_error"></div>
    <div class="md_open_object_actions_top">
        <a id="cerrarModal" href="<?php echo url_for('mdUserManagement/getUserSmallDetailAjax') ?>?mdUserId=<?php echo $mdPassportForm->getObject()->getMdUserId() ?>" onclick="mdObjectList.closeObject(<?php echo $mdPassportForm->getObject()->getMdUserId() ?>, this, event);"><?php echo __('mdUserDoctrine_text_close');?></a>
    </div>
    <h1><?php echo $mdPassportForm->getObject()->getMdUser()->getEmail()?></h1>
    <hr/>
    <?php include_partial('user_basic_info', array('mdPassportForm' => $mdPassportForm)) ?>
    
    <div id="start_profiles" class="start_profiles">

            <?php include_partial('editProfileUserForm', array('form' => $mdUserProfile)); ?>
            <div class="clear"></div>
            <?php if( sfConfig::get( 'sf_plugins_user_media', false ) ):  ?>
							<div id="user_images">
									<?php //include_partial('editUserProfileImages', array('form' => $mdUserProfile)); ?>
							</div>
            <?php endif; ?>
            <div class="clear"></div>
						<?php if( sfConfig::get( 'sf_plugins_user_attributes', false ) ):  ?>
							<?php $profiles = $mdUserProfile->getObject()->getAllUsedProfiles();?>

						 
							<?php 
							foreach($profiles as $prof):?>
							
								<?php $profForm = $mdUserProfile->getObject()->getAttributesFormOfMdProfile($prof->getMdProfile()->getName()); ?>
								<?php include_partial('profile_form', array('form'=>$profForm,'name'=> $prof->getMdProfile()->getName(), 'mdProfileId' => $prof->getMdProfile()->getId(), 'mdUserProfileId' => $mdUserProfile->getObject()->getId() )) ?>
								
							<?php endforeach;?>
						
						<?php endif; ?>
            
            
<?php
            if(sfContext::getInstance()->getRouting()->hasRouteName('mdProducts')):?>
            <div class="md_blocks">
                <h2 class="float_left">Grupo de Descuentos</h2>
                <div class="float_left"><a href="javascript:void(0);" onclick="return discountGroupBox(<?php echo $form->getObject()->getId() ?>)"><?php echo plugin_image_tag ( 'mdBasicPlugin','edit.jpg' )?></a></div>
                <div class="clear"></div>
                <p id="discount_group_list"></p>
                <div class="clear"></div>
            </div>
<?php endif; ?>


    </div>

    <div class="clear"></div>
<?php if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) ):  ?>    
    <a href="<?php echo url_for('mdGroupAndPermissionsManagement/getNewPermissionBoxAjax') ?>" onclick="mdContentList.showContentBox('right_menu', this, event, true);">crear permisos</a> |
    <a href="<?php echo url_for('mdGroupAndPermissionsManagement/getAddPermissionToGroupBoxAjax') ?>" onclick="mdContentList.showContentBox('right_menu', this, event, true);">agregar permiso a grupo</a>
    <div class="md_blocks">
        <h2>Permisos</h2>
        
        <?php $permissions = $mdPassportForm->getObject()->getAllPermissionOfAllApplications();?>

        <div id="permission_list">
            <?php include_partial('userPermissionList', array('permissions'=> $permissions))?>
        </div>
        <div class="clear"></div>
    </div><!--BLOQUES-->
    <div class="clear"></div>
    <div class="clear"></div>
        <div class="md_blocks">
            <h2 class="float_left">Grupos</h2>
            <div class="float_left"><a href="javascript:void(0);" onclick="return getAddCategoryForProduct(<?php echo $mdPassportForm->getObject()->getId()?>)"><?php echo plugin_image_tag ( 'mdBasicPlugin','edit.jpg' )?></a><a href="#"></a></div>
            <div class="clear"></div>
            
            <?php $groups = $mdPassportForm->getObject()->getGroups();?>
            <div id="group_list">
                <div id="md_group_list">
                    <?php include_partial('userGroupList', array('groups'=> $groups, 'mdPassportId' => $mdPassportForm->getObject()->getId()))?>
                </div>
            </div>
           
            <div class="clear"></div>

        </div><!--BLOQUES-->
        <div class="clear"></div>
        <div class="md_blocks">
            
            <div class="clear"></div>
            
            <?php //$groups = $mdPassportForm->getObject()->getGroups();?>
            <div id="group_list">
                <div id="md_group_list">
                    <?php //include_partial('userGroupList', array('groups'=> $groups, 'mdPassportId' => $mdPassportForm->getObject()->getId()))?>
                </div>
            </div>
           
            <div class="clear"></div>

        </div><!--BLOQUES-->
        <div class="clear"></div>

 <?php endif; ?>
     
        <div class="bloques">

			<?php if($sf_user->getMdPassport()->getMdUserId() != $mdPassportForm->getObject()->getMdUserId()):?>
        <div class="clear"></div>
        <div class="md_blocks">
					<a id="delete_user" href="<?php echo url_for('mdUserManagement/deleteUserAjax') ?>" onclick="deleteUserWithConfirmation(<?php echo $mdPassportForm->getObject()->getMdUserId() ?>); return false;"><?php echo __('mdUserDoctrine_text_delete');?></a>
        </div>
      <?php endif;?>
      <?php if( sfConfig::get( 'sf_plugins_user_attributes', false ) ):  ?>     
        <div class=""><a href="#" onclick="addNewProfileToUser('<?php echo $mdPassportForm->getObject()->getId(); ?>', '<?php echo $mdPassportForm->getObject()->getMdUserId() ?>','<?php echo url_for('mdUserManagement/addNewProfile')?>'); return false;"><?php echo __('mdUserDoctrine_text_addProfile');?></a></div>
            <div id="new_product_<?php echo $mdPassportForm->getObject()->getMdUserId() ?>" style="display:none"></div>
        </div>
       <?php endif;?> 
         
        <a class="md_object_cancel_button" id="md_closeobjectbox_<?php echo $mdPassportForm->getObject()->getMdUserId()?>" href="<?php echo url_for('mdUserManagement/getUserSmallDetailAjax') ?>?mdUserId=<?php echo $mdPassportForm->getObject()->getMdUserId() ?>" onclick="mdObjectList.closeObject(<?php echo $mdPassportForm->getObject()->getMdUserId() ?>, this, event);"><?php echo __('mdUserDoctrine_text_cancel');?></a>
                <div class="md_object_save">
            <a id='button_to_save' href="<?php echo url_for('mdUserManagement/getUserSmallDetailAjax') ?>?mdUserId=<?php echo $mdPassportForm->getObject()->getMdUserId() ?>" onclick="saveMdUserProfileByAjax();mdObjectList.saveFormObject(<?php echo $mdPassportForm->getObject()->getMdUserId()?>, $('md_user_profile_edit_form_<?php echo $mdPassportForm->getObject()->getMdUserId()?>'), event)"><?php echo __('mdUserDoctrine_text_save');?></a>
        </div>
        <div class="clear"></div>
</li><!--LI PRODUCTO A EDITAR-->
