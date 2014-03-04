<div id="md_user_profile_edit_div_<?php echo $form->getObject()->getId() ?>">
    <form action='<?php echo url_for('mdUserManagement/processMdUserProfileAjax'); ?>' method="post" id='md_user_profile_edit_form_<?php echo $form->getObject()->getId() ?>'>
        <?php echo $form->renderHiddenFields()?>
        <div class="clear"></div>
            <div class="md_open_object_top">
                <div class="md_blocks">
                    <h2><?php echo __('mdUserDoctrine_text_name') ?></h2>
                    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['name']->hasError()):?>error_msg<?php endif; ?>">
                        <?php echo $form['name']->render();?>
                    </div>
                    <div><?php if($form['name']->hasError()): echo $form['name']->renderLabelName() .': '. $form['name']->getError();  endif; ?></div>
                </div>
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
                        <?php if( sfConfig::get( 'sf_plugins_user_manage_country_and_city_widget', false ) ): ?>
                          <input type="hidden" id="user_city_value" value="<?php echo $form['city']->getValue();?>"/>
                        <?php endif;?>
                    </div>
                    <div>
                      <?php if($form['city']->hasError()): echo $form['city']->renderLabelName() .': '. $form['city']->getError();  endif; ?>
                    </div>
                </div>
                <div class="md_blocks">
                    <h2><?php echo __('mdUserDoctrine_text_country') ?></h2>
                    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['country_code']->hasError()):?>error_msg<?php endif; ?>">
                        <?php echo $form['country_code']->render(array('class' => 'md_small_select'));?>
                    </div>
                    <div><?php if($form['country_code']->hasError()): echo $form['country_code']->renderLabelName() .': '. $form['country_code']->getError();  endif; ?></div>
                </div>
            </div>
    <?php if( sfConfig::get( 'sf_plugins_user_attributes', false ) ):  ?>
         <?php include_partial('md_profile_form', array('form' => $form));?>
    <?php endif; ?>
    </form>
</div>
