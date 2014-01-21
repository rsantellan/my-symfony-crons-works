<?php use_helper('I18N', 'Date') ?>
<?php include_partial('actividades/assets') ?>

<?php slot('actividades'); ?>
<?php slot('nav') ?>Crear Actividad<?php end_slot(); ?>

<div id="sf_admin_container">
  <h3><?php echo __('Actividades_New Actividades', array(), 'messages') ?></h3>

  <?php include_partial('actividades/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('actividades/form_header', array('actividades' => $actividades, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('actividades/form', array('actividades' => $actividades, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('actividades/form_footer', array('actividades' => $actividades, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
