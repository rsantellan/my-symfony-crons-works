<?php slot('pagos'); ?>
<?php slot('nav') ?>Pagos de la cuenta<?php end_slot(); ?>
<?php use_stylesheet('rodrigosantellan.css', 'last');?>
<?php use_helper('mdAsset');?>
<?php use_plugin_stylesheet('mastodontePlugin', '../js/jquery-ui-1.8.4/css/smoothness/jquery-ui-1.8.4.custom.css') ?>
<?php use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-ui-1.8.4.custom.min.js', 'last') ?>

<div class="cuentaContainer">
  <label>
    Referencia: <?php echo $cuenta->getReferenciabancaria();?>
  </label>
  <div class="clear"></div>
  <label>
    Resumen de la cuenta: $<?php echo $cuenta->getFormatedDiferencia();?>
  </label>
</div>
<hr/>
<div class="facturasCobrosContainer">
  
  <div class="facturasContainer">
    <h2>Listado de facturas</h2>
    <div id="facturasContainer">
      <?php foreach($facturas as $factura): ?>
        <?php include_partial('cuentas/facturaDetalle', array('factura' => $factura)); ?>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="cobrosContainer">
    <h2>Listado de pagos</h2>
    <table class="hor-minimalist-b">
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Monto</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $counter = 0;
        foreach($cobros as $cobro):
          ?>
        <tr class="<?php echo ($counter % 2 == 0)? 'odd' : '';?>">
          <td><?php echo format_date($cobro->getFecha(), 'D'); ?></td>
          <td>$<?php echo $cobro->getFormatedMonto();?></td>
        </tr>
        <?php
          $counter ++;
        endforeach;
        ?>
      </tbody>
    </table>
  </div>
</div>

<script type="text/javascript">
$(function() {
  $('#facturasContainer').accordion({
    collapsible: true,
    active: false
  });
});

function confirmCancelar(mUrl)
{
  if(confirm('¿Esta seguro de querer cancelar la factura?'))
  {
    mdShowLoading();
    $.ajax({
        url: mUrl,
        type: 'post',
        dataType: 'json',
        success: function(json){
            if(json.response == "OK")
            {
              $('#factura_title_'+json.options.facturaId).remove();
              $('#factura_body_'+json.options.facturaId).remove();
              $('#facturasContainer').accordion("refresh");
            }
            mdShowMessage(json.options.message);
        }, 
        complete: function()
        {
          mdHideLoading();
        }
      });
    return false;
  }
}
</script>