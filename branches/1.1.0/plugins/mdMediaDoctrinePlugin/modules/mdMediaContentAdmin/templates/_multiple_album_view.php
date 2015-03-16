<?php
/**
 * Recibe:
 * el manager de contenidos en $manager
 * el objeto dueño de los contenidos, ejemplo: mdNews
 */
?>

<div id="images_container">


<div class="tabs_media_albums">
	<ul>
        <?php $i = 1; $defaultAlbum = 0; ?>
        <?php foreach($manager->getAlbums() as $dataMediaAlbum): ?>
            <?php if($i == 1): $defaultAlbum = $dataMediaAlbum->id; endif; $i++; ?>
            <li><a href="#tabs-<?php echo $dataMediaAlbum->id; ?>" alb-title="<?php echo $dataMediaAlbum->title ?>"><?php echo $dataMediaAlbum->title; ?></a></li>
        <?php endforeach; ?>
    </ul>
	
    <?php foreach($manager->getAlbums() as $dataMediaAlbum): ?>
        <div id="tabs-<?php echo $dataMediaAlbum->id; ?>" style="padding: 4px 2px 2px 2px; height: 155px;">
           <?php include_partial('mdMediaContentAdmin/album_view', array('manager' => $manager, 'title' => $dataMediaAlbum->title, 'object' => $object)); ?>
            <!--<p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>-->
        </div>
    <?php endforeach; ?>

</div>




</div>



<script type="text/javascript">
    $( ".tabs_media_albums" ).tabs({
        select: function(event, ui) {
            var tabIdArray = $(ui.tab).attr('href').split('-');
            var album_title = $(ui.tab).attr('alb-title');
            var album_id = tabIdArray[1];
            var object_id = <?php echo $manager->getMdObject()->getId() ?>;
            var object_class_name = "<?php echo $manager->getMdObject()->getObjectClass(); ?>";
            MdAvatarAdmin.getInstance().setDefaultAlbumId(album_id);
            var url = "<?php echo url_for('mdMediaContentAdmin/uploader'); ?>";
            var url_embebido = "<?php echo url_for('mdMediaContentAdmin/uploaderEmbebidos'); ?>" + "?a=" + object_id + "&c=" + object_class_name + "&i=" + album_id;
            $('#opener-el').attr('href', url + "?a=" + object_id + "&c=" + object_class_name + "&i=" + album_id);
            $('a#opener-el-embebido').attr('href', url_embebido);
            $('#album-order').attr('href', '<?php echo url_for('mdMediaContentAdmin/allMediaContent') ?>?object_id='+ object_id +'&object_class='+ object_class_name +'&album='+ album_title);
        }

    });

    MdAvatarAdmin.getInstance().setDefaultAlbumId(<?php echo $defaultAlbum; ?>);
    $('.media-content').fancybox();
    

</script>
