<a href="javascript:void(0)" onclick="return changeEmail('<?php echo url_for("mdAuth/changeEmailAjax");?>')">Cambiar email</a>
<a href="javascript:void(0)" onclick="return changePassword('<?php echo url_for("mdAuth/changePasswordAjax");?>')">Cambiar Contraseña</a>
<form action='<?php echo url_for('mdUserManagementFrontend/processEditUser'); ?>' method="post" id='user_new_form'>
    
    <?php //echo $form?>

	<?php echo $form->renderHiddenFields()?>
	<?php echo $form['id']->render()?>
        <div class="clear"></div>
        <label>Nombre</label> <?php echo $form['name']->render(array('id'=>'input_nombre'));?> <?php echo $form['name']->renderError(); ?>
        <div class="clear"></div>
        <label>Apellido</label> <?php echo $form['last_name']->render(array('id'=>'input_nombre'));?> <?php echo $form['last_name']->renderError(); ?>
        <div class="clear"></div>
        <label>Ciudad</label> <?php echo $form['city']->render(array('id'=>'input_nombre'));?> <?php echo $form['city']->renderError(); ?>
        <div class="clear"></div>
        <label>Pais</label> <?php echo $form['country_code']->render(array('id'=>'input_nombre'));?> <?php echo $form['country_code']->renderError(); ?>
        <div class="clear"></div>
        </div><!--ABIERTO TOP-->

        <div class="bloques">
        <?php echo $form['mdAttributes']; ?>
        </div>

        <div class="clear"></div>
</form>
<?php if( sfConfig::get( 'sf_plugins_user_attributes', false ) ):  ?>
    <?php $profiles = $form->getObject()->getAllUsedProfiles();?>
    <?php foreach($profiles as $prof):?>
        <?php $profForm = $form->getObject()->getAttributesFormOfMdProfile($prof->getMdProfile()->getName()); ?>
        <?php include_partial('md_profile_form_container', array('form'=>$profForm,'name'=> $prof->getMdProfile()->getDisplay(), 'mdProfileId' => $prof->getMdProfile()->getId(), 'mdUserProfileId' => $form->getObject()->getId() )) ?>
    <?php endforeach;?>

<?php endif; ?>
<div class="md_object_save">
    <a href="javascript:void(0);" onclick="return editUserData()">GUARDAR</a>
</div>
<a href="javascript:void(0)" onclick="return cancelEditUser('<?php echo url_for('mdUserManagementFrontend/retrieveSmallInfo');?>')">Cancelar</a>
<input type="hidden" value="<?php echo url_for('mdUserManagementFrontend/retrieveSmallInfo');?>" id="cancel_edit_user" />