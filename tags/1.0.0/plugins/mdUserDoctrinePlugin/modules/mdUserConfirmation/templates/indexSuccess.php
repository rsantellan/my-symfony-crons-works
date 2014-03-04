<h2>Resetear Password</h2><br/>
Username:  <?php echo $mdPassport->getUsername()?>
<br/>
<?php $mdUserProfile = $mdPassport->getMdUser()->getMdUserProfile(); ?>
Nombre:  <?php  if($mdUserProfile) echo $mdUserProfile->getName()?>
<br/>
Apellido:  <?php if($mdUserProfile) echo $mdUserProfile->getLastName()?>

<?php //echo $form; ?>

<div class="clear"></div>

<?php if($code == "3"){ ?>
<div>
<form action="<?php echo url_for('@confirm_user_password') ?>" id="reset_password_form" onsubmit="" method="post">
<ul>
	<li>
		<?php echo $form->renderHiddenFields()?>
		<input type="hidden" name="sf_method" value="put" />
	</li>
	<li>
		<?php echo $form['id']->render(array('value'=>$mdPassport->getId()));?>
	</li>
	<li> 
		Password: <?php echo $form['password']->render();?> <?php echo $form['password']->renderError();?>
	</li>
	<li>
		Re-Enter Password:<?php echo $form['password_confirmation']->render();?> <?php echo $form['password_confirmation']->renderError();?>
	</li>
	<li>
            <?php echo $form->renderGlobalErrors(); ?>
	</li>
        <li>
		<input type="submit" value="Ingresar"/>
        </li>
</ul>
</form>
</div>
<hr/>
<?php 
}else {

        switch($this->error){
            case 1: $error = 'El tiempo expiro tendria que tirar una excepcion.';
                break;
            case 2: $error = 'El codigo de confirmacion es incorrecto. Se le ha reseteado el codigo nuevamente';
                break;
        }
?>
    <hr/><?php echo $error; ?><hr/>

<?php } ?>
