<h3 id="factura_title_<?php echo $factura->getId();?>">
  <span class="facturaTitleSpan">
  <?php echo sprintf('Factura del %s/%s', $factura->getMonth(), $factura->getYear())?> | 
  <br/>
  <?php echo sprintf('Enviado: %s, Cancelado: %s, Pago: %s', ($factura->getEnviado() == 1) ? 'Si' : 'No',($factura->getCancelado() == 1) ? 'Si' : 'No', ($factura->getPago() == 1) ? 'Si' : 'No');?>
  </span>
  <div class="clear"></div>
  <a href='javascript:void(0)'  onclick="$('#factura_body_<?php echo $factura->getId();?>').toggle()">Ver</a>
</h3>
<div id="factura_body_<?php echo $factura->getId();?>" class="hidden">
  <table class="hor-minimalist-b">
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
        <td>$ <?php echo $facturaDetalle->getFormatedAmount();?></td>
      </tr>
      <?php
      endforeach;
      ?>
      <tr class="totales">
        <td>Total:</td>
        <td>$ <?php echo $factura->getFormatedTotal();?></td>
      </tr>
    </tbody>
  </table>
  
  <a href="javascript:void(0)" onclick="return confirmCancelar('<?php echo url_for('@cancelarfactura?id='.$factura->getId());?>');">Cancelar Factura</a>
</div>  