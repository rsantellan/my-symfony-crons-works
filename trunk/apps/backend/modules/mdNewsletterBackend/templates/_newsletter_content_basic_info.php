<div id="md_basic_<?php echo $form->getObject()->getId() ?>" class="md_open_object_top">
  <div class="md_blocks">
    <h2><?php echo __("newsletter_asunto"); ?></h2>
    
    <div style="padding: 2px; margin: 2px;" class="<?php if ($form['subject']->hasError()): ?>error_msg<?php endif; ?>">
      <?php echo $form['subject']->render(array('id' => 'md_input_name', 'style' => 'width: 350px')); ?>
    </div>
    <?php if ($form['subject']->hasError()): echo '<div>' . __("newsletter_asunto") . ': ' . $form['subject']->getError() . '</div>';  endif; ?>
    <div class="clear"></div>
    <h2><?php echo __("newsletter_mensaje"); ?></h2>
    <div style="padding: 2px; margin: 2px;" class="<?php if ($form['body']->hasError()): ?>error_msg<?php endif; ?>">
      <?php echo $form['body']->render(array()); ?>
    </div>
    <div>
      <?php if ($form['body']->hasError()): echo '<div>' . __("newsletter_mensaje") . ': ' . $form['body']->getError() . '</div>';  endif; ?>
    </div>    
  </div>
  <div class="clear"></div>
</div>
<!--FIN ABIERTO TOP-->
