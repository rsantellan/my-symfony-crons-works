<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>upload</title>
<link rel="stylesheet" type="text/css" href="/mdMediaManagerPlugin/css/upload.css" />
<script type="text/javascript" src="/mdMediaManagerPlugin/js/FeatureDoctrine.js"></script>
<?php use_stylesheets_for_form($form)?>
<?php use_javascripts_for_form($form)?>
</head> 

<body style="overflow:hidden; height:200px">

<div class="dialog">
    <div class="top">
        <div class="headline upload">
            <h2><?php echo __('mdMediaManager_text_titleUpload');?></h2>

            <p class="description"><?php echo __('mdMediaManager_text_descriptionUpload');?></p>
        </div>
    </div>
    <?php if(isset($manager)): ?>
    <div id="facts" class="facts">
        <?php echo __('mdMediaManager_text_validExtensions'); ?> <?php echo sfConfig::get('sf_plugins_upload_content_type_'.$manager->getMdObject()->getObjectClass(), '*.jpg;*.jpeg;*.gif;*.png') ?><br /><!--<?php echo __('mdMediaManager_text_maxUpload'); ?> 10 MB<br />-->
    </div>
    <?php endif; ?>
    <div id="content">

        <div id="uploadarea">
            <?php if(isset($manager)): ?>

                <?php include_partial('uploader/swf_single', array('manager' => $manager, 'album_id' => $album_id)); ?>

                <?php include_partial('uploader/swf_multiple', array('form' => $form, 'manager' => $manager, 'album_id' => $album_id)); ?>
                
                <script type="text/javascript">
                    var __MD_OBJECT_ID = <?php echo $manager->getMdObject()->getId(); ?>;
                    var __MD_OBJECT_CLASS = "<?php echo $manager->getMdObject()->getObjectClass(); ?>";
                </script>

            <?php else: ?>

                <?php include_partial('uploader/swf_single_gallery', array('category' => $category)); ?>

                <?php include_partial('uploader/swf_multiple_gallery', array('form' => $form, 'category' => $category)); ?>

            <?php endif; ?>
        </div>

    </div>
</div>

<div id="upload_container_overlay" class="upload_container" style="display:none"></div>

<div id="upload_container" class="upload_progress" style="display:none">
    <div class="progressWindow"><?php echo __('mdMediaManager_text_uploading');?>...</div>
</div>

</body>

</html>
