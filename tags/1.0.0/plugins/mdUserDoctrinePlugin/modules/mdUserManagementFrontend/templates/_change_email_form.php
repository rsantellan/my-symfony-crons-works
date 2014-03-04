<?php use_helper("mdAsset");?>
<form action="<?php echo url_for('@changeEmail') ?>" method="post" id="change_email_form">
    <ul>
        <li>
            Email: <?php echo $form['email']->render(); ?>
            <div class="clear"></div>
            <div id="email_error_container">
            <?php 
                $error = $form['email']->getError();
                if($error)
                {
                    echo __("error_".$error);
                }
            ?>
            </div>
            <?php echo $form->renderHiddenFields(); ?>
        </li>
        <li>
            <div class="float_right">
                <div id="loader_button_change_mail" style="display: none;float: right;"><?php echo plugin_image_tag('mastodontePlugin',"md-ajax-loader.gif");?></div>
                <input id="button_change_mail" type="submit" value="<?php echo __("user_changeEmail");?>" onclick="return mdUserManagementFrontend.getInstance().sendChangeEmail()">
            </div>
            <div class="clear"></div>
        </li>

    </ul>
</form>