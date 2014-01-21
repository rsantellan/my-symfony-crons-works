<div style="height: 51px; margin: 4px;" ajax-url="<?php echo url_for("mdUserManagement/openBox")."?id=".$object->getId() ?>">
    <ul class="md_closed_object">
        <li class="md_img">
            
            <?php $hasImage = false; ?>
            <?php if( sfConfig::get( 'sf_plugins_user_media', false ) ):  ?>
                <?php $mdUserProfile = $object->getMdUserProfile(); ?>
                <?php if($mdUserProfile):?>
            <img id="user_<?php echo $object->getId()?>" src="<?php echo $mdUserProfile->retrieveAvatar(array(mdWebOptions::WIDTH => 46, mdWebOptions::HEIGHT => 46, mdWebOptions::CODE => mdWebCodes::RESIZE), mdMediaManager::IMAGES); ?>" />
                    <?php $hasImage = true; ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(!$hasImage): ?>
                <?php use_helper('mdAsset');?>
                <?php echo plugin_image_tag('mdUserDoctrinePlugin','md_user_image.jpg'); ?>            
            <?php endif;?>
        </li>
        <li class="md_object_name">
            <?php echo html_entity_decode( $object->getBackendClosedBoxText()); ?>
        </li>
    </ul>
</div>
