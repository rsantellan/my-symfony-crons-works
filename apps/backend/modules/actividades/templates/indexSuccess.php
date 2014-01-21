<?php use_helper('I18N', 'Date') ?>
<?php include_partial('actividades/assets') ?>

<?php slot('actividades'); ?>
<?php slot('nav') ?>Actividades<?php end_slot(); ?>

<div id="sf_admin_container">
  <h3><?php echo __('Actividades_Actividades List', array(), 'messages') ?></h3>

  <?php include_partial('actividades/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('actividades/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('actividades/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('actividades_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('actividades/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('actividades/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('actividades/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('actividades/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
