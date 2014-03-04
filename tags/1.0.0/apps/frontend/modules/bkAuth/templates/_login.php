
	<form action="<?php echo url_for("@login"); ?>" method="POST">

	  <?php echo $form->renderHiddenFields(); ?>

	  <?php echo $form['username']->renderLabel();?><?php echo $form['username']->render(array('class' => "short input_gal" . ($form['username']->hasError()?' input_error':''))); ?><div class="clear"></div>

	  <?php echo $form['password']->renderLabel();?><?php echo $form['password']->render(array('class' => "short input_gal" . ($form['password']->hasError()?' input_error':''))); ?><div class="clear"></div>

	  <input type="submit" class="input_submit submit_gal" value="<?php echo __('Usuarios_Ingresar') ?>" />

	</form>
  
  <div class="clear"></div>
  <?php if ($sf_user->hasFlash('notice')): ?>
  <div class="notice"><?php echo __('Usuarios_' . $sf_user->getFlash('notice')); ?></div>
  <?php endif; ?>

  <?php if ($sf_user->hasFlash('error')): ?>
  <div class="error"><?php echo __('Usuarios_' . $sf_user->getFlash('error')); ?></div>
  <?php endif; ?>
  
	<?php foreach($form->getFormattedErrors() as $error): ?>
	<p class="error"><?php echo $error; ?></p>
	<div class="clear"></div>
  <?php endforeach; ?>


