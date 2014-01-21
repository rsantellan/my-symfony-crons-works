<form action='<?php echo url_for('configurations/processmdSaleXMLFormAjax'); ?>' method="post" id='xmlSaleConfiguration' onsubmit="return false">
  <?php echo $form->renderHiddenFields();?>
  <?php //echo $form; ?>
  <div class="md_blocks">
    <h2><?php echo $form['information_sale_email']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['information_sale_email']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $form['information_sale_email']->render()?>
    </div>
    <div><?php if($form['information_sale_email']->hasError()):  echo $form['information_sale_email']->renderLabelName() .': '. $form['information_sale_email']->getError(); endif; ?></div>
  </div>
      <div class="clear"></div>  
  <div class="md_blocks">
    <h2><?php echo $form['information_reply_on']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['information_reply_on']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $form['information_reply_on']->render(array(), array('checked'=>'checked'))?>
    </div>
    <div><?php if($form['information_reply_on']->hasError()):  echo $form['information_reply_on']->renderLabelName() .': '. $form['information_reply_on']->getError(); endif; ?></div>
  </div>
  
  <div class="md_blocks">
    <h2><?php echo $form['information_inform_buyer']->renderLabelName();?></h2>
    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['information_inform_buyer']->hasError()):?>error_msg<?php endif; ?>">
    <?php echo $form['information_inform_buyer']->render()?>
    </div>
    <div><?php if($form['information_inform_buyer']->hasError()):  echo $form['information_inform_buyer']->renderLabelName() .': '. $form['information_inform_buyer']->getError(); endif; ?></div>
  </div>
  <div class="clear"></div> 
  <input type="button" value="<?php echo __('mdConfiguration_text_save') ?>"  onclick="mdConfiguration.getInstance().saveMdXMLSales();"/>
</form>
