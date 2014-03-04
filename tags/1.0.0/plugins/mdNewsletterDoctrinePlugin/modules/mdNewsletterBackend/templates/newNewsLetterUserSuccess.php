<?php
use_helper('mdAsset');
use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-1.4.2.min.js', 'first');
use_plugin_javascript('mdNewsletterPlugin', 'mdNeewsLetterBackend.js');


?>
<div id="new_newsletter_form_container">
    <?php include_partial("newsletterBackend/simpleForm", array('form'=>$form));?>
</div>
