<?php use_helper('I18N', 'Date') ?>
<?php include_partial('usuarios/assets') ?>

<?php slot('usuarios'); ?>
<?php slot('nav') ?>Crear Usuario<?php end_slot(); ?>

<div id="sf_admin_container2">
  
  <?php include_partial('usuarios/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('usuarios/form_header', array('usuario' => $usuario, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content2">
    <?php include_partial('usuarios/form', array('usuario' => $usuario, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('usuarios/form_footer', array('usuario' => $usuario, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
