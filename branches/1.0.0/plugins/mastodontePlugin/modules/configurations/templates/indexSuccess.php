<?php use_helper('mdAsset') ?>
<?php use_plugin_javascript('mastodontePlugin', 'mdConfiguration.js') ?>
<?php use_plugin_stylesheet('mastodontePlugin', '../js/jquery-ui-1.8.4/css/smoothness/jquery-ui-1.8.4.custom.css') ?>
<?php use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-ui-1.8.4.custom.min.js', 'last') ?>
<?php use_plugin_javascript('mastodontePlugin','jquery-ui-1.8.4/development-bundle/ui/i18n/jquery.ui.datepicker-'.sfContext::getInstance()->getUser()->getCulture().'.js','last'); ?>
<?php slot('configuration', ':)');?>
<div id="md_center_container">
    <div class="md_shadow">
        <div class="md_center">

            <div class="md_content_center">
                <h1 style="float: left"><?php echo __('layout_configuration') ?></h1>

                <div style="float:right">
                </div>
                <div class="clear"></div>


                <div class="clear"></div>
                <div id="md_objects_container" class="md_objects">
                    <!-- PARTIAL DE BOX CERRADO -->
                    <div>
                        <div class="accordion-header" >
                            <h1><?php echo __('mastodontePlugin_text_contactConfiguration'); ?></h1>
                            <br/><br/>
                        </div>
                        
                        <!--init accordion body empty -->
                        <div class="accordion-body">
                          <div id="md_mail_configuration_form_div">
                            <?php include_partial('md_mail_configuration_form', array('xmlMailForm'=> $xmlMailForm));?>
                            
                          </div>
                        </div>
                    </div>
                    <?php if( sfConfig::get( 'sf_plugins_mdAuthFile_xml_edit', false ) ): ?>
                    <div>
                        <div class="accordion-header" >
                            <h1><?php echo __('mastodontePlugin_text_securityConfiguration'); ?></h1>
                            <br/><br/>                        
                        </div>
                        
                        <!--init accordion body empty -->
                        <div class="accordion-body">
                          <div id="md_mail_configuration_form_div">
                            <?php foreach($mdAuthXMLHandler->retrieveUserFormList() as $form): ?>
                              <div id="md_auth_configuration_form_div_<?php echo $form->retrieveUserName();?>">
                                <?php include_partial('md_auth_configuration_form', array('form'=> $form));?>
                              </div>
                              <div class="clear"></div>
                            <?php endforeach; ?>
                          </div>
                        </div>
                    </div>
                  <?php endif; ?>

                  <?php if( sfConfig::get( 'sf_plugins_mdBackendGroupsFile_xml_edit', false ) ): ?>
                    <div>
                        <div class="accordion-header" >
                            <h1><?php echo __('mastodontePlugin_text_backendSecurityConfiguration'); ?></h1>
                            <br/><br/>
                        </div>

                        <!--init accordion body empty -->
                        <div class="accordion-body">
                          <div id="md_mail_configuration_form_div">
                            <?php foreach($mdBackendGroupsXMLHandler->retrieveBackendGroupList() as $mdXmlGroup): ?>
                              <?php include_partial('showXMLGroup', array('mdXmlGroup'=>$mdXmlGroup)); ?>
                              <div class="clear"></div>
                            <?php endforeach; ?>
                          </div>
                        </div>
                    </div>
                  <?php endif; ?>

                  <?php if( sfConfig::get( 'sf_plugins_mdBackendSalesFile_xml_edit', false ) ): ?>
                    <div>
                        <div class="accordion-header" >
                            <h1><?php echo __('mastodontePlugin_text_backendSalesConfiguration'); ?></h1>
                            <br/><br/>
                        </div>

                        <!--init accordion body empty -->
                        <div class="accordion-body">
                          <div id="md_sale_configuration_form_div">
                            <?php include_partial('md_sale_configuration_form', array('form'=> $xmlSaleForm));?>
                            <?php //echo $xmlSaleForm?>
                          </div>
                        </div>
                    </div>
                  <?php endif; ?>
                  <?php if( sfConfig::get( 'sf_plugins_md_exporta_facil_configuration', false ) ): ?>
                    <div>
                        <div class="accordion-header" >
                            <h1><?php echo __('exportaFacil_importar archivo'); ?></h1>
                            <br/><br/>
                        </div>

                        <!--init accordion body empty -->
                        <div class="accordion-body">
                          <?php include_component("mdImportFileExportaFacil", "retrieveImportConfigurationComponent"); ?>
                        </div>
                    </div>
                  <?php endif; ?>
                  <?php if( sfConfig::get( 'sf_plugins_md_correo_uruguayo_configuration', false ) ): ?>
                    <div>
                        <div class="accordion-header" >
                            <h1><?php echo __('correoUruguayo_importar archivo'); ?></h1>
                            <br/><br/>
                        </div>

                        <!--init accordion body empty -->
                        <div class="accordion-body">
                          <?php include_component("mdImportFileCorreoUruguayo", "retrieveImportConfigurationComponent"); ?>
                        </div>
                    </div>
                  <?php endif; ?>                                      
                </div>
            </div>
        </div>
    </div>
</div>

<div id="backend_right_floating"class="md_right_container">

</div>
        <script type="text/javascript">
	$(function() {
		$( "#md_objects_container" ).accordion(
                {
                    collapsible: true,
                    active: false,
                    icons: false,
                    header: 'div > div.accordion-header',
                    autoHeight: false
                });
	});
	</script>

<?php if( sfConfig::get( 'sf_plugins_mdBackendSalesFile_xml_edit', false ) ): 
    $xmlSaleHandler = $xmlSaleHandler->getRawValue();
?>
        <script type="text/javascript">
             $(document).ready(function() {
                mdConfiguration.getInstance().checkUsedCheckBoxesOfMdSales(<?php echo $xmlSaleHandler->getReplyOn() ?>, <?php echo $xmlSaleHandler->getInformBuyer() ?>);
             });
        </script>

<?php endif; ?>
