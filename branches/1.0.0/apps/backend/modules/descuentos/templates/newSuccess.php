<?php use_helper('I18N', 'Date') ?>
<?php include_partial('descuentos/assets') ?>

<?php slot('settings'); ?>
<?php slot('nav') ?>Crear Descuento<?php end_slot(); ?>

<div id="sf_admin_container">
  <h3><?php echo __('Descuentos_New Descuentos', array(), 'messages') ?></h3>

  <?php include_partial('descuentos/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('descuentos/form_header', array('descuentos' => $descuentos, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('descuentos/form', array('descuentos' => $descuentos, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('descuentos/form_footer', array('descuentos' => $descuentos, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
