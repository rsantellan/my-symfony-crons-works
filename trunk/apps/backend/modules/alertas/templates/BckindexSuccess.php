<?php use_helper('I18N', 'Date') ?>

<link href="/css/imprimir.css" type="text/css" rel="stylesheet" media="print" />

<?php slot('alertas'); ?>
<?php slot('nav') ?>Alertas<?php end_slot(); ?>

<?php $meses = array(
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
?>

<?php $isSetiembreOrOctubre = $mescurrent == 9 || $mescurrent == 10; ?>

<section class="column width7 first">
  
  <div class="colgroup leading">
    <div class="column width7 first">
      <h3>Meses anteriores</h3>
      <p>
        <?php foreach($meses as $key => $value): ?>
        
          <a <?php echo ($mescurrent == $key ? 'class="current"' : ''); ?> href="<?php echo url_for('@alertas?mes=' . $key); ?>"><?php echo $value; ?></a>

          <?php if($key == $mesactual): break; ?>
          <?php else: echo ' - '; endif; ?>
          
        <?php endforeach; ?>
      </p>
    </div>
  </div>
  
  <br />
  
  <div class="colgroup leading">
    <div class="box box-warning">A continuacion se listan los usuarios que aun no han pagado la cuota del mes de <?php echo $meses[$mescurrent]; ?></div>
    
    <div id="sf_admin_container2" class="column width6 first">
      <h4>Alumnos con deudas:&nbsp;&nbsp;<a href="#" id="count-deudores"><?php echo $usuarios->count(); ?></a></h4>
      <ul class="sf_admin_actions" style="list-style: none;">
        <li class="sf_admin_action_print">
          <a href="javascript:void(0)" onclick="javascript:window.print(); return false;" id="print-button" class="iframe" style="padding-left: 20px;">Imprimir</a>
        </li>
      </ul>
      <hr />
      
      <?php if($usuarios->count() > 0): ?>
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
          <?php foreach($usuarios as $usuario): ?>
          <?php $total = $usuario->calcularTotal(); ?>
          <tr>
            <td><?php echo $usuario->getReferenciaBancaria(); ?></td>
            <td><a href="<?php echo url_for('usuarios/edit/?id=' . $usuario['id']); ?>"><?php echo $usuario['apellido'] . ', ' . $usuario['nombre']; ?></a></td>
            <td class="ta-center">$U <?php echo $total; ?></td>           
            <!-- <td class="ta-center">
              <?php //echo 'Cuota - '; ?>
              
              <?php //if($isSetiembreOrOctubre): ?>
                <?php //echo 'Matricula - '; ?>
              <?php //endif; ?>
              
              <?php //$first = true; ?>
              <?php //foreach($usuario->getActividades() as $actividad): ?>
              
                <?php //if(!$first): ?>
                  <?php //echo ' - '; ?>
                <?php //endif; ?>
                <?php //$first = false; ?>              
                
                <?php //echo $actividad; ?>
              
              <?php //endforeach; ?>
            </td>-->
            
            <td class="ta-center">
              <form class="alert-form" action="<?php echo url_for('@pagar'); ?>" method="POST" style="float:left">
                <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>" />
                <input type="hidden" name="price-to-pay" value="<?php echo $total; ?>" />
                <input type="hidden" name="mes" value="<?php echo $mescurrent; ?>" />
                <input type="checkbox" name="out-of-date" />
                <input type="text" name="price" value="" />
                <a href="#" onclick="doPay(this); return false;">pagar</a> / <a href="#" onclick="doExonerar(this, '<?php echo url_for('@exonerar?id=' . $usuario->getId() . '&mes=' . $mescurrent); ?>'); return false;">cancelar</a>
                
                <!--<input class="as-link" type="submit" value="pago" />-->
              </form>
              <label class="ok" style="display: none; vertical-align: middle;"></label>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        </table>
        <?php else: ?>
          <p>No hay alumnos con deudas en el mes de <?php echo $meses[$mescurrent]; ?></p>
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