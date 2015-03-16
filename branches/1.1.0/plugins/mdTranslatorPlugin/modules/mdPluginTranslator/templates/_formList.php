<?php  use_helper( 'JavascriptBase' ); ?>
<?php  use_helper( 'mdAsset' ); ?>

<div id="<?php echo $page ?>">

<?php
foreach($forms as $form): ?>
<div style="margin-top:10px;" id="translate_form_<?php echo $index ?>">
<ul class="lista">
	<li>
		<?php
            $txt = explode('_', $form['translation_source_text_'.$index]->getValue());
            $name = $txt[0]; array_shift($txt);
            echo $name .', '. implode(' ', $txt);
        ?>
	</li>
	<li>
		<p style="padding:10px; font-style: italic;"><?php echo $form['translation_base_'.$index]->getValue() ?></p>
        <div class="clear"></div>
        <form class="submitearForm" onsubmit="tinyMCE.triggerSave(true,true);  mdPluginTranslator.getInstance().save($(this).find('input:[name=translation_source_<?php echo $index ?>]').val(),$(this).find('textarea:[name=translation_new_<?php echo $index ?>]').val(),<?php echo $index ?>); return false;" action="<?php echo url_for('mdPluginTranslator/changeTextAjax'); ?>" method="post">
            <?php echo $form['translation_source_'.$index]->render()  ?>
            <?php echo $form['translation_new_'.$index]->render();?> <?php echo plugin_image_tag('mdTranslatorPlugin','ok.png', array('id'=>'result_'.$index, 'style'=>'display:none'));?>
            <input type="submit" value="Guardar" />
        </form>
		<?php echo $form->renderHiddenFields();?>
	</li>
</ul>
</div>
<?php
	$index++;
	echo javascript_tag("
		index++;
	");
endforeach;?>

</div>
