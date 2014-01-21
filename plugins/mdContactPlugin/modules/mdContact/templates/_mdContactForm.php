<?php
slot('mdContact', true);

use_helper('mdAsset');


use_plugin_stylesheet('mdContactPlugin', 'mdContact');

?>
    <div id="mdContact">
    <?php echo $form->renderGlobalErrors() ?>
        <form name="<?php echo $form->getName();?>" method="POST" action="<?php echo url_for('@mdContact') ?>">
            <label for="<?php echo $form['nombre']->renderId()?>"><?php echo __('mdContact_text_name');?></label> <?php echo $form['nombre']->render() ?><span>*</span>
            <label for="<?php echo $form['apellido']->renderId()?>"><?php echo __('mdContact_text_lastname');?></label> <?php echo $form['apellido']->render() ?><span>*</span>
            <label for="<?php echo $form['mail']->renderId()?>"><?php echo __('mdContact_text_mail');?></label> <?php echo $form['mail']->render() ?><span>*</span>
            <label for="<?php echo $form['telefono']->renderId()?>"><?php echo __('mdContact_text_phone');?></label> <?php echo $form['telefono']->render() ?><span>*</span>
            <label for="<?php echo $form['pais']->renderId()?>"><?php echo __('mdContact_text_country');?></label> <?php echo $form['pais']->render(array('style' => 'width:420px;margin-bottom:15px;')) ?><span>*</span>
            <label for="<?php echo $form['comentario']->renderId()?>"><?php echo __('mdContact_text_comment');?></label> <?php echo $form['comentario']->render() ?><span>*</span>
            <?php if(sfConfig::get('sf_plugins_contact_captcha_available', false)): ?>
                <?php if($form['captcha']->hasError()): ?>
                    <span id="md-captcha-error">The captcha is not valid (invalid captcha).</span>
                <?php endif; ?>
                <div id="md_captcha"><?php echo $form['captcha']->render() ?></div>
            <?php endif; ?>
            <?php echo $form->renderHiddenFields() ?>
            <input type="submit" id="input_submit" value="<?php echo __('mdContact_text_send');?>" name="Submit">
        </form>
        <div class="clear"></div>
        <div class="text_form"><span>*</span><?php echo __('mdContact_text_requieredFields');?></div>
    </div>
