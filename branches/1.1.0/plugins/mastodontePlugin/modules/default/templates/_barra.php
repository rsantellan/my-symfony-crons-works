<div class="clear"></div>
<div style="height:30px"></div>
<div id="md_taskbar">
    <div id="container">
        <div class="block-left">
            <a href="javascript:void(0);" class="btns"><?php echo __("barra_company name");?></a>
        </div>
        <div class="block-center">
            <!--<a href="#" class="btns"><img src="application.png" class="alignleft" alt="aplicacion" /></a>
            <a href="#" class="btns"><img src="calculator.png" class="alignleft" alt="aplicacion" />Twitter</a>
            <a href="#" class="btns"><img src="clock_red.png" alt="aplicacion" /></a>
            <a href="#" class="btns"><img src="zoom.png" alt="aplicacion" /></a>-->
        </div>
        <div class="block-right">
            <?php if($sf_user->hasPermission("Admin limpiar cache")): ?>
              <a href="<?php echo url_for("@symfonycc"); ?>" class="btns" onclick="mdPublish(this); return false;"><img src="/mastodontePlugin/images/application.png" class="alignleft" alt="publicar" />Limpiar Cache</a>
            <?php endif;?> 
        </div>
    </div>
</div>

<script type="text/javascript">
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
