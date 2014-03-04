<?php use_helper('I18N', 'Date') ?>
<?php include_partial('costos/assets') ?>

<?php slot('settings'); ?>
<?php slot('nav') ?>Crear Costo<?php end_slot(); ?>

<div id="sf_admin_container">
  <h3><?php echo __('Costos_New Costos', array(), 'messages') ?></h3>

  <?php include_partial('costos/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('costos/form_header', array('costos' => $costos, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('costos/form', array('costos' => $costos, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('costos/form_footer', array('costos' => $costos, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
