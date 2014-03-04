<form action='<?php echo url_for('mdUserManagement/processNewMdUserProfileAjaxToPassport'); ?>' method="post" id='user_new_profile_form_<?php echo $mdUserId; ?>'>
    <?php echo $form->renderHiddenFields() ?>
<?php foreach($form as $field):
    if(!$field->isHidden()):
?>
        <div class="md_blocks">
            <h2><?php echo $field->renderLabelName();?></h2>
            <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($field->hasError()):?>error_msg<?php endif; ?>">
                <?php echo $field->render()?>
            </div>
            <div><?php if($field->hasError()):  echo $field->renderLabelName() .': '. $field->getError(); endif; ?></div>
        </div>
<?php
    endif;
endforeach;?> 
    <div class="clear"></div>
    <div style="float: right" id="md_user_save_cancel_button">
        <input type="hidden" name="mdUserId" value="<?php echo $mdUserId; ?>" />
        <input type="hidden" name="mdProfileId" value="<?php echo $mdProfileId; ?>" />
        
        <input type="button" value="<?php echo __('mdUserDoctrine_text_save') ?>"  onclick="mdUserManagement.getInstance().saveNewProfile(<?php echo $mdUserId; ?>);"/>
    <div/>
    <div class="clear"></div>
</form>
<div class="clear"></div>
<script type="text/javascript">
    $(function() {
		$( "input:button, a", "#md_user_save_cancel_button" ).button();
    });
</script>
