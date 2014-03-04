<form action="<?php echo url_for("newsletterBackend/saveNewMdNewsletterUser");?>" onsubmit="return mdNeewsLetterBackend.getInstance().addEmail();" method="post" id="newsletter_new_form" name="<?php echo $form->getName();?>" >
    <?php echo $form;?>
    <div class="clear"></div>
    <input type="submit" value="<?php echo __("newsletter_guardar");?>" />
    <input type="button" value="<?php echo __("newsletter_cancelar");?>" onclick="return mdNeewsLetterBackend.getInstance().cancelAddEmail();"/>
</form>