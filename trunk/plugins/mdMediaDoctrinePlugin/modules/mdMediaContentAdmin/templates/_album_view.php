<?php
/**
 * Recibe:
 * el nombre del album a mostrar en $title OPCIONAL
 * el manager de contenidos en $manager
 * el objeto dueño de los contenidos, ejemplo: mdNews
 */
?>
<?php $title = (isset($title) ? $title : $manager->getTitle()); ?>

<?php use_helper('mdMedia'); ?>

<div id="album_<?php echo $manager->getId($title); ?>_<?php echo $manager->getKey(); ?>" class="md_blocks" style="width:100%">
    <div id="md_avatar_<?php echo $manager->getId($title); ?>" class="md_avatar_image droppableObject">
        <div id="loading_avatar" style="display: none; width:140px; height:140px;" class="md_loading_closed_objects"><?php echo image_tag('/mastodontePlugin/images/md-ajax-loader.gif', array('style' => 'width:32px;height:32px;')) ?></div>
        <img alt="" src="<?php echo $manager->getAvatarUrl($title, array(mdWebOptions::WIDTH => 140, mdWebOptions::HEIGHT => 140, mdWebOptions::EXACT_DIMENTIONS => true, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>" width="140" height="140" />
    </div><!--IMAGEN PRINCIPAL-->

    <div id="images_wrapper" class="float_left">
        <div id="slider-<?php echo $manager->getId($title); ?>" class="slider">
            <ul>
        <?php $i = 1; $j = 0; $k = 1; ?>
        <?php foreach ($manager->getItems($title) as $mdMediaConcrete): ?>
            <?php if(($j % 10) == 0): ?>
            <li><div class="over_images">
                <!--<ul class="md_thumbs md_images_ul">-->
            <?php endif; ?>
                    <?php $options = array('i' => $i, 'object' => $object, 'album_id' => $manager->getId($title)); ?>
                    <?php render_media($mdMediaConcrete, $options); ?>
            <?php if(($k % 10) == 0): ?>
                <!--</ul>-->
            </div></li><!--THUMBS PRODUCTOS-->
            <?php endif; ?>

        <?php $j++; $k++; endforeach; ?>
            </ul>
        </div>
    </div>

<script>
    if($("#slider-<?php echo $manager->getId($title); ?>") != null){
        $("#slider-<?php echo $manager->getId($title); ?>").easySlider({
            nextId: "slider1next-<?php echo $manager->getId($title); ?>",
            prevId: "slider1prev-<?php echo $manager->getId($title); ?>"

        });

        $('#slider1next-<?php echo $manager->getId($title); ?>').addClass('prevBtn');
        $('#slider1prev-<?php echo $manager->getId($title); ?>').addClass('nextBtn');

    }
</script>


</div>

