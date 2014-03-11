    <form action='<?php echo url_for('mdUserManagementFrontend/processMdUserProfileAjax'); ?>' method="post" id='md_user_profile_edit_form'>
        <?php echo $form->renderHiddenFields()?>
        <div class="clear"></div>
            <ul>
                <li>
                    <?php echo __('mdUserDoctrine_text_name') ?> : <?php echo $form['name']->render();?>
                    <div class="user_error_container">
                    <?php
                        $error = $form['name']->getError();
                        if($error)
                        {
                            echo __("error_".$error);
                        }
                    ?>
                    </div>
                </li>
                <li>
                    <?php echo __('mdUserDoctrine_text_lastname') ?> : <?php echo $form['last_name']->render();?>
                    <div class="user_error_container">
                    <?php
                        $error = $form['last_name']->getError();
                        if($error)
                        {
                            echo __("error_".$error);
                        }
                    ?>
                    </div>
                </li>
                <li>
                    <?php echo __('mdUserDoctrine_text_city') ?> : <?php echo $form['city']->render();?>
                    <div class="user_error_container">
                    <?php
                        $error = $form['city']->getError();
                        if($error)
                        {
                            echo __("error_".$error);
                        }
                    ?>
                    </div>
                </li>
                <li>
                    <?php echo __('mdUserDoctrine_text_country') ?> : <?php echo $form['country_code']->render();?>
                    <div class="user_error_container">
                    <?php
                        $error = $form['country_code']->getError();
                        if($error)
                        {
                            echo __("error_".$error);
                        }
                    ?>
                    </div>
                </li>
                
            </ul>
    </form>
