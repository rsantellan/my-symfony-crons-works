<?php 
use_helper('mdAsset');
?>

<form action="<?php echo url_for("mdMediaContentAdmin/processEmbededVideo");?>" method="POST" onsubmit="return mdEmbededVideos.getInstance().sendVideo(this);">
  <?php echo $form->renderHiddenFields(); ?>
  <input type="hidden" value="<?php echo mdVideosTypes::VIMEO; ?>" name="mdVideoType" id="mdVideoType"/>                  
  <input type="hidden" value="<?php echo $albumId;?>" name="albumId" id="albumId"/>
  <input type="hidden" value="<?php echo $objectClass;?>" name="objectClass" id="objectClass"/>
  <input type="hidden" value="<?php echo $objectId;?>" name="objectId" id="objectId"/>

  <label>Url
  <span class="small"><?php echo __('mdMediaDoctrine_text_Url:'); ?></span>
  </label>
  <?php echo $form['vimeo_url']->render(); ?>
  <?php if($form['vimeo_url']->hasError()): echo $form['vimeo_url']->getError(); endif; ?>

  <input name="botonenviar" type="submit" value="<?php echo __('mdMediaDoctrine_text_Publicar'); ?>" class="button" />

  <?php echo plugin_image_tag("mastodontePlugin", "md-ajax-loader.gif", array("style"=>"display:none", "id" => "loader_submit_video"));?>

  <div class="spacer"></div>

  <div class="clear:both"></div>
</form>
