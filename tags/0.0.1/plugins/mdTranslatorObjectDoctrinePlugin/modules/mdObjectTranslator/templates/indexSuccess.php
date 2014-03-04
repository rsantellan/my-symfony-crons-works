<?php 
	use_helper( 'JavascriptBase' );
	use_helper('I18N');
	use_helper('mdAsset');
    use_plugin_javascript('mdTranslatorObjectDoctrinePlugin', 'mdTranslatorObjectDoctrine.js');
	use_stylesheet('translator');
?>

<div id="contenido">
    <div id="md_center_container">
        <div class="md_shadow">
            <div class="md_center">
                <div class="md_content_center">
                    <h1>Manejador de textos</h1>
                    <div id="md_content_right">
                        <div id="datos"></div>
                        <h2><?php //echo $error?></h2>
                    </div>
                </div>
            </div><!--MAIN CONTAINER-->
        </div>
    </div>
    <div>
        <a id="show_publish" href="javascript:void(0)" style="display:<?php echo $display;?>" onclick="return publish();">
            <img id="publicar" class="publicar" src="/mdBasicPlugin/images/publicar.png" />
        </a>
    </div>
    <div class="md_right_container">
        <div class="md_right_shadow">
            <div class="md_center_right">
                <div>
                    <form style="padding-left: 20px;" action="index" method="post">
                        <ul>
                            <li><?php echo $selectionForm['selected_app']->renderLabel() ?></li>
                            <li><?php echo $selectionForm['selected_app']->render() ?><?php echo $selectionForm['selected_catalogue']->render() ?></li>
                            <li><?php echo $selectionForm['base_lang']->renderLabel() ?></li>
                            <li><?php echo $selectionForm['base_lang']->render() ?></li>
                            <li><?php echo $selectionForm['selected_lang']->renderLabel() ?></li>
                            <li><?php echo $selectionForm['selected_lang']->render() ?></li>
                            <li><div id="app_object" class="chkListOut"></div></li>
                        </ul>
                        <div id="app_pages" class="chkListOut"></div><div style="clear:both"></div>
                    </form>
                </div>
            </div><!--CENTER_LEFT-->
        </div><!--SOMBRA_LEFT-->
    </div><!--LEFT-->
</div>

<?php
echo javascript_tag("
    mdPluginTranslatorObjectDoctrine.getInstance()._initialize();
");