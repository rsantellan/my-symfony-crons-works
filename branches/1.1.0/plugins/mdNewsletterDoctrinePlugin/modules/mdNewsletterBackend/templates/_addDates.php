<form id="sending_form" method="POST" action="<?php echo url_for('mdNewsletterBackend/saveMdNewsLetterContentSended'); ?>" onsubmit="return mdNeewsLetterBackend.getInstance().saveNewsLetterSending()">

  <?php echo $form->renderHiddenFields();?>

  <div>

    <input type="radio" name="send" value="0" onclick="mastodontePlugin.UI.BackendFloating.getInstance().remove('create_group_right_box');" checked /><?php echo __("newsletter_seleccionar todos");?>
    <input type="radio" name="send" value="1" onclick="mdNeewsLetterBackend.getInstance().refreshUsersSelectEmails();" /><?php echo __("newsletter_seleccionar algunos");?>

    <?php if( sfConfig::get( 'sf_plugins_newsletter_group_enable', false ) ): ?>
      <input type="radio" name="send" value="2" onclick="mdNeewsLetterBackend.getInstance().refreshGroupsSelectEmails();" /><?php echo __("newsletter_seleccionar grupo");?>
    <?php endif; ?>

    <input type="hidden" name="send_users" id="send_users" value=""/>
    <input type="hidden" name="send_groups" id="send_groups" value=""/>
  </div>

  <div class="clear"></div>
  <br />

  <?php //echo __("newsletter_fecha de envio");?>
  
  <?php echo $form['sending_date']->render();?>
  
  <input type="submit" value="<?php echo __("newsletter_guardar");?>"/>

</form>
