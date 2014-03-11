<?php  use_helper( 'JavascriptBase' ); ?>
<?php $defaultCulture = $sf_user->getCulture()  ?>

<div id="<?php echo $object ?>">

<?php $attShown = true; ?>

<?php foreach($objects as $obj): ?>

    <?php
    $mdProfileObjects = Doctrine::getTable('mdProfileObject')->findByMultiples(array('object_id', 'object_class_name'), array($obj->getId(), $obj->getObjectClass()));
    $mdProfiles = array();
    if (count($mdProfileObjects) !== 0)
    {
        foreach ($mdProfileObjects as $mdProfileObject)
        {
            $mdProfiles[] = $mdProfileObject->getMdProfile();
        }
    }
    ?>

    <?php if($attShown == true):?>
        <?php include_partial('attributesFormList',array ('i18nObj' => mdI18nObjectHandler::mdI18nGetObjectsAttributes($obj) , 'lang' => $lang, 'baseLang' => $baseLang )); ?>
        <?php $attShown = false; ?>
    <?php endif;?>

    <div style="margin-top:10px;" id="translate_form_<?php echo $index ?>">

        <h1><?php echo $obj; ?></h1>

        <?php if (count($mdProfileObjects) !== 0): ?>

            <?php foreach($mdProfiles as $mdProfile): ?>
        
                <h2>Perfil: <?php echo $mdProfile->getName(); ?></h2>

                <?php $i18nObj = mdI18nObjectHandler::mdI18nGetObjects($obj, $mdProfile->getId()); ?>

                <?php foreach($i18nObj as $I18Object):?>

                    <h4>El campo es:  <?php echo $I18Object->getShow()?></h4>
                    <form id="form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>" action="<?php echo url_for('mdObjectTranslator/chageTextAjax') ?>" method="post">
                        <input type="hidden" value="<?php echo $I18Object->getId()?>" name="object_id"/>
                        <input type="hidden" value="<?php echo $I18Object->getClass()?>" name="object_class"/>
                        <input type="hidden" value="<?php echo $lang?>" name="lang"/>
                        <input type="hidden" value="<?php echo $I18Object->getField()?>" name="field_name"/>
                        Base: <?php echo mdI18nObjectHandler::mI18nGetFieldFromClass($I18Object->getField(),$I18Object->getClass(),$I18Object->getId(),$defaultCulture,$baseLang) ?>
                        <br/>
                        <textarea name="field" onChange="mdPluginTranslatorObjectDoctrine.getInstance().save('#form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>');"><?php echo mdI18nObjectHandler::mI18nGetFieldFromClass($I18Object->getField(),$I18Object->getClass(),$I18Object->getId(),$defaultCulture,$lang) ?></textarea>
                        <img style="display:none" src="/images/ok.png" id="form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>_result"/>
                        <span style="display:none;color:red;" id="form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>_error"></span>
                        <br/>
                    </form>

                <?php endforeach; ?>

            <?php endforeach; ?>

        <?php else: ?>

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
                        <textarea name="field" onChange="mdPluginTranslatorObjectDoctrine.getInstance().save('#form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>');"><?php echo mdI18nObjectHandler::mI18nGetFieldFromClass($I18Object->getField(),$I18Object->getClass(),$I18Object->getId(),$defaultCulture,$lang) ?></textarea>
                        <img style="display:none" src="/images/ok.png" id="form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>_result"/>
                        <span style="display:none;color:red;" id="form_<?php echo $I18Object->getClass().'_'.$I18Object->getId().'_'.$I18Object->getField()?>_error"></span>
                        <br/>
                    </form>

            <?php endforeach; ?>

        <?php endif; ?>

        <?php include_partial('relatedFormList',array ('objects' => $obj->getRelatedObjects() , 'lang' => $lang, 'baseLang' => $baseLang )); ?>
    </div>
    <hr/>
    <?php $index++; ?>
    <?php echo javascript_tag("index++; ");?>
<?php endforeach;?>
</div>
