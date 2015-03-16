<?php $title = (isset($title) ? $title : $manager->getTitle()); ?>

<?php include_partial('mdMediaContentAdmin/album_view', array('manager' => $manager, 'title' => $title, 'object' => $object)); ?>

<script type="text/javascript">
    MdAvatarAdmin.getInstance().setDefaultAlbumId(<?php echo $manager->getId($title); ?>);
    $('.media-content').fancybox();

</script>
