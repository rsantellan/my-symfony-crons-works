<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
  <head>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_http_metas(); ?>
    <?php include_metas(); ?>
    <?php include_title(); ?>

    <?php
        use_helper('mdAsset');
        use_plugin_javascript('mastodontePlugin', 'jquery/jquery-1.6.1.min.js', 'first');
        
        use_plugin_javascript('mastodontePlugin', 'mdConfig.js');
        //use_stylesheet('mdSorting.css');
        use_plugin_javascript('mastodontePlugin', 'AjaxLoader.js');
        use_plugin_stylesheet('mdUserDoctrinePlugin', 'mdSorting.css');
        /*
        use_plugin_stylesheet('mastodontePlugin', 'backend.css');
        use_plugin_stylesheet('mastodontePlugin', '../js/fancybox/jquery.fancybox-1.3.1.css');
        use_plugin_javascript('mastodontePlugin','fancybox/jquery.fancybox-1.3.1.pack.js','last');
        use_plugin_javascript('mastodontePlugin', 'flowplayer/flowplayer-3.2.4.min.js', 'last');
        use_plugin_javascript('mastodontePlugin', 'easySlider1.5.js');

        use_plugin_javascript('mdDynamicContentDoctrinePlugin', 'mdDynamicContent.js', 'last');
        use_plugin_javascript('mdAttributeDoctrinePlugin', 'newProfileBox.js', 'last');
*/
    ?>

    <?php use_plugin_stylesheet('mastodontePlugin', '../js/jquery-ui-1.8.4/css/smoothness/jquery-ui-1.8.4.custom.css') ?>
    <?php use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-ui-1.8.4.custom.min.js', 'last') ?>

    <?php include_stylesheets(); ?>
    <?php include_javascripts(); ?>
  </head>
  <body>

    <?php echo $sf_content ?>

  </body>
</html>
