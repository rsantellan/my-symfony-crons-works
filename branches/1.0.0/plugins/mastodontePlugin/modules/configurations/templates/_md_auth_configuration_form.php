<form action='<?php echo url_for('configurations/processmdAuthXMLFormAjax'); ?>' method="post" id='xmlFormConfiguration_<?php echo $form->retrieveUserName();?>' onsubmit="return false">
  <?php echo $form->renderHiddenFields();?>
  <?php //echo $form ?>
  <div class="md_blocks" style="display:none">
    <h2><?php echo $form['user_old']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['user_old']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $form['user_old']->render()?>
    </div>
    <div><?php if($form['user_old']->hasError()):  echo $form['user_old']->renderLabelName() .': '. $form['user_old']->getError(); endif; ?></div>
  </div>
  <div class="md_blocks">
    <h2><?php echo $form['user']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['user']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $form['user']->render()?>
    </div>
    <div><?php if($form['user']->hasError()):  echo $form['user']->renderLabelName() .': '. $form['user']->getError(); endif; ?></div>
  </div>
  <div class="md_blocks">
    <h2><?php echo $form['pass']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['pass']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $form['pass']->render()?>
    </div>
    <div><?php if($form['pass']->hasError()):  echo $form['pass']->renderLabelName() .': '. $form['pass']->getError(); endif; ?></div>
  </div>
  <div class="clear"></div>    
  <div class="md_blocks">
    <h2><?php echo $form['name']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['name']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $form['name']->render()?>
    </div>
    <div><?php if($form['name']->hasError()):  echo $form['name']->renderLabelName() .': '. $form['name']->getError(); endif; ?></div>
  </div>
  <div class="md_blocks">
    <h2><?php echo $form['email']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['email']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $form['email']->render()?>
    </div>
    <div><?php if($form['email']->hasError()):  echo $form['email']->renderLabelName() .': '. $form['email']->getError(); endif; ?></div>
  </div>
  <div class="clear"></div>  
  <input type="button" value="<?php echo __('mdConfiguration_text_save') ?>"  onclick="mdConfiguration.getInstance().saveMdXMLAuth('<?php echo $form->retrieveUserName();?>');"/>
</form>
