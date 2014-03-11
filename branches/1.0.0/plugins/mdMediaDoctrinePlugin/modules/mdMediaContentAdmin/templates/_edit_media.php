<?php use_helper("mdAsset");?>

<div id="edit_media_container" class="edit_media_container">
    <form action="<?php echo url_for('@processMediaForm') ?>" id="editMediaForm" onsubmit="saveMediaInfo(); return false;">
        <?php echo $form->renderHiddenFields() ?>
        
        <?php if($mediaConcrete->getObjectClass() == 'mdMediaVideo'): ?>
            <div style="width: 276px; float: left;">
                <a id="player_avatar"
                href="<?php echo $mediaConcrete->getUrl(array(mdWebOptions::WIDTH => 68, mdWebOptions::HEIGHT => 68, mdWebOptions::EXACT_DIMENTIONS => true, mdWebOptions::CODE => mdWebCodes::RESIZE)); ?>"
                style="display:block;width:225px;height:125px;background-image:url(<?php echo $mediaConcrete->getAvatarVideo(array(mdWebOptions::WIDTH => 225, mdWebOptions::HEIGHT => 125, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>)"
                class="player">
                    <img src="/mastodontePlugin/images/play_large.png" alt="<?php echo $mediaConcrete->getName(); ?>" />
                </a>
                
            </div>

            <script language="JavaScript">
                flowplayer("a.player", "/mastodontePlugin/js/flowplayer/flowplayer-3.2.5.swf");
            </script>
        <?php else: ?>
            
            <img class="edit_media_img" height="200" width="250" src="<?php echo $mediaConcrete->getUrl(array(mdWebOptions::WIDTH => 250, mdWebOptions::HEIGHT => 200, mdWebOptions::CODE => mdWebCodes::RESIZE)); ?>" />
            
        <?php endif; ?>

        <div style="width: 300px; float: left;">
            <h1>Titulo</h1>
            <?php echo $form['name']->render(array('class' => 'edit_media_input')) ?>

            <h1 style="margin-top:15px;">Descripcion</h1>
            <?php echo $form['description']->render(array('class' => 'edit_media_textarea')) ?>
            <div style="margin-top: 20px; float: right">
                <a style="text-decoration: none; margin-right: 35px" class="download_media_img" href="<?php echo url_for("@downloadMedia")."?id=".$mediaConcrete->getId()."&class=".$mediaConcrete->getObjectClass();?>">Bajar original <?php echo plugin_image_tag("mdMediaDoctrinePlugin", "image_link.png");?></a>
                <input type="submit" value="Guardar" />
                <input type="button" value="Cancelar" onclick="$.fancybox.close();" />
            </div>
        </div>
    </form>
    <div class="clear"></div>
    <?php if($mediaConcrete->getObjectClass() == 'mdMediaVideo'): ?>
    <div id="videoAvatarLoading" style="text-align: center;float: right; margin-top: 15px; display: none;"><img src="/mastodontePlugin/images/green-circle-ajax-loader.gif" /></div>


    <div style="float: right; margin-top: 15px;">
        
        <iframe style="width: 380px;" src="<?php echo url_for('mdMediaContentAdmin/uploaderAvatarVideoIframe') ?>?id=<?php echo $mediaConcrete->getId()?>"></iframe>
        
    </div>
    <?php endif; ?>

</div>

<script>

    function saveMediaInfo(){
        $.ajax({
            url: $('#editMediaForm').attr('action'),
            data: $('#editMediaForm').serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    $.fancybox.close();
                } else if(json.response == "NOK"){
                    mdShowMessage('Ha ocurrido un error. Intentelo nuevamente mas tarde.')
                    //mostrar mensajes de error
                }
            }
        });
    }
</script>