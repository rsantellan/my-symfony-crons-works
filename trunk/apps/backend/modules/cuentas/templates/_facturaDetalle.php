<h3>
  <?php echo sprintf('Factura del %s/%s', $factura->getMonth(), $factura->getYear())?>
  <br/>
  <?php echo sprintf('Estados. Enviado: %s, Cancelado: %s, Pago: %s', ($factura->getEnviado() == 1) ? 'Si' : 'No',($factura->getCancelado() == 1) ? 'Si' : 'No', ($factura->getPago() == 1) ? 'Si' : 'No');?>
</h3>
<div>
  <table>
    <thead>
      <tr>
        <th>Descripcion</th>
        <th>Saldo</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach($factura->getFacturaFinalDetalle() as $facturaDetalle):
      ?>
      <tr>
        <td><?php echo $facturaDetalle->getDescription();?></td>
        <td><?php echo $facturaDetalle->getAmount();?></td>
      </tr>
      <?php
      endforeach;
      ?>
    </tbody>
  </table>
</div>  