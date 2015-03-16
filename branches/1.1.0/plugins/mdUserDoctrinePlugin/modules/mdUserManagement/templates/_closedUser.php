<?php use_helper('mdAsset'); ?>
<li class="md_height_fixed" id='md_object_<?php echo $mdUser->getId() ?>'>
    <div id="loading_close_<?php echo $mdUser->getId() ?>" style="display: none;" class="md_loading_closed_objects"><?php echo plugin_image_tag('mastodontePlugin','md-ajax-loader.gif'); ?></div>
    <ul class="md_closed_object">
    	<li class="md_img">
            <?php if( sfConfig::get( 'sf_plugins_user_media', false ) ):  ?>
            <img id="user_<?php echo $mdUser->getId()?>" src="<?php echo mdWebImage::getUrl($mdUser->getAvatar(1), array(mdWebOptions::WIDTH => 46, mdWebOptions::HEIGHT => 46, mdWebOptions::CODE => mdWebCodes::RESIZE)) ?>" alt="" />
            <?php else: ?>
                    <?php echo plugin_image_tag('mdUserDoctrinePlugin','md_user_image.jpg'); ?>
            <?php endif;?>
        </li>
    	<li class="md_object_name">
        	<div class="md_object_owner">
        		<?php echo $mdUser->getEmail()?> <span>-</span>
        	</div>
            <div class="md_object_categories">
							<?php if(!$mdUser->retrieveMdPassport()) echo "Solo de mailing";?>

            </div>
        </li>
        <li class="md_value"><?php //echo $product->getDisplayPrice()?></li>
        <li class="md_edit">
            <a href="mdUserManagement/getUserDetailAjax?mdUserId=<?php echo $mdUser->getId() ?>" onclick='mdObjectList.openObject(<?php echo $mdUser->getId() ?>,this, event);'><?php echo __('mdUserDoctrine_text_edit') ?></a>
        </li>

    </ul><!--UL PRODUCTO CERRADO-->
</li><!--LI PRODUCTO-->
