<div class="cuentaContainer">
  Referencia: <?php echo $cuenta->getReferenciabancaria();?>
  <br/>
  Resumen de la cuenta: $<?php echo $cuenta->getFormatedDiferencia();?>
  <?php //var_dump($cuenta->toArray())?>
</div>
<hr/>
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