<?php use_helper('I18N', 'Date') ?>
<?php include_partial('emails/assets') ?>

<?php slot('emails'); ?>
<?php slot('nav') ?>Editar Configuracion<?php end_slot(); ?>

<div id="sf_admin_container">
  <h1><?php echo ''; ?></h1>

  <?php include_partial('emails/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('emails/form_header', array('emails' => $emails, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('emails/form', array('emails' => $emails, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('emails/form_footer', array('emails' => $emails, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
