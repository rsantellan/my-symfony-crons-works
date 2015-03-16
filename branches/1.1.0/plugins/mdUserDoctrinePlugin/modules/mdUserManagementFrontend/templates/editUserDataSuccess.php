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
<hr/>
<div>
  <form method="post" action="<?php echo url_for('mdUserManagementFrontend/changeUsernameAndEmail')?>" onsubmit="return false;">
    <?php echo $emailAndUserForm->renderHiddenFields() ?>
    <label><?php echo __('usuario_username');?></label> <?php echo $emailAndUserForm['username']->render();?> <?php echo $emailAndUserForm['username']->renderError(); ?>
    <div class="clear"></div>
    <label><?php echo __('usuario_email');?></label> <?php echo $emailAndUserForm['mdUser']['email']->render();?> <?php echo $emailAndUserForm['mdUser']['email']->renderError(); ?>
    <input type="submit" value="<?php echo __('usuario_enviar');?>"/>
  </form>
</div>

<hr/>
<div>
  <form method="post" action="<?php echo url_for('mdUserManagementFrontend/changePassword')?>" onsubmit="return false;">
    <?php echo $passwordForm->renderHiddenFields() ; ?>
    <label><?php echo __('usuario_password');?></label> <?php echo $passwordForm['password']->render();?><?php echo $passwordForm['password']->renderError(); ?>
    <div class="clear"></div>
    <label><?php echo __('usuario_password_confirmation');?></label> <?php echo $passwordForm['password_confirmation']->render();?><?php echo $passwordForm['password_confirmation']->renderError(); ?>
    <div class="clear"></div>
    <input type="submit" value="<?php echo __('usuario_enviar');?>"/>
  </form>
</div>
<hr/>
<div>
  <form method="post" action="<?php echo url_for('mdUserManagementFrontend/saveSimpleUserProfile')?>" onsubmit="return false;">
    <?php echo $mdUserProfile->renderHiddenFields(); ?>
    <label><?php echo __('usuario_name');?></label> <?php echo $mdUserProfile['name']->render(array('id'=>'input_nombre'));?> <?php echo $mdUserProfile['name']->renderError(); ?>
    <div class="clear"></div>
    <label><?php echo __('usuario_last_name');?></label> <?php echo $mdUserProfile['last_name']->render(array('id'=>'input_nombre'));?> <?php echo $mdUserProfile['last_name']->renderError(); ?>
    <div class="clear"></div>
    <label><?php echo __('usuario_city');?></label> <?php echo $mdUserProfile['city']->render(array('id'=>'input_nombre'));?> <?php echo $mdUserProfile['city']->renderError(); ?>
    <div class="clear"></div>
    <label><?php echo __('usuario_country');?></label> <?php echo $mdUserProfile['country_code']->render(array('id'=>'input_nombre'));?> <?php echo $mdUserProfile['country_code']->renderError(); ?>
    <div class="clear"></div>
    <input type="submit" value="<?php echo __('usuario_enviar');?>"/>
  </form>
</div>

