<?php use_helper('I18N', 'Date') ?>
<?php include_partial('pagos/assets') ?>

<?php slot('pagos'); ?>
<?php slot('nav') ?>Crear Pago<?php end_slot(); ?>

<div id="sf_admin_container">
  <h3><?php echo __('Pagos_New Pagos', array(), 'messages') ?></h3>

  <?php include_partial('pagos/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('pagos/form_header', array('pagos' => $pagos, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('pagos/form', array('pagos' => $pagos, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('pagos/form_footer', array('pagos' => $pagos, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
