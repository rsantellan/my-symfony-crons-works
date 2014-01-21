<?php use_helper('I18N', 'Date') ?>
<?php include_partial('costos/assets') ?>

<?php slot('settings'); ?>
<?php slot('nav') ?>Costos<?php end_slot(); ?>

<div id="sf_admin_container">
  <h3><?php echo __('Costos_Costos List', array(), 'messages') ?></h3>

  <?php include_partial('costos/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('costos/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('costos_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('costos/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('costos/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('costos/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('costos/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
