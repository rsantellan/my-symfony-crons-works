<?php use_helper('I18N', 'Date') ?>

<link href="/css/imprimir.css" type="text/css" rel="stylesheet" media="print" />

<?php slot('alertas'); ?>
<?php slot('nav') ?>Alertas<?php end_slot(); ?>

<?php 
/*
$meses = array(
  '1' => 'Enero',
  '2' => 'Febrero',
  '3' => 'Marzo',
  '4' => 'Abril',
  '5' => 'Mayo',
  '6' => 'Junio',
  '7' => 'Julio',
  '8' => 'Agosto',
  '9' => 'Setiembre',
  '10' => 'Octubre',
  '11' => 'Noviembre',
  '12' => 'Diciembre'
  );

  $mesactual = date('n');

  $isSetiembreOrOctubre = $mescurrent == 9 || $mescurrent == 10;
  */

$colors_list = array();

?>



<section class="column width7 first">
  
  <div class="colgroup leading">
    <div class="column width7 first">
      <h3></h3>
      <p>

      </p>
    </div>
  </div>
  
  
  
  <div class="colgroup leading">
    <div class="box box-warning">A continuacion se listan los usuarios que tienen deudas pendientes</div>
    
    <div id="sf_admin_container2" class="column width6 first">
      <h4>Alumnos con deudas:&nbsp;&nbsp;<a href="#" id="count-deudores"><?php echo $facturas->count(); ?></a></h4>
      <ul class="sf_admin_actions" style="list-style: none;">
        <li class="sf_admin_action_print">
          <a href="javascript:void(0)" onclick="javascript:window.print(); return false;" id="print-button" class="iframe" style="padding-left: 20px;">Imprimir</a>
        </li>
      </ul>
      <hr />
      
      <?php if($facturas->count() == 0): ?>
        <p>No hay alumnos con deudas</p>
      <?php else: ?>
        <table class="no-style full">
            <thead>
              <tr>
                <td>Ref. Bancaria</td>
                <td>Alumno</td>
                <td class="ta-center">Costo</td>

                <!-- <td class="ta-center">Detalle</td> -->

                <td class="">Fuera de fecha ?</td>
              </tr>
            </thead>
            <tbody>
                <?php foreach($facturas as $factura):
                        $color = "";
                        if(isset($colors_list[$factura->getCuentaId()]))
                        {
                            $color = $colors_list[$factura->getCuentaId()];
                        }
                        else
                        {
                            $color = $factura->getRandomColor();
                            while(in_array($color, $colors_list))
                            {
                                $color = $factura->getRandomColor();
                            }
                            $colors_list[$factura->getCuentaId()] = $color;
                        }
                
                ?>
                <tr>
                    <td style="color: <?php echo $color;?>"><?php echo $factura->getUsuario()->getReferenciaBancaria();?></td>
                    <td><a href="<?php echo url_for('usuarios/edit/?id=' . $factura->getUsuario()->getId()); ?>"><?php echo $factura->getUsuario()->getApellido(). " ".$factura->getUsuario()->getNombre();?></a></td>
                    <td class="ta-center">$U <?php echo $factura->getTotal(); ?></td>
                    <td class="ta-center">
                        <a href="<?php echo url_for("alertas/pagarFactura/?id=".$factura->getId());?>">
                            Pagar
                        </a>
                        
                        <form class="alert-form" action="<?php echo url_for('@pagar'); ?>" method="POST" style="float:left">
                          <input type="hidden" name="id" value="<?php echo $factura->getUsuario()->getId(); ?>" />
                          <input type="hidden" name="price-to-pay" value="<?php echo $factura->getTotal(); ?>" />
                          <input type="hidden" name="mes" value="<?php echo 1; ?>" />
                          <input type="checkbox" name="out-of-date" />
                          <input type="text" name="price" value="" />
                          <a href="#" onclick="doPay(this); return false;">pagar</a> / <a href="#" onclick="doExonerar(this, '<?php echo url_for('@exonerar?id=' . $factura->getUsuario()->getId() . '&mes=' . 1); ?>'); return false;">cancelar</a>

                          <!--<input class="as-link" type="submit" value="pago" />-->
                        </form>
                        <label class="ok" style="display: none; vertical-align: middle;"></label>
                      </td>
                </tr>    
                <?php endforeach; ?>
            </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>

  <div class="clear">&nbsp;</div>

</section>

<script type="text/javascript">
function doPay(obj){
  mdShowLoading();
  var form = $(obj).parent('form');
  $.ajax({
    url:   form.attr('action'),
    type: 'post',
    data: form.serialize(),
    dataType: 'json',
    success: function(json){
      mdHideLoading();
      if(json.response == "OK"){
        //$(obj).parent('form').next().attr('class', 'ok').show().delay(3000).fadeOut();
        $(obj).parents('tr').remove();
        var counter = parseInt($('#count-deudores').text()) - 1;
        $('#count-deudores').html(counter);
      }else{
        $(obj).parent('form').next().attr('class', 'ierror').show().delay(3000).fadeOut();        
      }
    },
    complete: function(){},
    error: function(){}
  });
  return false;
}

function doExonerar(obj, postUrl){
  mdShowLoading();
  $.ajax({
    url:   postUrl,
    type: 'get',
    dataType: 'json',
    success: function(json){
      mdHideLoading();
      if(json.response == "OK"){
        $(obj).parents('tr').remove();
        var counter = parseInt($('#count-deudores').text()) - 1;
        $('#count-deudores').html(counter);
      }else{
        $(obj).parent('form').next().attr('class', 'ierror').show().delay(3000).fadeOut();        
      }
    },
    complete: function(){},
    error: function(){}
  });
  return false;
}
</script>