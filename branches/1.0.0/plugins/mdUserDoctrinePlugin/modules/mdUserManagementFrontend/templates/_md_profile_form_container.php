<style>
    .msg_error{
        border: 1px solid red;
    }
</style>
<?php echo $name ?>
<div id="user_new_profile_div_<?php echo $mdProfileId; ?>">
    <?php include_partial('mdUserManagementFrontend/profile_form', array('form'=>$form, 'mdProfileId' => $mdProfileId, 'mdUserProfileId' => $mdUserProfileId )) ?>
</div>
