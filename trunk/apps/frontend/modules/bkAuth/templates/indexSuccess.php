						<div class="contenido_left">
        		<h1><?php echo __('Galeria_Titulo') ?></h1>
                <img src="/images/frontend/titl_galeria.jpg" class="titl" />
                <p><?php echo __('Galeria_Usuario no identificado') ?><a href="mailto:<?php echo __('Pie_email') ?>"><?php echo __('Pie_email') ?></a>.</p>
								<?php include_component('bkAuth', 'login', (isset($form)?array('form'=>$form):array())); ?>
            </div><!--CONTENIDO LEFT-->
            <div class="contenido_right">
            	<img src="/images/frontend/galeria.jpg" />
            </div><!--CONTENIDO RIGHT-->

