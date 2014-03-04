<?php if(!$IMAGE): ?>
  <?php echo html_entity_decode($mediaConcrete->retrieveEmbeddedCode(array('width' => $width, 'height'=>$height)));    ?>
<?php else: ?>
  <img src="<?php echo $mediaConcrete->getUrl(); ?>" width="<?php echo $width;?>" height="<?php echo $height;?>" alt="" />
<?php endif; ?>
