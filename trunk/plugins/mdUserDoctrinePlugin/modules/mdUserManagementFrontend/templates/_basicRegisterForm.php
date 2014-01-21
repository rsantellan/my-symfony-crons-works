<form action='<?php echo url_for('mdUserManagementFrontend/processNewMdUserProfileAjax'); ?>' method="post" id='user_new_form'>
    <?php echo $form; ?>
</form>
<?php
    //use_helper('mdAsset');
?>

<?php //use_plugin_javascript('mdBasicPlugin', 'Modules/mdUserManagementFrontEnd.js');  ?>

    <div class="clear"></div>
    <div>
        <div id='new_user_profile_form'>
<?php //include_partial('mdUserManagementFrontend/newUser',array('form'=>$form)) ?>
    </div>
</div>
<div class="clear"></div>