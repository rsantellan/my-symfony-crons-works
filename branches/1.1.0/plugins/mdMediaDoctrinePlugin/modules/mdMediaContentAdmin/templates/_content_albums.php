<div id="images_block_<?php echo $manager->getKey(); ?>" class="md_blocks md_image_block_width">
<?php if( $manager->getCountAlbums() > 0 ): ?>

    <?php if($manager->getCountAlbums() > 1): ?>
        
    <?php include_partial('mdMediaContentAdmin/multiple_album_view', array('manager' => $manager, 'object' => $object)); ?>

    <?php else: ?>

    <?php include_partial('mdMediaContentAdmin/single_album_view', array('manager' => $manager, 'object' => $object)); ?>

    <?php endif; ?>

<?php else: ?>

<script type="text/javascript">
    MdAvatarAdmin.getInstance().setDefaultAlbumId(null);
</script>
  
<?php endif; ?>
</div>
