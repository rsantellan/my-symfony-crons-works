<?php if ($sf_user->hasFlash('notice')): ?>
  <div class="notice"><?php echo __('Inicio_' . $sf_user->getFlash('notice')); ?></div>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error')): ?>
  <div class="error"><?php echo __('Inicio_' . $sf_user->getFlash('error')); ?></div>
<?php endif; ?>
  
<div class="contenido_left">
  <h1>Activaci&oacute;n de cuenta</h1>
  <img src="/images/titl_galeria.jpg" class="titl" />

  <form action="<?php echo url_for('@activation?code=1'); ?>" method="POST">
    <?php echo $form->renderHiddenFields(); ?>  
  
    <label>Contrase&ntilde;a</label>
    <?php echo $form['password']->render(array('class' => 'short input_gal')); ?>
    <div class="clear"></div>
    
    <label>Confirmar Contrase&ntilde;a</label>
    <?php echo $form['password_confirmation']->render(array('class' => 'short input_gal')); ?>
    <div class="clear"></div>
    
    <input type="submit" class="input_submit submit_gal" value="guardar" />
  </form>
  
  <div class="clear"></div>
  
  <?php if($form->hasErrors()): ?>
    <?php foreach($form->getFormattedErrors() as $error): ?>
	<p class="error"><?php echo $error; ?></p>
	<div class="clear"></div>
    <?php endforeach; ?>
  <?php endif; ?>
</div><!--CONTENIDO LEFT-->

<div class="contenido_right">
  <img src="/images/galeria.jpg" />
</div><!--CONTENIDO RIGHT-->
