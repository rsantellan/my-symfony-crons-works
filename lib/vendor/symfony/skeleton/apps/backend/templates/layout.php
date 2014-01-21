<?php use_helper('mdAsset') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php
        use_plugin_stylesheet('mastodontePlugin', 'backend.css');
        use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-1.4.2.min.js', 'first');
        use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-ui-1.8.4.custom.min.js', 'first');
        use_plugin_javascript('mastodontePlugin', 'mdConfig.js');
        use_plugin_javascript('mastodontePlugin', 'mdLoadController.js');
        use_plugin_stylesheet('mastodontePlugin', '../js/fancybox/jquery.fancybox-1.3.1.css');
        use_plugin_javascript('mastodontePlugin','fancybox/jquery.fancybox-1.3.1.pack.js','last');
    ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
     <div id="message_text" class="message_text">
          <span id="text_to_publish"><?php echo __('Layout_Tiene textos sin publicar') ?></span>
          <span id="text_publishing" style="display:none;"><?php echo __('Layout_Publicando...') ?></span>
          <span id="text_publishing_complete" style="display:none;"><?php echo __('Layout_Los textos se han publicado') ?></span>
          <input type="button" onclick="return mdTranslator.getInstance().publish();" value="<?php echo __('Layout_publicar') ?>" />
      </div>
   	<div id="md_wrapper">
    	<div id="md_header">
        	<div class="md_logo">
            	<?php echo image_tag ( 'logo.jpg' )?>
            </div>
        <?php if($sf_user->isAuthenticated ()):?>
            <div class="md_login">
            	<a href="#"  class="md_current"><?php echo $sf_user->getUsername()?><?php if($sf_user->isSuperAdmin()) echo '(Super Admin)'?></a> | <?php echo $sf_user->getCulture()?> | <a href="<?php echo url_for('mdAuth/logout')?>">salir</a>
            </div>
        <?php endif; ?>
        </div><!--HEADER-->
        <div id="md_menu">
        <?php if($sf_user->isAuthenticated ()):?>
        	<ul class="menu_list">
            	<li><a href="#">Escritorio</a></li>
<?php if(sfContext::getInstance()->getRouting()->hasRouteName('mdUserManagement')):?>
                <li><a href="<?php echo url_for('@mdUserManagement')?>" class="<?php if(has_slot('mdUserManagement')){ echo 'current'; } else { echo ''; } ?>"><?php echo __('backendLayout_Usuarios') ?></a></li>
<?php endif;
if(sfContext::getInstance()->getRouting()->hasRouteName('mdTranslator')):?>
                <li><a href="<?php echo url_for('@mdTranslator')?>" class="<?php if(has_slot('mdTranslator')){ echo 'current'; } ?>"><?php echo __('backendLayout_Textos') ?></a></li>
<?php endif; ?>
        <?php
        if(sfContext::getInstance()->getRouting()->hasRouteName('mdCategoryAdmin')):?>
                	<li><a href="<?php echo url_for('@mdCategoryAdmin')?>" class="<?php if(has_slot('mdCategoryAdmin')){ echo 'current'; } else { echo ''; } ?>">Categorias</a></li>
				<?php endif; ?>
        
        <?php if(sfContext::getInstance()->getRouting()->hasRouteName('mdDynamicContent')):?>
        <?php
            include_partial('mdDynamicContent/menuDynamic');

        ?>
        <?php endif; ?>
        <?php if(sfContext::getInstance()->getRouting()->hasRouteName('mdProducts')):?>
        <?php
            include_partial('mdProduct/menuMdProduct');
         ?>
         <?php endif; ?>
        <?php
        if(sfContext::getInstance()->getRouting()->hasRouteName('mdNews')):?>
                <li><a href="<?php echo url_for('@mdNews')?>" class="<?php if(has_slot('mdNews')){ echo 'current'; } else { echo ''; } ?>">Noticias</a></li>
        <?php endif;?>
        <?php
        if(sfContext::getInstance()->getRouting()->hasRouteName('md_poll_management')):?>
                <li><a href="<?php echo url_for('@md_poll_management')?>" class="<?php if(has_slot('mdPoll')){ echo 'current'; } else { echo ''; } ?>"><?php echo __('backendLayout_Poll') ?></a></li>
        <?php endif;
        ?>
        <?php
        if(sfContext::getInstance()->getRouting()->hasRouteName('mdImageFileGalleryAdmin')):?>
                        <li><a href="<?php echo url_for('@mdImageFileGalleryAdmin')?>" class="<?php if(has_slot('mdImageFileGalleryAdmin')){ echo 'current'; } ?>">Galeria de imagenes</a></li>
        <?php endif;
        ?>
        <?php
        if(sfContext::getInstance()->getRouting()->hasRouteName('configuration')):?>
                <li><a href="<?php echo url_for('@configuration')?>" class="<?php if(has_slot('configuration')){ echo 'current'; } else { echo ''; } ?>">Configuraciones</a></li>
        <?php endif;?>
        <?php
        if(sfContext::getInstance()->getRouting()->hasRouteName('backend_mdSale')):?>
                <li><a href="<?php echo url_for('@backend_mdSale')?>" class="<?php if(has_slot('backend_mdSale')){ echo 'current'; } else { echo ''; } ?>">Ventas</a></li>
        <?php endif;?>
        <?php
            if(sfContext::getInstance()->getRouting()->hasRouteName('manage_newsletter')):?>
                <li><a href="<?php echo url_for('@manage_newsletter')?>" class="<?php if(has_slot('manage_newsletter')){ echo 'current'; } else { echo ''; } ?>">News Letter</a></li>
            <?php endif;?>
        <?php
        if(sfContext::getInstance()->getRouting()->hasRouteName('mdAdsManagement')):?>
                <li><a href="<?php echo url_for('@mdAdsManagement')?>" class="<?php if(has_slot('backend_mdAdsManagement')){ echo 'current'; } else { echo ''; } ?>">Ads</a></li>
        <?php endif;?>            
            </ul>
        <?php endif;?>
        </div><!--MENU-->
        <?php
        if($sf_user->hasFlash('noPermission')):
        ?>
        <div id="md_no_permissions"> <h2> No tiene suficientes permisos</h2> </div>
        <?php endif; ?>
        <div class="clear"></div>
        <div id="md_content">
            <?php echo $sf_content ?>
        </div>

<?php if($sf_user->isAuthenticated ()):?>
    </div><!--WRAPPER-->
<?php endif;?>

    <?php include_partial("default/mdLoading"); ?>
    <?php if($sf_user->isAuthenticated ()):?>
        <?php include_partial("default/barra"); ?>
    <?php endif;?>

  </body>
</html>

