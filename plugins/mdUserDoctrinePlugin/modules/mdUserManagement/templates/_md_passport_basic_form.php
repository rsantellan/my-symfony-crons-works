<div id="md_user_md_passport_edit_div_<?php echo $mdPassportForm->getObject()->getId() ?>">
    <form action='<?php echo url_for('mdUserManagement/processMdPassportAjax'); ?>' method="post" id='md_user_md_passport_edit_form_<?php echo $mdPassportForm->getObject()->getId() ?>'>
        <?php echo $mdPassportForm->renderHiddenFields()?>
        <div class="md_open_object_top">
            <div class="md_blocks">
                <h2><?php echo __('mdUserDoctrine_text_username') ?></h2>
                <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($mdPassportForm['username']->hasError()):?>error_msg<?php endif; ?>">
                    <?php echo $mdPassportForm['username']->render(array('id'=>'input_nombre'));?>
                </div>
                <div><?php if($mdPassportForm['username']->hasError()): echo $mdPassportForm['username']->renderLabelName() .': '. $mdPassportForm['username']->getError();  endif; ?></div>
            </div>
            <div class="md_blocks">
                <div style="margin-top: 27px">
                    <a href="javascript:void();" class="md_edit_span" onclick="return mdUserManagement.getInstance().resetPassword(<?php echo $mdPassportForm->getObject()->getId()?>, '<?php echo url_for("mdUserManagement/resetUserPasswordAjax");?>')"> <?php echo __('mdUserDoctrine_text_ResetPassword');?></a>
                </div>
            </div>
            </form>
    <?php if($sf_user->getMdPassport()->retrieveMdUser()->getSuperAdmin()):?>
      <div class="md_blocks">
        <h2><?php echo __('mdUserDoctrine_text_IsSuperAdmin')?></h2>
        <div >
          <input type="checkbox" onclick="mdUserManagement.getInstance().changeMdUserSuperAdmin(<?php echo $mdPassportForm->getObject()->getMdUserId()?>, '<?php echo url_for("mdUserManagement/switchMdUserSuperAdmin")?>')"<?php  if($mdPassportForm->getObject()->retrieveMdUser()->getSuperAdmin()) echo 'checked';?>/>
        </div>
      </div>
      <div class="clear"></div>
      <div class="md_blocks">
        <h2><?php echo __('mdUserDoctrine_text_IsActive')?></h2>
        <div >
          <input type="checkbox" onclick="mdUserManagement.getInstance().changeMdPassportIsActive(<?php echo $mdPassportForm->getObject()->getId()?>, '<?php echo url_for("mdUserManagement/switchMdPassportIsActive")?>')"<?php  if($mdPassportForm->getObject()->getAccountActive()) echo 'checked';?>/>
        </div>
      </div>
      <div class="md_blocks">
        <h2><?php echo __('mdUserDoctrine_text_IsBlocked')?></h2>
        <div >
          <input type="checkbox" onclick="mdUserManagement.getInstance().changeMdPassportIsBlocked(<?php echo $mdPassportForm->getObject()->getId()?>, '<?php echo url_for("mdUserManagement/switchMdPassportIsBlocked")?>')"<?php  if($mdPassportForm->getObject()->getAccountBlocked()) echo 'checked';?>/>
        </div>
      </div>
    <?php endif;?>
</div>
</div>
