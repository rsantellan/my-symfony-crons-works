<div style="margin: 4px;">
    <input type="hidden" name="_MD_OBJECT_ID" value="<?php echo $object->getId(); ?>" />
    <input type="hidden" name="_MD_OBJECT_CLASS_NAME" value="<?php echo $object->getObjectClass(); ?>" />
    <input type="hidden" name="PRIORITY" value="<?php echo $object->getPriority(); ?>" />
    <ul class="md_closed_object">
    <li class="md_object_name">
      <div class="md_object_owner">
        <?php echo $object->getId()?> <span>-</span> <?php echo html_entity_decode( $object->__toString()); ?>
      </div>
    </li>
  </ul><!--UL PRODUCTO CERRADO-->
</div>
