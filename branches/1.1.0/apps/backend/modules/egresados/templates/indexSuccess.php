<?php use_helper('I18N', 'Date') ?>
<?php include_partial('egresados/assets') ?>

<?php slot('usuarios'); ?>
<?php slot('nav') ?>Egresados<?php end_slot(); ?>

<div id="sf_admin_container">
  <h3>Listado de egresados</h3>

  <?php include_partial('egresados/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('egresados/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('egresados/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('usuario_collection', array('action' => 'batch')) ?>" method="post">
    <ul class="sf_admin_actions">
      <?php include_partial('egresados/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('egresados/list_actions', array('helper' => $helper)) ?>
    </ul>
    <?php include_partial('egresados/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('egresados/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
