<!-- Login form -->
<section class="full">					

  <h3>Login</h3>

  <?php if(isset($exception)): ?>
  <div class="box box-error"><?php echo $exception; ?></div>
  <?php else: ?>
  <div class="box box-info">Ingresa usuario y clave para ingresar</div>  
  <?php endif; ?>
  
  <form id="loginform" method="post" action="<?php echo url_for('mdFileAuth/signin') ?>">
    <?php echo $form->renderHiddenFields()?>
    <p>
      <label class="required" for="username">Usuario:</label><br/>
      <?php echo $form['username']->render(array('class' => 'full')); ?>
    </p>

    <p>
      <label class="required" for="password">Clave:</label><br/>
      <?php echo $form['password']->render(array('class' => 'full')); ?>
    </p>

    <p>
      <?php echo $form['remember']->render(array('value' => '1', 'type' => 'checkbox')); ?>
      <label class="choice" for="remember">Recordarme ?</label>
    </p>
    
    <p>
      <input type="submit" class="btn btn-green big" value="Ingresar"/> &nbsp; 
    </p>
    <div class="clear">&nbsp;</div>
  </form>

</section>
<!-- End of login form -->
