<?php 
use_helper('mdAsset');
?>

<form action="<?php echo url_for("mdMediaContentAdmin/processEmbededVideo");?>" method="POST" onsubmit="return mdEmbededVideos.getInstance().sendVideo(this);">
  <?php echo $form->renderHiddenFields(); ?>
  <input type="hidden" value="<?php echo mdVideosTypes::YOUTUBE; ?>" name="mdVideoType" />                  
  <input type="hidden" value="<?php echo $albumId;?>" name="albumId" />
  <input type="hidden" value="<?php echo $objectClass;?>" name="objectClass" />
  <input type="hidden" value="<?php echo $objectId;?>" name="objectId" />

  <label>Url
  <span class="small"><?php echo __('mdMediaDoctrine_text_Url del Video:'); ?></span>
  </label>
  <?php echo $form['src']->render(); ?>
  <?php if($form['src']->hasError()): echo $form['src']->getError(); endif; ?>

  <label>Descripcion
  <span class="small"><?php echo __('mdMediaDoctrine_text_Comentario o pie:'); ?></span>
  </label>
  <?php echo $form['description']->render(); ?>
  <?php if($form['description']->hasError()): echo $form['description']->getError(); endif; ?>            

  <input name="botonenviar" type="submit" value="<?php echo __('mdMediaDoctrine_text_Publicar'); ?>" class="button" />

  <?php echo plugin_image_tag("mastodontePlugin", "md-ajax-loader.gif", array("style"=>"display:none", "id" => "loader_submit_video"));?>

  <div class="spacer"></div>

  <div class="clear:both"></div>
</form>
<?php
 if(isset($error_on_site))
 {
   echo __('mdMediaDoctrine_text_Sitio de video no soportado.'); 
 }
?>


