<form method="post" action='<?php echo url_for('mdUserManagement/processMdUserWithPassportAjax'); ?>' id='md_user_with_passport_form_<?php echo $mdUserId ?>'>
    <?php //echo $form; ?>
    <?php echo $form->renderHiddenFields()?>
    <div class="md_open_object_top">
    <div class="md_blocks">
        <h2><?php echo __('mdUserDoctrine_text_username') ?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['mdPassport']['username']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['mdPassport']['username']->render(array('id'=>'input_nombre'));?>
        </div>
        <div><?php if($form['mdPassport']['username']->hasError()): echo $form['mdPassport']['username']->renderLabelName() .': '. $form['mdPassport']['username']->getError();  endif; ?></div>
        </div>
    </div>
    <div class="md_blocks">
        <h2><?php echo __('mdUserDoctrine_text_name') ?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['name']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['name']->render();?>
        </div>
        <div><?php if($form['name']->hasError()): echo $form['name']->renderLabelName() .': '. $form['name']->getError();  endif; ?></div>
    </div>
    <div class="clear"></div>
    <div class="md_blocks">
        <h2><?php echo __('mdUserDoctrine_text_lastname') ?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['last_name']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['last_name']->render();?>
        </div>
        <div><?php if($form['last_name']->hasError()): echo $form['last_name']->renderLabelName() .': '. $form['last_name']->getError();  endif; ?></div>
    </div>
    <div class="md_blocks">
        <h2><?php echo __('mdUserDoctrine_text_city') ?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['city']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['city']->render();?>
        </div>
        <div><?php if($form['city']->hasError()): echo $form['city']->renderLabelName() .': '. $form['city']->getError();  endif; ?></div>
    </div>
    <div class="clear"></div>
    <div class="md_blocks">
        <h2><?php echo __('mdUserDoctrine_text_country') ?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['country_code']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['country_code']->render(array('class' => 'md_small_select'));?>
        </div>
        <div><?php if($form['country_code']->hasError()): echo $form['country_code']->renderLabelName() .': '. $form['country_code']->getError();  endif; ?></div>
    </div>
    <input type="hidden" value="<?php echo $mdUserId; ?>" name="mdUserId" id="mdUserId"/>
</form>
