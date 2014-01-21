<?php  //use_helper( 'JavascriptBase' ); ?>
<?php $defaultCulture = $sf_user->getCulture()  ?>

<?php if(count($i18nObj) != 0):?>
<h2>Atributos</h2>
<?php endif;?>

<?php foreach($i18nObj as $I18Object):?>
    <h4>El campo es:  <?php echo $I18Object->getShow()?></h4>

    <form id="form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>" action="<?php echo url_for('mdObjectTranslator/chageTextAjax') ?>" method="post">
        <input type="hidden" value="<?php echo $I18Object->getId()?>" name="object_id"/>
        <input type="hidden" value="<?php echo $I18Object->getClass()?>" name="object_class"/>
        <input type="hidden" value="<?php echo $lang?>" name="lang"/>
        <input type="hidden" value="<?php echo $I18Object->getField()?>" name="field_name"/>
        Base: <?php echo mdI18nObjectHandler::m18nGetFieldFromBasicObject($I18Object->getField(),$I18Object,$defaultCulture,$baseLang) ?>
    <br/>
        <input type="text" name="field" value ="<?php echo mdI18nObjectHandler::m18nGetFieldFromBasicObject($I18Object->getField(),$I18Object,$defaultCulture,$lang) ?>" onChange="save('form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>');"/>
        <img style="display:none" src="/images/ok.png" id="form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>_result"/>
        <span style="display:none;color:red;" id="form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>_error"></span>
    <br/>
    </form>
    <?php ?>
    <?php include_partial('attributesListFormList',array ('i18nObj' => mdI18nObjectHandler::mdI18nGetObjectsAttributesLists($I18Object) , 'lang' => $lang, 'baseLang' => $baseLang )); ?>
<?php endforeach; ?>	
