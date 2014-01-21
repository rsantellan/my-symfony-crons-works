<form action="<?php echo url_for("@subscription_newsletter");?>" method="post" id="newsletter_form_<?php echo $number;?>" name="<?php echo $form->getName();?>" onsubmit="return sendMdNewsLetter(<?php echo $number;?>);">
    <?php echo $form->renderHiddenFields(); ?>
    <input type="hidden" value="<?php echo $number;?>" name="number"/>
    <input type="hidden" value="<?php echo $position;?>" name="position"/>
    <label id="mailNewsLetterLB_<?php echo $number;?>" class="search_button" for="newsLetter_mail_<?php echo $number;?>">Suscribirse a newsletter</label>
    <?php echo $form['mail']->render(array("class"=>"textfield", "id"=>"newsLetter_mail_".$number));?>
    <input name="Submit" id="Submit_newsletter_<?php echo $number;?>" type="button" class="botonnews" alt="Enviar" title="Enviar" value="Enviar"/>
    <?php echo image_tag("bar-ajax-loader.gif", array("style"=>"display:none", "id" => "loader_info_news_letter_".$number));?>
</form>