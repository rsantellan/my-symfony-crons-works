<?php use_helper('I18N', 'Date') ?>
<?php include_partial('pagos/assets') ?>

<?php slot('pagos'); ?>
<?php slot('nav') ?>Pagos<?php end_slot(); ?>

<div id="sf_admin_container">
  <h3><?php echo __('Pagos_Pagos List', array(), 'messages') ?></h3>

  <?php include_partial('pagos/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('pagos/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('pagos/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('pagos_collection', array('action' => 'batch')) ?>" method="post">
    <ul class="sf_admin_actions">
      <?php include_partial('pagos/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('pagos/list_actions', array('helper' => $helper)) ?>
    </ul>
    <?php include_partial('pagos/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>      
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('pagos/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
