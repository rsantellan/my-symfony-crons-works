<?php use_helper('I18N', 'Date') ?>
<?php include_partial('progenitores/assets') ?>

<?php slot('progenitores'); ?>
<?php slot('nav') ?>Padres<?php end_slot(); ?>

<div id="sf_admin_container">
  <h1>Editar padre</h1>

  <?php include_partial('progenitores/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('progenitores/form_header', array('progenitor' => $progenitor, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('progenitores/form', array('progenitor' => $progenitor, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('progenitores/form_footer', array('progenitor' => $progenitor, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
