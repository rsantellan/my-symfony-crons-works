<?php if(isset($error)): ?>
<div>
    <span class ="error"><?php echo $error;?></span>
</div>
<div class="clear"></div>
<?php endif;?>
<form action='<?php echo url_for('mdUserManagement/processNewMdUserProfileAjax'); ?>' onsubmit="mdUserManagement.getInstance().submitNewMdUserProfileForm('<?php echo url_for('mdUserManagement/closedBox')?>'); return false;" method="post" id='user_new_form'>
    <?php echo $form->renderHiddenFields()?>
    <div class="abierto_top">
    	<?php include_partial('user_info', array('form'=>$form, 'randomPassword' => $randomPassword)); ?>
	</div><!--ABIERTO TOP-->
    <?php if( sfConfig::get( 'sf_plugins_user_attributes', false ) ):  ?>
        <?php include_partial('md_profile_form', array('form' => $form));?>
    <?php endif; ?>
    <div class="clear"></div>

    <?php use_helper('mdAsset'); ?>
    <div style="float: right">
        <input type="submit" value="<?php echo __('mdUserDoctrine_text_save') ?>" />
        <a onclick="mastodontePlugin.UI.BackendBasic.getInstance().removeNew();"><?php echo __('mdUserDoctrine_text_cancel') ?></a>

    </div>
    <div class="clear"></div>
</form>

<script type="text/javascript">
    $(function() {
		$( "input:submit, a", "#user_new_form" ).button();
    });
</script>
