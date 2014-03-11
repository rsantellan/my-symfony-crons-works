<?php use_helper('I18N', 'Date') ?>
<?php include_partial('descuentos/assets') ?>

<?php slot('settings'); ?>
<?php slot('nav') ?>Descuentos<?php end_slot(); ?>

<div id="sf_admin_container">
  <h3><?php echo __('Descuentos_Descuentos List', array(), 'messages') ?></h3>

  <?php include_partial('descuentos/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('descuentos/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('descuentos_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('descuentos/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('descuentos/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('descuentos/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('descuentos/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
