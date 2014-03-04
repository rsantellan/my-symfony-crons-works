<?php

	use_helper( 'JavascriptBase' );
	use_javascript('prototype');
?>
<div id ='div_registro'>
<div id="registro">
        	<h2>Registro</h2>
            <div class="clear"></div>
            <div class="datos_registro">
            	<form action="<?php echo url_for('mdUserManagementFrontend/registerMinimunUserAjax') ?>" method="post" id='register_form_user'>
                <?php echo $form->renderHiddenFields()?>
                <?php echo $form['md_application_id']->render(array('value'=> $sf_user->getMdApplication()->getId()))?>
                <label>Nombre: <?php echo __('mdBasic_text_managementFrontendRegisterName')?></label>
                <?php echo $form['name']->render(array('id'=>'Nombre_registro'))?> <?php echo $form['name']->renderError()?>
                <div class="clear"></div>
                <label>Usuario: <?php echo __('mdBasic_text_managementFrontendRegisterUser')?></label>
                <?php echo $form['username']->render(array('id'=>'Username_registro'))?> <?php echo $form['username']->renderError()?>
                <div class="clear"></div>
                <label>Apellido: <?php echo __('mdBasic_text_managementFrontendRegisterLastName')?></label>
                <?php echo $form['last_name']->render(array('id'=>'Apellido_registro'))?> <?php echo $form['last_name']->renderError()?>
                <div class="clear"></div>
                <label>E-mail: <?php echo __('mdBasic_text_managementFrontendRegisterEmail')?></label>
                <?php echo $form['email']->render(array('id'=>'Email_regsitro'))?> <?php echo $form['email']->renderError()?>
                <div class="clear"></div>
                <label>Contrase&ntilde;a: <?php echo __('mdBasic_text_managementFrontendRegisterPassword')?></label>
                <?php echo $form['password']->render(array('id'=>'Pass_registro'))?> <?php echo $form['password']->renderError()?>
                <div class="clear"></div>
                <label>Repetir Contrase&ntilde;a: <?php echo __('mdBasic_text_managementFrontendRegisterRepeat_password')?></label>
                <?php echo $form['password_confirmation']->render(array('id'=>'rePass_registro'))?> <?php echo $form['password_confirmation']->renderError()?>
                <div class="clear"></div>
                </form>
            </div>
            <div class="clear"></div>
            <div id="login_error"></div>
            <div class="clear"></div>
        	<div class="botones_log">
                  <div class="botones_left">
                  </div>
                  <div class="botones_center">
                  <a href="javascript:void(0);" onclick='return sendRegisterForm()'>REGISTRARSE</a>
                  </div>
                  <div class="botones_right">
                  </div>
           </div>
        </div>
</div>
<?php echo javascript_tag("

	function sendRegisterForm(){
	
		var form = 'register_form';
    	$(form).request({
        	onSuccess: function(response){
            	var json=response.responseText.evalJSON();
            	var results = new \$H(json);
            	if(results.get('result') == 1){
                	//$('div_registro').update(results.get('body'));
            	}else{
            		//location.reload();
            	}
        	}
    	});
    	return false;
	
	}



");?>