<div id="change_user_container">
    <?php include_partial("mdUserManagementFrontend/md_user_profile_form", array("form" => $form)); ?>
</div>

<div id="change_user_profiles_container">

    <?php if( sfConfig::get( 'sf_plugins_user_attributes', false ) ):  ?>
        <?php $profiles = $form->getObject()->getAllUsedProfiles();?>
        <?php foreach($profiles as $prof):?>
            <?php $profForm = $mdUserProfile->getObject()->getAttributesFormOfMdProfile($prof->getMdProfile()->getName()); ?>
            <?php include_partial('mdUserManagementFrontend/md_profile_form_container', array('form'=>$profForm,'name'=> $prof->getMdProfile()->getDisplay(), 'mdProfileId' => $prof->getMdProfile()->getId(), 'mdUserProfileId' => $form->getObject()->getId() )) ?>
        <?php endforeach;?>

    <?php endif; ?>

</div>
<div class="clear"></div>
<div class="float_right">
    <div id="loader_button_change_user_data" style="display: none;float: right;"><?php echo plugin_image_tag('mastodontePlugin',"md-ajax-loader.gif");?></div>
    <input id="button_change_user_data" type="submit" value="<?php echo __("user_changeUserData");?>" onclick="return mdUserManagementFrontend.getInstance().sendChangeUserData()">
</div>
<div class="clear"></div>
