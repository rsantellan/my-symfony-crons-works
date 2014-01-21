<?php
/**
 * Recibe:
 * object en $object, es el objeto que contiene 'dueño' de el archivo ejemplo: mdNews
 * mdMediaVideo en $mediaConcrete, es el objeto que representa el video
 * album_id en $album_id, identificador de el album
 * i en $i, es un contador
 */
?>

<div style="float: left;" id="md_draggable_<?php echo $mediaConcrete->getObjectClass(); ?>_<?php echo $mediaConcrete->getId() ?>_<?php echo $album_id; ?>_<?php echo $object->getId() ?>_<?php echo $object->getObjectClass(); ?>" class="<?php if(($i % 5 == 0)): echo 'no_marginr'; endif; ?> md_draggable small_avatar_block">
    <div class="box_pdf youtube_image">
        <img width="68" height="68" youtubesrc="<?php echo $mediaConcrete->getCode(); ?>" style="margin-right: 2px; margin-bottom: 2px;" src="<?php echo $mediaConcrete->getUrl(array(mdWebOptions::WIDTH => 68, mdWebOptions::HEIGHT => 68, mdWebOptions::EXACT_DIMENTIONS => true, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>" title="<?php echo $mediaConcrete->getName(); ?>" alt="" />
        <div class="md_remove_thumbs" style="display: none;" onclick="MdAvatarAdmin.getInstance().removeContent(<?php echo $mediaConcrete->getId() ?>, '<?php echo $mediaConcrete->getObjectClass() ?>', <?php echo $object->getId() ?>, '<?php echo $object->getObjectClass() ?>', <?php echo $album_id; ?>, this);"></div>
    </div>
</div>
