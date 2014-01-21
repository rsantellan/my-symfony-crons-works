<div id="md_basic_<?php echo $form->getObject()->getId() ?>" class="md_open_object_top">
    <div class="md_blocks">
        <h2><?php echo __("newsletter_asunto");?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['subject']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['subject']->render(array('id'=>'md_input_name')); ?>
        </div>
        <div><?php if($form['subject']->hasError()): echo __("newsletter_asunto") .': '. $form['subject']->getError();  endif; ?></div>
    </div>
   <div class="clear"></div>
</div>
<!--FIN ABIERTO TOP-->
