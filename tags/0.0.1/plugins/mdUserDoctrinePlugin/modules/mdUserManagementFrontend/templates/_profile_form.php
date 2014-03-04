<form class="md_profile_form_class" id="user_new_profile_<?php echo $mdProfileId; ?>" action="<?php echo url_for('mdUserManagementFrontend/saveProfileAjax'); ?>" method="post">
    <?php echo $form->renderHiddenFields() ?>
    <?php $index = 0; ?>
<?php foreach($form as $field):
    if(!$field->isHidden()):
?>
        <?php if($index == 2): ?>
            <div class="clear"></div>
            <?php $index = 0; ?>
        <?php endif;?>
        <div class="md_blocks">
            <h2><?php echo $field->renderLabelName();?></h2>
            <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($field->hasError()):?>error_msg<?php endif; ?>">
                <?php echo $field->render()?>
            </div>
            <div><?php if($field->hasError()):  echo $field->renderLabelName() .': '. $field->getError(); endif; ?></div>
        </div>
        <?php $index++; ?>
<?php
    endif;
endforeach;?>    
    <input type="hidden" value="<?php echo $mdUserProfileId; ?>" name="mdUserProfileId" />
    <input type="hidden" value="<?php echo $form->getName(); ?>" name="form_name" />
    <div class="clear"></div>
</form>
