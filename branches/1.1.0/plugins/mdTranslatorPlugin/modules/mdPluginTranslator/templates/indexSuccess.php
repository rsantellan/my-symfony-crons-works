<?php
    slot('mdPluginTranslator', 'mdPluginTranslator');
    use_helper('mdAsset');
	use_helper( 'JavascriptBase' );
	use_helper('I18N');
	use_javascript('tiny_mce/tiny_mce.js', 'last');
    use_plugin_javascript('mdTranslatorPlugin', 'mdPluginTranslator.js', 'last');
    use_plugin_stylesheet('mdTranslatorPlugin', 'translator');    
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
    <div>
        <a id="show_publish" href="javascript:void(0)" style="display:<?php echo $display;?>" onclick="mdPluginTranslator.getInstance().publish();">
            <?php echo plugin_image_tag('mdTranslatorPlugin','publicar.png', array('id'=>'publicar', 'class'=>'publicar'));?>
        </a>
    </div>
    <div class="md_right_container">
        <div class="md_right_shadow">
            <div class="md_center_right">
                <div>
                    <form action="index" method="post" style="padding-left: 20px;">
                        <?php echo $selectionForm['plugin']->renderLabel() ?> <div style="clear:both"></div>
                        <?php echo $selectionForm['plugin']->render() ?><div style="clear:both"></div>
                        <?php echo $selectionForm['catalogue']->render() ?><div style="clear:both"></div>
                        <?php echo $selectionForm['base_language']->renderLabel() ?><div style="clear:both"></div>
                        <?php echo $selectionForm['base_language']->render() ?><div style="clear:both"></div>
                        <?php echo $selectionForm['language']->renderLabel() ?><div style="clear:both"></div>
                        <?php echo $selectionForm['language']->render() ?><div style="clear:both"></div>
                        <div id="app_pages" class="chkListOut"></div><div style="clear:both"></div>
                    </form>
                </div>
            </div><!--CENTER_LEFT-->
        </div><!--SOMBRA_LEFT-->
    </div><!--LEFT-->
</div>
<script>
$(document).ready(function(){
    mdPluginTranslator.getInstance()._initialize();
});

</script>