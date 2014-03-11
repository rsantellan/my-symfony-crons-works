<!-- Page footer -->
<footer id="bottom">
  <div class="wrapper">
    <nav>
      <a href="<?php echo url_for('@alertas'); ?>">Alertas</a>
      <a href="<?php echo url_for('@usuario'); ?>">Alumnos</a> &middot;
      <a href="<?php echo url_for('@mdTranslator'); ?>">Textos</a> &middot;
      <a href="<?php echo url_for('@actividades'); ?>">Actividades</a> &middot;
      <a href="<?php echo url_for('@manage_newsletter') ?>">Newsletter</a> &middot;
      <a href="<?php echo url_for('@pagos'); ?>">Pagos</a> &middot;
      <a href="<?php echo url_for('@costos'); ?>">Configuraciones</a> &middot;
      <a href="<?php echo url_for("@symfonycc"); ?>" onclick="mdPublish(this); return false;">Limpiar Cache</a>
    </nav>
  </div>
</footer>
<!-- End of Page footer -->

<!-- Animated footer -->
<!--<footer id="animated">
  <ul>
    <li><a href="<?php //echo url_for('@alertas'); ?>">Alertas</a></li>    
    <li><a href="<?php //echo url_for('@usuario'); ?>">Alumnos</a></li>
    <li><a href="<?php //echo url_for('@mdTranslator'); ?>">Textos</a></li>
    <li><a href="<?php //echo url_for('@actividades'); ?>">Actividades</a></li>
    <li><a href="<?php //echo url_for('@pagos'); ?>">Pagos</a></li>
    <li><a href="<?php //echo url_for('@costos'); ?>">Configuraciones</a></li>
    <li><a href="<?php //echo url_for("@symfonycc"); ?>" onclick="mdPublish(this); return false;">Limpiar Cache</a></li>
  </ul>
</footer>-->
<!-- End of Animated footer -->

<!-- Scroll to top link -->
<a href="#" id="totop">^ scroll hacia arriba</a>


<script type="text/javascript">
$(document).ready(function(){

  /* setup navigation, content boxes, etc... */
  Administry.setup();

});

function mdPublish(obj){
    mdShowLoading();
    $.ajax({
        url: $(obj).attr("href"),
        type: 'post',
        dataType: 'json',
        success: function(json){
            if(json.response == "OK"){
                mdHideLoading(function(){mdShowMessage("El proceso de publicacion ha finalizado con exito.")});
            }else{
                mdHideLoading(function(){mdShowMessage("Ha ocurrido un error y el proceso no se ha podido realizar con exito.")});
            }
        },
        error: function(){
            mdHideLoading(function(){mdShowMessage("Ha ocurrido un error y el proceso no se ha podido realizar con exito.")});
        }
    });

    return false;
}
</script>