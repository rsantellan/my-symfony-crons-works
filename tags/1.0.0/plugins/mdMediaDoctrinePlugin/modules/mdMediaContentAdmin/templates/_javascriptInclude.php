<?php
use_helper('mdAsset');
use_helper( 'JavascriptBase' );
use_plugin_javascript('mdMediaDoctrinePlugin', 'AvatarAdmin.js');
use_plugin_javascript('mdMediaDoctrinePlugin', 'MdMouseOverObserver.js', 'last');
?>

<?php echo javascript_tag("

function initializeLightBox(id, className){
    var album = '';
    if(arguments[2] !== undefined && arguments[2] != null) album = '&i=' + arguments[2];
    if(album === '')
    {
        if(__DEFAULT_ALBUM_ID !== null)
        {
            album = '&i=' + __DEFAULT_ALBUM_ID;
        }
    }
    var url = '".url_for('mdMediaContentAdmin/uploader')."?a=' + id +'&c=' + className + album;

    $('a#opener-el').attr('href', url);
    $('a#opener-el').fancybox({ autoScale: true });

    if($('a#opener-el-embebido').length != 0)
    {
      var url_embebido = '".url_for('mdMediaContentAdmin/uploaderEmbebidos')."?a=' + id +'&c=' + className + album;
      $('a#opener-el-embebido').attr('href', url_embebido);
      $('a#opener-el-embebido').fancybox({ autoScale: true });
    }

    $('#album-order').fancybox({ autoScale: true, autoDimensions: true });

    MdAvatarAdmin.getInstance().setAlbumsDraggablesDroppables();
    new MdMouseOverObserver($('div.over_images div img'), 'div.md_remove_thumbs');

    new MdMouseOverObserver($('div.over_images div img'), 'div.media-content-container');

}
");
