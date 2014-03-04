<?php die(" OBSOLETO "); ?>

<h6 class="no_padding_l">Editar Perfil</h6>
        <p class="modales">Sube una nueva imagen para mostrar. Completa / Modifica tu perfil.</p>
        <h5>Foto Perfil</h5>
        <hr />
        <img src="images/editar_avatar.jpg" class="avatar"/>
        <div>
        	<span>Sube una foto para que todos te conozcan</span>
            <p class="modales"><strong>Puedes cambiar tu imagen de perfil subiendo una nueva desde tu ordenador.</strong> La imagen debe ser en formato JPG, BMP, PNG o GIF y no mayor a 3MB.</p>
            <a  href="#" class="wrapper_bt float_left">Seleccionar archivo</a>
        </div>
        <div class="clear"></div>
<form action='<?php echo url_for('mdUserManagementFrontend/processNewMdUserProfileAjax'); ?>' method="post" id='user_new_form'>
    
    <?php //echo $form?>

	<?php echo $form->renderHiddenFields()?>
	<?php echo $form['id']->render()?>
	<?php ////echo $form?>
    <div class="abierto_top">
    	<input type="hidden" value="<?php echo $mdApplicationId?>" name="application"/>
    	<label>Usuario</label> <?php echo $form['mdPassport']['username']->render(array('id'=>'input_nombre'));?> <?php echo $form['mdPassport']['username']->renderError(); ?>
        <div class="clear"></div>
        
        <label>Password</label> <?php echo $form['mdPassport']['password']->render(array('id'=>'input_nombre'));?>
        <div class="clear"></div>
        <label>Repetir Password</label> <?php echo $form['mdPassport']['password_confirmation']->render(array('id'=>'input_nombre'));?>
        
        <div class="clear"></div>
        <label>Nombre</label> <?php echo $form['name']->render(array('id'=>'input_nombre'));?> <?php echo $form['name']->renderError(); ?>
        <div class="clear"></div>
        <label>Apellido</label> <?php echo $form['last_name']->render(array('id'=>'input_nombre'));?> <?php echo $form['last_name']->renderError(); ?>
        <div class="clear"></div>
        <label>Ciudad</label> <?php echo $form['city']->render(array('id'=>'input_nombre'));?> <?php echo $form['city']->renderError(); ?>
        <div class="clear"></div>
        <label>Pais</label> <?php echo $form['country_code']->render(array('id'=>'input_nombre'));?> <?php echo $form['country_code']->renderError(); ?>
        <div class="clear"></div>
        <label>Email</label> <?php echo $form['mdPassport']['mdUser']['email']->render(array('id'=>'input_nombre'));?> <?php echo $form['mdPassport']['mdUser']['email']->renderError(); ?>
    	<div class="clear"></div>                                	
	</div><!--ABIERTO TOP-->

        <div class="bloques">
        <?php echo $form['mdAttributes']; ?>
        </div>

        <div class="clear"></div>
    

        <div class="md_object_save">
            <a href="javascript:void(0);" onclick="return registerUser()">GUARDAR</a>
        </div>
</form>