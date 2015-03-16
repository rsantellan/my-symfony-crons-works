<?php use_helper('I18N', 'Date', 'mdAsset') ?>
<?php include_partial('usuarios/assets') ?>

<link href="/css/imprimir.css" type="text/css" rel="stylesheet" media="print" />

<?php slot('usuarios'); ?>
<?php slot('nav') ?>Editar Usuario<?php end_slot(); ?>

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

<hr />

<?php include_component('progenitores', 'padres', array('usuario' => $usuario)); ?>

<hr />

<?php include_component('usuarios', 'hermanos', array('usuario' => $usuario)); ?>

<div class="clear" style="margin:20px"></div>
