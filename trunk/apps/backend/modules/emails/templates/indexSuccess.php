<?php use_helper('I18N', 'Date') ?>
<?php include_partial('emails/assets') ?>

<?php slot('emails'); ?>
<?php slot('nav') ?>Configuracion del e-mail para el Newsletter<?php end_slot(); ?>

<div id="sf_admin_container">
  <h1><?php echo 'Configuracion' ?></h1>

  <?php include_partial('emails/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('emails/list_header', array('pager' => $pager)) ?>
  </div>


  <div id="sf_admin_content">
    <?php include_partial('emails/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('emails/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('emails/list_actions', array('helper' => $helper)) ?>
    </ul>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('emails/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
