<?php if($mdMediaContent->getObjectClassName() == "mdMediaYoutubeVideo"): ?>
  <?php $video = $mdMediaContent->retrieveObject();?>
  <?php echo html_entity_decode($video->retrieveEmbeddedCode(array('width' => 532, 'height'=>327)));    ?>
<?php else: ?>
  <?php $object = $mdMediaContent->retrieveObject();?>
  <div style="width:372px; height:372px">
    <img alt="imagen" src="<?php echo $object->getObjectUrl(array(mdWebOptions::WIDTH => 368, mdWebOptions::HEIGHT => 368, mdWebOptions::CODE => mdWebCodes::RESIZECROP));?>"/>
  </div>
<?php endif;?>

