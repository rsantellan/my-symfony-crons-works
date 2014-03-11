<div id="md_user_edit_div_<?php echo $mdUserForm->getObject()->getId() ?>">
    <form action='<?php echo url_for('mdUserManagement/processMdUserAjax'); ?>' method="post" id='md_user_edit_form_<?php echo $mdUserForm->getObject()->getId() ?>'>
        <?php echo $mdUserForm->renderHiddenFields()?>
        <div class="md_open_object_top">
            <div class="md_blocks">
                <h2><?php echo __('mdUserDoctrine_text_email') ?></h2>
                <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($mdUserForm['email']->hasError()):?>error_msg<?php endif; ?>">
                    <?php echo $mdUserForm['email']->render(array('id'=>'input_nombre'));?>
                </div>
                <div><?php if($mdUserForm['email']->hasError()): echo $mdUserForm['email']->renderLabelName() .': '. $mdUserForm['email']->getError();  endif; ?></div>
            </div>
        </div>
    </form>
</div>
