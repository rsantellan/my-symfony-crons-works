<style>
    ul#sortable-media {
        list-style-type: none;
        margin: 0; padding: 0;
    }
    ul#sortable-media li {
        float: left;
        margin: 5px 5px 5px 0;
        padding: 1px;
        width: 69px;
        height: 69px;
    }

</style>

<div>
    <h2><?php echo __('mdMediaDoctrine_text_Arrastre las imagenes para ordenar los contenidos'); ?></h2>
    <ul id="sortable-media">

<?php foreach($media as $mediaConcrete):
    $media_content_id = Doctrine::getTable('mdMediaContent')->retrieveContentIdByClassAndObjectId($mediaConcrete->getObjectClass(), $mediaConcrete->getId());
    
    if($mediaConcrete->getObjectClass() == 'mdMediaVideo'):
        $hayVideos = true;
?>
        <li class="priority_array"  id="<?php echo $mediaConcrete->getObjectClass() ?>_<?php echo $media_content_id ?>"><a id="player_avatar"
href="<?php echo $mediaConcrete->getUrl(array(mdWebOptions::WIDTH => 68, mdWebOptions::HEIGHT => 68, mdWebOptions::EXACT_DIMENTIONS => true, mdWebOptions::CODE => mdWebCodes::RESIZE)); ?>"
style="display:block;width:68px;height:68px;background-image:url(<?php echo $mediaConcrete->getAvatarVideo(array(mdWebOptions::WIDTH => 68, mdWebOptions::HEIGHT => 68, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>)"
class="player">
        <img width="50" height="50" style="margin-top: 7px;" src="/mastodontePlugin/images/play_large.png" alt="<?php echo $mediaConcrete->getName(); ?>" />
</a></li>

<?php else: ?>
    <li class="priority_array" id="<?php echo $mediaConcrete->getObjectClass() ?>_<?php echo $media_content_id ?>"><img class="edit_media_img" src="<?php echo $mediaConcrete->getUrl(array(mdWebOptions::WIDTH => 68, mdWebOptions::HEIGHT => 68, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>" /></li>
<?php endif;?>            
<?php endforeach; ?>

<?php if(isset($hayVideos)):?>
<script language="JavaScript">
    //flowplayer("a.player", "/mastodontePlugin/js/flowplayer/flowplayer-3.2.5.swf");
</script>
<?php endif;?>
    </ul>
    <div class="clear"></div>
    
</div>

<script type="text/javascript">
$(function() {
    $( "ul#sortable-media" ).sortable({
        update: function(event, ui) {
            savePriorities();
        }
    });
    $( "ul#sortable-media" ).disableSelection();

});

function savePriorities(){
    //AjaxLoader.getInstance().show();
    var arr = new Array();
    $('.priority_array').each(function(index, item){
        arr.push($(item).attr('id'));
    });

    var data = arr.join(',');

    $.ajax({
        url: '<?php echo url_for('mdMediaContentAdmin/setAlbumPriorities') ?>',
        data: {'priorities' : data, 'albumId': <?php echo $albumId ?> },
        type: 'post',
        dataType: 'json',
        success: function(json){
            updateMediaContainer();
        },
        complete: function(){
            //AjaxLoader.getInstance().hide();
        }
    });

}

</script>