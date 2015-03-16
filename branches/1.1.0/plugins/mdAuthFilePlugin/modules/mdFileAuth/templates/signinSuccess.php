<?php use_helper('I18N') ?>
<div id="md_login_form">
<form action="<?php echo url_for('mdFileAuth/signin') ?>" method="post">
<ul>
	<li><?php echo $form->renderHiddenFields()?></li>
	<li><?php echo $form['username']->renderLabel(__('mdAuthFile_text_username'))?><?php echo $form['username']->render()?> <?php echo $form['username']->renderError()?></li>
	<li><?php echo $form['password']->renderLabel(__('mdAuthFile_text_password'))?> <?php echo $form['password']->render()?> <?php echo $form['password']->renderError()?></li>
	<li><?php echo $form->renderGlobalErrors()?></li>
</ul>
<input type="submit" value="<?php echo __('mdAuthFile_text_login') ?>" />
</form>
	
<?php if(!empty($exception)): ?>
<h3><?php echo $exception; ?></h3>
<?php endif; ?>	
</div>
