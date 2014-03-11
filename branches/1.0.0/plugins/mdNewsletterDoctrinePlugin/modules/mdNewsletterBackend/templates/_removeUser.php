<form action="<?php echo url_for("mdNewsletterBackend/removeMdNewsletterUser");?>" onsubmit="return mdNeewsLetterBackend.getInstance().removeEmail();" method="post" id="newsletter_remove_form" name="<?php echo $form->getName();?>" >
    <?php echo $form->renderHiddenFields();?>
    <div style="float: left;">
        <ul class="filter">
            <li><?php echo $form['mail']->render() ?></li>
            <?php if($form['mail']->hasError()): ?>
              <li class="error"><?php echo $form['mail']->renderError();?></li>
            <?php endif;?>
            <li id="remove_user_success" style="display:none">
              <h3><?php echo __("newsletter_mail eliminado");?></h3>
            </li>            
            <li id="remove_user_no_exists_error" style="display:none">
              <h3><?php echo __("newsletter_no existe el mail");?></h3>
            </li>            
        </ul>
    </div>
    <div class="clear"></div>
    <input type="submit" value="<?php echo __("newsletter_guardar");?>" />
</form>
