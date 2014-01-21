<div ajax-url="<?php echo url_for('mdUserManagement/closedBox?id='.$mdUserForm->getObject()->getId()) ?>">
    <ul class="md_objects" >
        <li class="md_objects open" id='md_object_<?php echo $mdUserForm->getObject()->getId() ?>'>
            <div id="show_error"></div>
            <?php include_partial('md_user_basic_form', array('mdUserForm' => $mdUserForm)) ?>
            <div class="clear"></div>
            
                <a href="javascript:void(0)" onclick="mdUserManagement.getInstance().addMdPassport(<?php echo $mdUserForm->getObject()->getId() ?>,'<?php echo url_for('mdUserManagement/retrieveMdPassportForm')?>','<?php echo __('mdUserDoctrine_text_save') ?>','<?php echo __('mdUserDoctrine_text_cancel') ?>')"><?php echo __('mdUserDoctrine_text_addMdPassport') ?> </a>
                <div id="add_md_passport_modal" title="<?php echo __('mdUserDoctrine_text_addProfile') ?>"></div>
            <div class="clear"></div>
            <div class="bloques">
                <?php if($sf_user->getMdPassport()->getMdUserId() != $mdUserForm->getObject()->getId()):?>
                    <div class="clear"></div>
                    <div class="md_blocks">
                        <a id="delete_user" href="<?php echo url_for('mdUserManagement/deleteUserAjax') ?>" onclick="mdUserManagement.getInstance().deleteUserWithConfirmation('<?php echo __("mdUserDoctrine_text_confirmRemove")?>',<?php echo $mdUserForm->getObject()->getId() ?>); return false;"><?php echo __('mdUserDoctrine_text_delete');?></a>
                    </div>
                <?php endif;?>
            </div>
            <div style="float: right" id="md_user_save_cancel_button">
                <input type="button" value="<?php echo __('mdUserDoctrine_text_save') ?>"  onclick="mdUserManagement.getInstance().saveSimpleMdUser(<?php echo $mdUserForm->getObject()->getId() ?>);"/>
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
