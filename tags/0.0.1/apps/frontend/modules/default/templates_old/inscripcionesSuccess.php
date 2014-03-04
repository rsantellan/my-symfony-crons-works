<div class="contenido_left">
	<h1><?php echo __('Inscripciones_Titulo') ?></h1>
      <img src="/images/frontend/titl_inscripciones.jpg" class="titl" />
      <p><?php echo __('Inscripciones_Texto') ?></p>
      <form name="<?php echo $form->getName();?>" method="POST" action="<?php echo url_for('@inscripciones') ?>">
      <?php echo $form->renderHiddenFields() ?>
      	<div class="form_left">
						<?php echo $form['nombre']->renderLabel() ?><?php echo $form['nombre']->render(array('class'=>'short input_inscripciones' . ($form['nombre']->hasError()?' input_error':''))) ?><div class="clear"></div>
						<?php echo $form['ano']->renderLabel() ?><?php echo $form['ano']->render(array('class'=>'short input_inscripciones' . ($form['ano']->hasError()?' input_error':''))) ?><div class="clear"></div>
						<?php echo $form['nacimiento']->renderLabel() ?><?php echo $form['nacimiento']->render(array('class'=>'short input_inscripciones' . ($form['nacimiento']->hasError()?' input_error':''))) ?><div class="clear"></div>
						<?php echo $form['direccion']->renderLabel() ?><?php echo $form['direccion']->render(array('class'=>'short input_inscripciones' . ($form['direccion']->hasError()?' input_error':''))) ?><div class="clear"></div>
          </div>
          <div class="form_right">
						<?php echo $form['apellido']->renderLabel() ?><?php echo $form['apellido']->render(array('class'=>'short input_inscripciones' . ($form['apellido']->hasError()?' input_error':''))) ?><div class="clear"></div>
						<?php echo $form['horario']->renderLabel() ?><?php echo $form['horario']->render(array('class'=>'short input_inscripciones' . ($form['horario']->hasError()?' input_error':''))) ?><div class="clear"></div>
						<?php echo $form['colegio']->renderLabel() ?><?php echo $form['colegio']->render(array('class'=>'short input_inscripciones' . ($form['colegio']->hasError()?' input_error':''))) ?><div class="clear"></div>
						<?php echo $form['telefono']->renderLabel() ?><?php echo $form['telefono']->render(array('class'=>'short input_inscripciones' . ($form['telefono']->hasError()?' input_error':''))) ?><div class="clear"></div>
          </div>
          <div class="clear"></div>
					<?php echo $form['mensaje']->renderLabel() ?><?php echo $form['mensaje']->render(array('class'=>'textarea_inscripciones' . ($form['mensaje']->hasError()?' input_error':''), 'rows'=>4)) ?>
          <input type="submit" class="input_submit submit_inscripciones" value="<?php echo __('Inscripciones_Enviar') ?>" tabindex="10" />
					<div class="clear"></div>
					<!-- MENSAJE ENVIADO -->
					<?php if(isset($message_send) and $message_send == true): ?>
					<h1 class="success"><?php echo __('Inscripciones_Mensaje Enviado') ?></h1>
					<?php endif; ?>
					<!-- FORM ERRORS -->
					<?php echo $form->renderGlobalErrors() ?>
					<?php foreach($form->getFormattedErrors() as $error): ?>
						<p class="error"><?php echo $error ?></p>
					<?php endforeach; ?>
					<?php if(isset($message_send) and $message_send == false): ?><p>Error al enviar el mensaje. Intente nuevamente mas tarde.</p><?php endif;?>
      </form>
  </div><!--CONTENIDO LEFT-->
  <div class="contenido_right">
  	<img src="/images/frontend/inscripciones.jpg" />
  </div><!--CONTENIDO RIGHT-->