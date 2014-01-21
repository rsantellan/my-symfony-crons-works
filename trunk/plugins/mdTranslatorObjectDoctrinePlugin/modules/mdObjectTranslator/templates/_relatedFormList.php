<?php  //use_helper( 'JavascriptBase' ); ?>
<?php $defaultCulture = $sf_user->getCulture()  ?>

<?php
foreach($objects as $obj): ?>
<div class="attributeList">
<h1><?php echo  $obj->getClass();?></h1>
	<?php $i18nObj = mdI18nObjectHandler::mdI18nGetObjects($obj)?>

  		<?php foreach($i18nObj as $I18Object):?>
  			<h4>El campo es:  <?php echo $I18Object->getShow()?></h4>
  			
  			<form id="form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>" action="<?php echo url_for('mdObjectTranslator/chageTextAjax') ?>" method="post">
  				<input type="hidden" value="<?php echo $I18Object->getId()?>" name="object_id"/>
  				<input type="hidden" value="<?php echo $I18Object->getClass()?>" name="object_class"/>
  				<input type="hidden" value="<?php echo $lang?>" name="lang"/>
  				<input type="hidden" value="<?php echo $I18Object->getField()?>" name="field_name"/>
  				Base: <?php echo mdI18nObjectHandler::mI18nGetFieldFromClass($I18Object->getField(),$I18Object->getClass(),$I18Object->getId(),$defaultCulture,$baseLang) ?>
			<br/>
				<input type="text" name="field" value ="<?php echo mdI18nObjectHandler::mI18nGetFieldFromClass($I18Object->getField(),$I18Object->getClass(),$I18Object->getId(),$defaultCulture,$lang) ?>" onChange="save('form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>');"/>
				<img style="display:none" src="/images/ok.png" id="form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>_result"/>
				<span style="display:none;color:red;" id="form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>_error"></span>
			<br/>
			</form>
  			
  		<?php endforeach; ?>	
	
</div>
<?php
endforeach;?>