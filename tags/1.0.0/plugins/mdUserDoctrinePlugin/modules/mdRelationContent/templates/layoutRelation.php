<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
  <head>
    <title><?php echo __('mdUserDoctrine_text_titleLayoutRelation'); ?></title>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_http_metas(); ?>
    <?php include_metas(); ?>
    <?php include_title(); ?>

    <?php
        use_helper('mdAsset');
        use_plugin_stylesheet('mastodontePlugin', 'backend.css');
        use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-1.4.2.min.js', 'first');
        use_plugin_javascript('mastodontePlugin', 'mdConfig.js');
        use_plugin_stylesheet('mastodontePlugin', '../js/fancybox/jquery.fancybox-1.3.1.css');
        use_plugin_javascript('mastodontePlugin','fancybox/jquery.fancybox-1.3.1.pack.js','last');
        use_plugin_javascript('mastodontePlugin', 'flowplayer/flowplayer-3.2.4.min.js', 'last');
        use_plugin_javascript('mastodontePlugin', 'easySlider1.5.js');

        use_plugin_javascript('mdDynamicContentDoctrinePlugin', 'mdDynamicContent.js', 'last');
        use_plugin_javascript('mdAttributeDoctrinePlugin', 'newProfileBox.js', 'last');

        if( sfConfig::get( 'sf_plugins_user_media', false ) )
        {
          include_partial('mdMediaContentAdmin/javascriptInclude');
        }
        if( sfConfig::get( 'sf_plugins_dynamic_media', false ) )
        {
          include_partial('mdMediaContentAdmin/javascriptInclude');
        }
        if( sfConfig::get( 'sf_plugins_dynamic_category', false ) )
        {
            use_plugin_javascript('mdCategoryDoctrinePlugin', 'mdCategoryObjectBox.js');
        }
        use_javascript('tiny_mce/tiny_mce.js', 'last');
    ?>

    <?php use_plugin_stylesheet('mastodontePlugin', '../js/jquery-ui-1.8.4/css/smoothness/jquery-ui-1.8.4.custom.css') ?>
    <?php use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-ui-1.8.4.custom.min.js', 'last') ?>
    <?php use_plugin_javascript('mastodontePlugin','jquery-ui-1.8.4/development-bundle/ui/i18n/jquery.ui.datepicker-'.sfContext::getInstance()->getUser()->getCulture().'.js','last'); ?>
    <?php use_plugin_javascript('mastodontePlugin', 'jType.js') ?>
    <?php use_plugin_javascript('mastodontePlugin', 'mastodontePlugin.backendBasic.js') ?>

    <?php include_stylesheets(); ?>
    <?php include_javascripts(); ?>
    <style>
        .progressWindow{
            font-family:Arial,Verdana;
            font-weight:bold;
            line-height:30px;
            padding-left:30px;
            padding-right:10px;
        }
        .upload_progress {
            background: url("/mdMediaManagerPlugin/images/loading.gif") no-repeat scroll 5px 8px #FFFFFF;
            border:1px solid gray;
            height:30px;
            left:265px;
            position:absolute;
            text-align:left;
            top:160px;
            z-index:100101;

        }
        .upload_container{
            position: absolute;
            background-color: #FFF;
            height:100%;
            width: 100%;
            opacity: 0.7;
            text-align:left;
            top:0;
            z-index:100100;
        }
    </style>
  </head>
  <body>

    <?php echo $sf_content ?>


    <div id="upload_container_overlay" class="upload_container" style="display:none"></div>

    <div id="upload_container" class="upload_progress" style="display:none">
        <div class="progressWindow"><?php echo __('mdUserDoctrine_text_loading');?>...</div>
    </div>

    <script type="text/javascript">
        <?php if( sfConfig::get( 'sf_plugins_dynamic_category', false ) ):  ?>
        var mdCategoryObjectBox = new MdCategoryObjectBox({'object_class':'mdDynamicContent'});
        <?php endif; ?>
    </script>
  </body>
</html>