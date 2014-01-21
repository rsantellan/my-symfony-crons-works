<div class="md_blocks">
    <?php foreach($form['mdAttributes'] as $mdAttForm):?>
    <?php $index = 0; ?>
    <?php foreach($mdAttForm as $field): ?>
      <?php if(!$field->isHidden()): ?>
        <?php if($index == 2): ?>
            <?php $index = 0; ?>
            <div class="clear"></div>
        <?php endif;?>
        <div class="md_blocks">
            <h2><?php echo $field->renderLabelName();?></h2>
            <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($field->hasError()):?>error_msg<?php endif; ?>">
                <?php echo $field->render()?>
            </div>
            <div>
                <?php if($field->hasError()):  echo $field->renderLabelName() .': '. $field->getError(); endif; ?>
            </div>
        </div>
        <?php $index ++; ?>
      <?php endif; ?>
    <?php endforeach; ?>
      <div class="clear"></div>
    <?php endforeach; ?>
</div>
