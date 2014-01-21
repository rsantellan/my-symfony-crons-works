<?php use_helper('I18N') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form)?>

<div id="algo">
<form action="<?php echo url_for('mdAuth/signin') ?>" method="post" id="form_login">
 <?php echo $form->renderHiddenFields(); ?>
 <div class="col_3">
 	<div class="box_1">
     	<ul class="bhead">
         	<li>Ingresar</li>
         </ul>
        	<div class="bcont">
        		<label for="login_username">Usuario</label><?php echo $form['username']->render(); ?><div class="clear"></div>
				<label for="login_password">Contrase&ntilde;a</label><?php echo $form['password']->render(); ?><div class="clear"></div>
				<label for="signin_remember">Remember</label> <?php echo $form['remember']->render(); ?><div class="clear"></div>
				<?php if($uriToGo):?>
					<input type="hidden" value="<?php echo $uriToGo?>" name="uriToGo"/>
				<?php endif;?>
				<input type="submit" value="Entrar" class="enviar"/>
			</div>
   </div>
 </div>
</div>
</form> 

</div>