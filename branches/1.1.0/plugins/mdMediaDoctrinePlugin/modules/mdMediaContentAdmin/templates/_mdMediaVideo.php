<?php
/**
 * Recibe:
 * object en $object, es el objeto que contiene 'dueño' de el archivo ejemplo: mdNews
 * mdMediaVideo en $mediaConcrete, es el objeto que representa el video
 * album_id en $album_id, identificador de el album
 * i en $i, es un contador
 */
?>

<div style="float: left;" id="md_draggable_<?php echo $mediaConcrete->getObjectClass(); ?>_<?php echo $mediaConcrete->getId() ?>_<?php echo $album_id; ?>_<?php echo $object->getId() ?>_<?php echo $object->getObjectClass(); ?>" class="<?php if(($i % 5 == 0)): echo 'no_marginr'; endif; ?> md_draggable">
    <div class="box_pdf">
        <div class="media-content-container" style="position:absolute; width: 50px; height: 15px; background-color: #fff; margin: 2px;text-align: center; cursor: pointer; display: none;"><a class="media-content" href="<?php echo url_for('@editMedia') ?>?id=<?php echo $mediaConcrete->getId() ?>&object=<?php echo $mediaConcrete->getObjectClass() ?>&ownerId=<?php echo $object->getId() ?>&ownerClass=<?php echo $object->getObjectClass() ?>">Editar</a></div>
        <div style="position: absolute; width: 20px; height: 20px; margin-top: 47px;"><img width="20" height="20" src="/mastodontePlugin/images/play_small.png" /></div>
        <img style="margin-right: 2px;" src="<?php echo $mediaConcrete->getAvatarVideo(array(mdWebOptions::WIDTH => 68, mdWebOptions::HEIGHT => 68, mdWebOptions::EXACT_DIMENTIONS => true, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>" width="68" height="68" title="<?php echo $mediaConcrete->getName(); ?>" alt="" />
        <div class="md_remove_thumbs" style="display: none;" onclick="MdAvatarAdmin.getInstance().removeContent(<?php echo $mediaConcrete->getId() ?>, '<?php echo $mediaConcrete->getObjectClass() ?>', <?php echo $object->getId() ?>, '<?php echo $object->getObjectClass() ?>', <?php echo $album_id; ?>, this);"></div>
    </div>
</div>