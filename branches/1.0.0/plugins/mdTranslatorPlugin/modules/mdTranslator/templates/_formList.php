<?php  use_helper( 'JavascriptBase' ); ?>
<?php  use_helper( 'mdAsset' ); ?>

<div id="<?php echo $page ?>">

<div style="margin-top:10px;" id="translate_form_<?php echo $index ?>">
<ul class="lista">
	<li>
				<?php if($showText): ?>
				<a href="#" style="color: gray; font-size:10px!important; float: right;" onclick="return mdTranslator.getInstance().showReference($(this));"><?php echo __('mdTranslator_mostrar referencia') ?></a>
        <div style="display:none; padding:10px; font-style: italic;background-color: #EfEfEf;"><?php echo ($showText ? $form['translation_base_'.$index]->getValue() : ""); ?></div>
        <div class="clear"></div>
				<br>
				<?php endif; ?>
        <form id="translation_form_<?php echo $index ?>" class="submitearForm" onsubmit="mdTranslator.getInstance().updateTextArea(); mdTranslator.getInstance().save($(this).find('input:[name=translation_source_<?php echo $index ?>]').val(),$(this).find('textarea:[name=translation_new_<?php echo $index ?>]').val(),<?php echo $index ?>); return false;" action="<?php echo url_for('mdTranslator/changeTextAjax'); ?>" method="post">
            <?php echo $form['translation_source_'.$index]->render()  ?>
            <?php echo $form['translation_new_'.$index]->render();?>
            <input type="hidden" name="isTiny" id="isTiny" value="0"/>
            <div style="height: 50px;float:right;margin-top: 20px;">
                <input type="submit" value="Guardar"/>
                <input type="button" value="Cancelar" onclick="translator.close();"/>
            </div>

        </form>
		<?php echo $form->renderHiddenFields();?>
	</li>
</ul>
</div>
<?php
	//$index++;
	echo javascript_tag("
		index++;

        $( 'input:submit, input:button', '#translation_form_".$index."').button();;
	"); ?>

</div>
