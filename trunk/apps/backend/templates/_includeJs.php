<?php use_helper('JavascriptBase'); ?>
<?php use_helper('mdAsset'); ?>

<?php use_plugin_javascript('mastodontePlugin', 'mdConfig.js'); ?>

<?php use_plugin_javascript('mastodontePlugin', 'jquery/jquery-1.6.1.min.js'); ?>
<?php use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-ui-1.8.4.custom.min.js'); ?>

<?php use_plugin_javascript('mastodontePlugin', 'mdLoadController.js'); ?>
<?php use_javascript('mdAdmin.js'); ?>

<?php use_javascript('jquery.tipTip.min.js'); ?>
<?php use_javascript('jquery.superfish.min.js'); ?>
<?php use_javascript('jquery.supersubs.min.js'); ?>



<?php
use_plugin_stylesheet('mastodontePlugin', '../js/fancybox/jquery.fancybox-1.3.1.css');
use_plugin_javascript('mastodontePlugin','fancybox/jquery.fancybox-1.3.1.pack.js','last');
?>