<form action='<?php echo url_for('configurations/processmdMailXMLFormAjax'); ?>' method="post" id='xmlMailConfiguration' onsubmit="return false">
  <?php echo $xmlMailForm->renderHiddenFields();?>
  <?php //echo $xmlMailForm ?>
  <div class="md_blocks">
    <h2><?php echo $xmlMailForm['contact']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($xmlMailForm['contact']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $xmlMailForm['contact']->render()?>
    </div>
    <div><?php if($xmlMailForm['contact']->hasError()):  echo $xmlMailForm['contact']->renderLabelName() .': '. $xmlMailForm['contact']->getError(); endif; ?></div>
  </div>
  <div class="md_blocks">
    <h2><?php echo $xmlMailForm['recipient']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($xmlMailForm['recipient']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $xmlMailForm['recipient']->render()?>
    </div>
    <div><?php if($xmlMailForm['recipient']->hasError()):  echo $xmlMailForm['recipient']->renderLabelName() .': '. $xmlMailForm['recipient']->getError(); endif; ?></div>
  </div>
  <div class="clear"></div>  
  <div class="md_blocks">
    <h2><?php echo $xmlMailForm['automatic']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($xmlMailForm['automatic']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $xmlMailForm['automatic']->render()?>
    </div>
    <div><?php if($xmlMailForm['automatic']->hasError()):  echo $xmlMailForm['automatic']->renderLabelName() .': '. $xmlMailForm['automatic']->getError(); endif; ?></div>
  </div>
  <div class="clear"></div>  
  <div class="md_blocks">
    <h2><?php echo $xmlMailForm['from_client']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($xmlMailForm['from_client']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $xmlMailForm['from_client']->render()?>
    </div>
    <div><?php if($xmlMailForm['from_client']->hasError()):  echo $xmlMailForm['from_client']->renderLabelName() .': '. $xmlMailForm['from_client']->getError(); endif; ?></div>
  </div>
  <div class="clear"></div>  
  <div class="md_blocks">
    <h2><?php echo $xmlMailForm['mail']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($xmlMailForm['mail']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $xmlMailForm['mail']->render()?>
    </div>
    <div><?php if($xmlMailForm['mail']->hasError()):  echo $xmlMailForm['mail']->renderLabelName() .': '. $xmlMailForm['mail']->getError(); endif; ?></div>
  </div>
  <div class="md_blocks">
    <h2><?php echo $xmlMailForm['from']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($xmlMailForm['from']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $xmlMailForm['from']->render()?>
    </div>
    <div><?php if($xmlMailForm['from']->hasError()):  echo $xmlMailForm['from']->renderLabelName() .': '. $xmlMailForm['from']->getError(); endif; ?></div>
  </div>
  <div class="clear"></div> 
  <input type="button" value="<?php echo __('mdConfiguration_text_save') ?>"  onclick="mdConfiguration.getInstance().saveMdXMLMail();"/>
</form>
