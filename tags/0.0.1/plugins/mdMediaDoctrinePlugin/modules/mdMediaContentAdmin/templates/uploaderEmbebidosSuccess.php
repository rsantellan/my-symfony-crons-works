<?php 
use_helper('mdAsset');
use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-1.4.2.min.js', 'first');
use_plugin_javascript('mdMediaDoctrinePlugin', 'mdEmbededVideos.js', 'last');
use_plugin_stylesheet('mastodontePlugin', 'forms.css');
?>

<?php $videoTypes = sfConfig::get('sf_plugins_media_videos_embebed_types'); ?>

<style type="text/css">
  body{
    background: #ffffff;
  }
</style>

<div id="stylized" class="myform">
  <div id="video_embeded_container_form">
        <h1>Agregar nuevo video</h1>

        <p>Para agregar un nuevo video, en primer lugar seleccione el proveedor. Luego copie la url completa del video que quiera agregar y peguela en la entrada de abajo.
        <?php if(count($videoTypes) > 1): ?>
          <select id="mdVideosEmbebed" name="mdVideoType">
            <?php foreach($videoTypes as $type): ?>
              <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
            <?php endforeach; ?>
          </select>
        <?php endif; ?>
        </p>
        
        <div id="container_videos_form">
          <?php foreach($videoTypes as $type): ?>
            
            <div id="mdForm_<?php echo $type; ?>" class="md_video_embebed" style="display:none">
              <?php include_partial($type . "Upload", array('form'=> $forms[$type], 'albumId' => $albumId, 'objectId' => $objectId, 'objectClass' => $objectClass)); ?>
            </div>
          
          <?php endforeach; ?>
        </div>

  </div>   
</div>

<script type="text/javascript">
$(document).ready(function() {
  $('.md_video_embebed').first().show();
  $('#mdVideosEmbebed').live('change', function(event){
    event.preventDefault();
    $('.md_video_embebed').hide();
    $('#mdForm_' + $(this).val()).show();
  });
});
</script>
