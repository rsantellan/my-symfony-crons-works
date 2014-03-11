<?php use_helper('I18N', 'Date') ?>
<?php include_partial('progenitores/assets') ?>

<?php slot('progenitores'); ?>
<?php slot('nav') ?>Padres<?php end_slot(); ?>

<div id="sf_admin_container">
  <h1>Listado de Padres</h1>

  <?php include_partial('progenitores/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('progenitores/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('progenitores/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('progenitor_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('progenitores/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('progenitores/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('progenitores/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('progenitores/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
