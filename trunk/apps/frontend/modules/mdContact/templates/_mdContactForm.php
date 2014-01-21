<div class="contenido_left">
			<h1><?php echo __('Contacto_Titulo') ?></h1>
      <img src="/images/frontend/titl_contacto.jpg" class="titl" />
      <p><?php echo __('Contacto_Texto') ?></p>
      <form name="<?php echo $form->getName();?>" method="POST" action="<?php echo url_for('@contacto') ?>">
        <?php echo $form->renderHiddenFields() ?>
				<?php echo $form['nombre']->renderLabel() ?><?php echo $form['nombre']->render(array('class'=>'contact' . ($form['nombre']->hasError()?' input_error':''))) ?>
				<?php echo $form['apellido']->renderLabel() ?><?php echo $form['apellido']->render(array('class'=>'contact' . ($form['apellido']->hasError()?' input_error':''))) ?>
				<?php echo $form['email']->renderLabel() ?><?php echo $form['email']->render(array('class'=>'contact' . ($form['email']->hasError()?' input_error':''))) ?>
				<?php echo $form['telefono']->renderLabel() ?><?php echo $form['telefono']->render(array('class'=>'contact' . ($form['telefono']->hasError()?' input_error':''))) ?>
				<?php echo $form['mensaje']->renderLabel() ?><?php echo $form['mensaje']->render(array('class'=>'textarea_contacto' . ($form['mensaje']->hasError()?' input_error':''), 'rows'=>3)) ?>
       	<input type="submit" class="input_submit submit_contacto" value="<?php echo __('Contacto_Enviar') ?>" />

				<div class="clear"></div>
				<!-- MENSAJE ENVIADO -->
				<?php if($sf_user->hasFlash('mdContactSend') and $sf_user->getFlash('mdContactSend') == true): ?>
				<h1 class="success"><?php echo __('Contacto_Mensaje Enviado') ?></h1>
				<?php endif; ?>
				<!-- FORM ERRORS -->
				<?php echo $form->renderGlobalErrors() ?>
				<?php foreach($form->getFormattedErrors() as $error): ?>
					<p class="error"><?php echo $error ?></p>
				<?php endforeach; ?>
				<?php if($sf_user->hasFlash('mdContactSend') and $sf_user->getFlash('mdContactSend') !== true): ?><p>Error al enviar el mensaje. Intente nuevamente mas tarde.</p><?endif;?>

      </form>
  </div><!--CONTENIDO LEFT-->
  <div class="contenido_right">
  	<img src="/images/frontend/contacto.jpg" />
      <ul class="info_contact">
      	<li><img src="/images/frontend/icono_home.jpg" /></li>
          <li><?php echo __('Contacto_Info Direccion') ?></li>
          <li><?php echo __('Contacto_Info Ciudad') ?></li>
      	<li><img src="/images/frontend/icono_tel.jpg" /></li>
          <li><?php echo __('Contacto_Info Telefono') ?></li>
      	<li><img src="/images/frontend/icono_mail.jpg" /></li>
          <li><a href="mailto:<?php echo __('Pie_email') ?>"><?php echo __('Pie_email') ?></a></li>
      </ul>
  </div><!--CONTENIDO RIGHT-->