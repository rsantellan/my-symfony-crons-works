<div class="add">
    <a href="#md-video-content" id="link_to_add_video" class="agregavideo" style="color: #1C9600;">Subir nuevo youtube</a>
</div>

<div class="clear"></div>

<div class="box_container" style="display: none" id="new_video_box_container">
    <?php include_partial("mdMediaContentAdmin/youtubeUpload", array('form' => $form, 'albumId' => $album->id)); ?>
</div>


<script type="text/javascript">
$(document).ready(function() {

    	/* This is basic - uses default settings */
        $("a#link_to_add_video").fancybox({
            'opacity'		: true,
            'overlayShow'	: true,
            'overlayOpacity' 	: 0.8,
            'overlayColor' 	: '#000',
            'transitionIn'	: 'elastic',
            'transitionOut'	: 'elastic',
            'speedIn'           : 600,
            'showCloseButton'   : false,
            'width' : 550,
            'height' : 300,
            'autoDimensions' : false
        });

        $("#md-modal-close").bind("click", function(){ $.fancybox.close(); return false; });

        setYouTubeImage();
});
</script>
