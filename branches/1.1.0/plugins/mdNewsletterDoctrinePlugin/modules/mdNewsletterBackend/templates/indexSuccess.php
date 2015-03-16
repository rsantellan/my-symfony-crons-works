<?php slot('manage_newsletter',':D') ?>

<?php
use_helper('mdAsset');

use_plugin_javascript('mdNewsletterDoctrinePlugin', 'mdNeewsLetterBackend.js', 'last');
use_plugin_stylesheet('mdNewsletterDoctrinePlugin', 'table_style.css');
?>
<?php use_plugin_stylesheet('mastodontePlugin', '../js/jquery-ui-1.8.4/css/smoothness/jquery-ui-1.8.4.custom.css') ?>
<?php use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-ui-1.8.4.custom.min.js', 'last') ?>

<?php
include_component('backendBasic', 'backendTemplate', array(
    'module' => 'mdNewsletterBackend',
    'objects' => $pager,
    'formFilter' => $formFilter,
    'notShowFilterTitle' => true
));
?>
<input type="hidden" value="<?php echo url_for("mdNewsletterBackend/retrieveUsersBox");?>" id="refreshSelectUsersData"/>

<input type="hidden" value="<?php echo url_for("mdNewsletterBackend/retrieveGroupsBox");?>" id="refreshSelectGroupData"/>

