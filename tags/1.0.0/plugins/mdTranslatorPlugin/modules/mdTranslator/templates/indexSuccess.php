<?php
    slot('mdTranslator', 'mdTranslator');
    use_helper('mdAsset');
	use_helper( 'JavascriptBase' );
	use_helper('I18N');
	use_javascript('tiny_mce/tiny_mce.js', 'last');
    
    use_plugin_stylesheet('mastodontePlugin', '../js/jquery-ui-1.8.4/css/smoothness/jquery-ui-1.8.4.custom.css');
    use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-ui-1.8.4.custom.min.js', 'last');
    use_plugin_javascript('mastodontePlugin','jquery-ui-1.8.4/development-bundle/ui/i18n/jquery.ui.datepicker-'.sfContext::getInstance()->getUser()->getCulture().'.js','last');

    use_plugin_javascript('mdTranslatorPlugin', 'mdTranslator.js', 'last');
    use_plugin_stylesheet('mdTranslatorPlugin', 'translator');
    use_plugin_javascript('mastodontePlugin', 'mdTranslatorViewHandler.js');
    use_plugin_javascript('mdTranslatorPlugin', 'mdTranslatorPublish.js', 'last');
?>

<div id="contenido">
    <div id="md_center_container">
        <div class="md_shadow">
            <div class="md_center">
                <div class="md_content_center">
                    <h1>Manejador de textos</h1>
                    <div id="md_content_right">
                        <div id="datos"></div>
                        <h2><?php echo $error?></h2>
                    </div>
                </div>
            </div><!--MAIN CONTAINER-->
        </div>
    </div>

    <div class="md_right_container">
        <div class="md_right_shadow">
            <div class="md_center_right">
                <div>
                    <form action="index" method="post" style="padding-left: 20px;">
                        <?php if ($appCount > 1): ?>
                        <?php echo $selectionForm['application']->renderLabel() ?> <div style="clear:both"></div>
                        <?php endif; ?>
                        <?php echo $selectionForm['application']->render() ?><div style="clear:both"></div>
                        <?php echo $selectionForm['catalogue']->render() ?><div style="clear:both"></div>
                        <?php //echo $selectionForm['base_language']->renderLabel() ?><div style="clear:both"></div>
                        <?php echo $selectionForm['base_language']->render() ?><div style="clear:both"></div>
                        <?php //echo $selectionForm['language']->renderLabel() ?><div style="clear:both"></div>
                        <?php echo $selectionForm['language']->render() ?><div style="clear:both"></div>
                        <?php echo $selectionForm['search']->renderLabel(); ?>: <div style="clear:both"></div>
                        <?php echo $selectionForm['search']->render() ?><div style="clear:both"></div>
                        <?php echo $selectionForm['search_target']->renderLabel(); ?>
                        <?php echo $selectionForm['search_target']->render() ?><div style="clear:both"></div> 
                        <hr style="margin-right: 20px" />
                        <div id="app_pages" class="chkListOut"></div><div style="clear:both"></div>
                    </form>
                </div>
            </div><!--CENTER_LEFT-->
        </div><!--SOMBRA_LEFT-->
    </div><!--LEFT-->
    <div id="backend_right_floating"class="md_right_container" style="float:right;<?php if(!sfConfig::get( 'sf_plugins_translator_add_new_word', false )) echo ((isset($_GET['v']) && $_GET['v'] == '1') ? '' : 'display:none');?>">
        <div id="create_permission_right_box" class="md_right_shadow">
          <div class="md_center_right">
              <div class="md_content_right">
                  <div id="add-content">

                    <div id='permission_new_form_div'>
                      <h2><?php echo __('mdTranslator_addWord'); ?></h2>
                      <div id="new_word_form_holder">
                          <?php //echo $newWordForm?>
                        <?php include_partial('newWordForm', array('form'=>$newWordForm)); ?>
                      </div>
                    </div>

                  </div>
                  <a onclick="$('#backend_right_floating').hide()" href="javascript:void(0);"><?php echo __('mdTranslator_close'); ?></a>
              </div>
          </div>
        </div>
    </div>
</div>
<?php
echo javascript_tag("
    mdTranslator.getInstance()._initialize();

    var translator = new mdTranslatorViewHandler('mdTranslator');
    
");

if($display == 'block'){
    echo javascript_tag("
        mdTranslatorPublish.getInstance().hasToPublish();
    ");
}
?>
