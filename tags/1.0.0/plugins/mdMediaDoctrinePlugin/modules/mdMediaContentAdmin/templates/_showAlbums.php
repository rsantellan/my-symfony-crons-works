<?php
/**
 * Partial que se encarga de mostrar el listado de albums con los contenidos.
 * Recibe: manager, object
 * 
 */
?>

<?php if($object->getId() != NULL): ?>
    <div class="md_blocks">
        <h2 class="float_left"><?php echo __('mdMediaDoctrine_text_subirContenido'); ?></h2>
        <div class="float_left">
            <a id="opener-el" class="iframe"><?php echo image_tag ( '/mastodontePlugin/images/agregar.jpg' )?></a>
        </div>
        <div class="clear"></div>
    </div>

  <?php if( sfConfig::get( 'sf_plugins_' . $object->getObjectClass() . '_video_embebed_available', false ) ):  ?>
      <div class="md_blocks">
        <h2 class="float_left"><?php echo __('mdMediaDoctrine_text_subirEmbebido'); ?></h2>
        <div class="float_left">
            <a id="opener-el-embebido" class="iframe"><?php echo image_tag ( '/mastodontePlugin/images/agregar.jpg' )?></a>
        </div>
        <div class="clear"></div>
      </div>
  <?php endif; ?> 

    <?php if($album_title != null): ?>
        <div class="md_blocks" style="float:right">
            <h2><a id="album-order" href="<?php echo url_for('mdMediaContentAdmin/allMediaContent?object_id='.$object->getId().'&object_class='.$object->getObjectClass().'&album='. $album_title) ?>"><?php echo __('mdMediaDoctrine_text_ordenar'); ?></a></h2>
        </div>
    <?php endif; ?>
    <!--<h2>Imagenes</h2>-->
    <?php include_partial('mdMediaContentAdmin/content_albums', array('manager' => $manager, 'object' => $object)); ?>

    <!--<h2>Videos</h2>-->
    <?php //include_partial('mdMediaContentAdmin/content_albums', array('manager' => $managerVideos, 'object' => $object)); ?>

<?php endif; ?>
    <script type="text/javascript">
    function updateMediaContainer(){
        MdAvatarAdmin.getInstance().updateContentAlbums('<?php echo $object->getId() ?>', '<?php echo $object->getObjectClass() ?>');
    }
    </script>

