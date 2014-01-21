<?php
  $mdItemIds = MdMediaAlbum::retrieveContentIds($id);
  $itemsOrdered = MdMediaAlbum::retrieveItems($mdItemIds);
  $quantity = 5;
  $count = count($itemsOrdered);
  if($count < 5)
  {
    if($count != 1)
    {
      $quantity = $count;
    }
    else
    {
      $quantity = 2;
    }
  }
  $height = ceil($count / $quantity);
?>
<div class='md_album_simple_container' style='width: <?php echo ((92 * $quantity));?>px; height: <?php echo 92 * $height;?>px'>
  <h1><?php echo $title;?></h1>

  <ul>
  <?php
  foreach($itemsOrdered as $item): ?>
    <li style='width: 92px; height: 92px;float:left;padding-left: 5px'>
      <img alt="<?php echo $item->getName();?>" src="<?php echo $item->getUrl(array(mdWebOptions::WIDTH => 92, mdWebOptions::HEIGHT => 92, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>"/> 
    </li>
  <?php endforeach;?>
  </ul>
</div>
