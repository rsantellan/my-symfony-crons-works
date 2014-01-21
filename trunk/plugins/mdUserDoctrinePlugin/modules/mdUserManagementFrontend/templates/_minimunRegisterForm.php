<div id ='div_registro'>
    <div id="registro">
        	<h2>Registro</h2>
            <div class="clear"></div>
            <div class="datos_registro">
                <form action="<?php echo url_for('mdUserManagementFrontend/registerMinimunAjax') ?>" onsubmit="sendRegisterForm(); return false;" method="post" id='register_form'>
                    <?php echo $form->renderHiddenFields()?>
                    <?php echo $form['md_application_id']->render(array('value' => $sf_user->getMdApplication()->getId()))?>
                    <?php echo $form['name']->renderError()?>
                    <label>Nombre: <?php //echo __('mdBasic_text_managementFrontendRegisterName')?></label>
                    <?php echo $form['name']->render(array('id'=>'Nombre_registro'))?>
                    <div class="clear"></div>
                    <?php echo $form['last_name']->renderError()?>
                    <label>Apellido: <?php //echo __('mdBasic_text_managementFrontendRegisterLastName')?></label>
                    <?php echo $form['last_name']->render(array('id'=>'Apellido_registro'))?>
                    <div class="clear"></div>
                    <?php echo $form['email']->renderError()?>
                    <label>E-mail: <?php //echo __('mdBasic_text_managementFrontendRegisterEmail')?></label>
                    <?php echo $form['email']->render(array('id'=>'Email_regsitro'))?>
                    <div class="clear"></div>
                    <?php echo $form['password']->renderError()?>
                    <label>Contrase&ntilde;a: <?php //echo __('mdBasic_text_managementFrontendRegisterPassword')?></label>
                    <?php echo $form['password']->render(array('id'=>'Pass_registro'))?>
                    <div class="clear"></div>
                    <?php echo $form['password_confirmation']->renderError()?>
                    <label>Repetir Contrase&ntilde;a: <?php //echo __('mdBasic_text_managementFrontendRegisterRepeatPassword')?></label>
                    <?php echo $form['password_confirmation']->render(array('id'=>'rePass_registro'))?>
                    <div class="clear"></div>
                    <div class="clear"></div>
                    <div class="botones_log">
                          <div class="botones_left">
                          </div>
                          <div class="botones_center">
                            <input type="image" value="REGISTRARSE" />
                          </div>
                          <div class="botones_right">
                          </div>
                   </div>
                </form>
            </div>
            
        </div>
</div>