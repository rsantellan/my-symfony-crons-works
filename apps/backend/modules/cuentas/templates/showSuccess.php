<div class="cuentaContainer">
  <?php var_dump($cuenta->toArray())?>
</div>
<div id="facturasContainer" class="facturasContainer">
  <?php foreach($facturas as $factura): ?>
    <?php include_partial('cuentas/facturaDetalle', array('factura' => $factura)); ?>
  <?php endforeach; ?>
</div>
<div class="cobrosContainer">
  <?php foreach($cobros as $cobro):
    var_dump($cobro->toArray());
  endforeach;
  ?>
</div>