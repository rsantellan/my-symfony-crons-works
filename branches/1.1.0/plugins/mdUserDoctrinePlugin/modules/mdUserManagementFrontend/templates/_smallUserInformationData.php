<ul class="mis_datos">
    <li><label><?php echo __('mdUserDoctrine_text_name') ?>:</label><?php echo $sf_user->getProfile()->getName() ?></li><div class="clear"></div>
    <li><label><?php echo __('mdUserDoctrine_text_lastname') ?>:</label><?php echo $sf_user->getProfile()->getLastName() ?></li><div class="clear"></div>
    <li><label><?php echo __('mdUserDoctrine_text_email') ?>:</label><?php echo $sf_user->getMdPassport()->getMdUser()->getEmail() ?></li><div class="clear"></div>
    <li><a href="javascript:void(0)" onclick="return mdUserManagementFrontend.getInstance().editProfile('<?php echo url_for("mdUserManagementFrontend/getEditPageAjax"); ?>');"><?php echo __('mdUserDoctrine_text_changeMyData') ?></a>
</ul>