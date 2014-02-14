<?php use_helper('I18N', 'Date', 'mdAsset');?>
<?php use_stylesheet('rodrigosantellan.css', 'last');?>
<?php use_plugin_stylesheet('mastodontePlugin', '../js/jquery-ui-1.8.4/css/smoothness/jquery-ui-1.8.4.custom.css') ?>
<?php use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-ui-1.8.4.custom.min.js', 'last') ?>
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
      <h3>Cuentas con deudas:&nbsp;&nbsp;<a href="#" id="count-deudores"><?php echo count($cuentas); ?></a></h3>
      <ul class="sf_admin_actions" style="list-style: none;">
        <li class="sf_admin_action_print">
          <a href="javascript:void(0)" onclick="javascript:window.print(); return false;" id="print-button" class="iframe" style="padding-left: 20px;">Imprimir</a>
        </li>
      </ul>
      <hr />
      <div id="accountAccordionList" class="accountslist">
        <?php foreach($cuentas as $cuentaUsuario): ?>
        
          <?php
          $cuenta = $cuentaUsuario['cuenta'];
          $usuarios = $cuentaUsuario['usuarios'];
          $apellido = $cuentaUsuario['apellido'];
          ?>
          <?php //var_dump($cuenta->getId());?> 
          
        <h3 id="accordionHeader_<?php echo $cuenta->getId();?>"><?php echo $apellido;?> <label class="accountListTitleRef">(Ref: <?php echo $cuenta->getReferenciabancaria();?>)($<span id="monto_header_<?php echo $cuenta->getId();?>"><?php echo $cuenta->getFormatedDiferencia();?></span>)</label></h3>
          
        <div id="accordionBody_<?php echo $cuenta->getId();?>" class="accordionData">
          <div class="accountslistUsers">
            <label>Alumnos relacionados</label>
            <ul class="accountslistUsersList">
              <?php foreach($usuarios as $usuario): ?>
                <li class="<?php echo ($usuario->getEgresado() == 1)? 'liegresado' : ''; ?>"><?php echo $usuario->getNombre(). " - ".$usuario->getApellido();?> <?php echo ($usuario->getEgresado() == 1)? '(Egresado)' : ''; ?></li>
              <?php endforeach;?>
            </ul>
          </div>
          <div class="accountslistActions">
            <span>Monto adeudado: $<span id="monto_body_<?php echo $cuenta->getId();?>"><?php echo $cuenta->getFormatedDiferencia();?></span>
            <a href="<?php echo url_for("@detallecuenta?id=".$cuenta->getId());?>">Ver detalle</a>
            <div>
              <a href="javascript:void(0)">Enviar mail</a>
              <a href="<?php echo url_for("@pagarcuenta?id=".$cuenta->getId());?>" class="fancybox">Pagar</a>
              <a href="javascript:void(0)">Cancelar</a>
            </div>
          </div>
        </div>
        
          
        <?php endforeach; ?>
          
      </div>
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

$(function() {
  $('#accountAccordionList').accordion({
    collapsible: true,
    active: false
  });
  $('a.fancybox').fancybox();
});

function sendNewCobro(form)
{
  if(confirm('Esta seguro de querer ingresar el cobro?'))
  {
    
    $.fancybox.showActivity();
    $.ajax({
        url: $(form).attr('action'),
        data: $(form).serialize(),
        type: 'post',
        dataType: 'json',
        success: function(json){
            if(json.response == "OK")
            {
              if(json.options.removePanel == 'true' || json.options.removePanel == true)
              {
                $('#accordionHeader_'+json.options.accountId).remove();
                $('#accordionBody_'+json.options.accountId).remove();
                $('#accountAccordionList').accordion("refresh");
              }
              $('#monto_header_'+json.options.accountId).html(json.options.monto);
              $('#monto_body_'+json.options.accountId).html(json.options.monto);
              $.fancybox.close();
              mdShowMessage(json.options.message);
            }
            else
            {
              $('#cobroformcontainer').html(json.options.partial);
            }
        }
        , 
        complete: function()
        {
          $.fancybox.hideActivity();
          $.fancybox.resize();
        }
    });
  }
  return false;
}
</script>