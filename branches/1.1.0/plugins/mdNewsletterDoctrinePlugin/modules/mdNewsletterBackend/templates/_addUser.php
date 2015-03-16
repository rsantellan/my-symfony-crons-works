<form action="<?php echo url_for("mdNewsletterBackend/saveNewMdNewsletterUser");?>" onsubmit="return mdNeewsLetterBackend.getInstance().addNewEmail();" method="post" id="newsletter_new_form" name="<?php echo $form->getName();?>" >
    <?php echo $form->renderHiddenFields();?>
    <div style="float: left;">
        <ul class="filter">
            <li><?php echo $form['mail']->render() ?></li>
            <?php if($form['mail']->hasError()): ?>
              <li class="error"><?php echo $form['mail']->renderError();?></li>
            <?php endif;?>
            <li id="add_new_user_success" style="display:none">
              <h3><?php echo __("newsletter_nuevo mail guardado");?></h3>
            </li>
        </ul>
    </div>
    <div class="clear"></div>
    <?php if( sfConfig::get( 'sf_plugins_newsletter_group_enable', false ) ): ?>
      <?php if(count($groups) > 0): ?>
        <select name="newsletter_group">
          <?php foreach($groups as $group): ?>
            <option value="<?php echo $group->getId();?>"><?php echo $group->getName();?></option>
          <?php endforeach; ?>
          
        </select>
        <div class="clear"></div>
      <?php endif; ?>
    <?php endif; ?>
    <input type="submit" value="<?php echo __("newsletter_guardar");?>" />
</form>
