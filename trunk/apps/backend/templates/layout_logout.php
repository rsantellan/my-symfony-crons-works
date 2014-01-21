<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />    
    <?php include_partial('global/includeCss'); ?>

    <?php use_helper('mdAsset'); ?>
    <?php use_plugin_javascript('mastodontePlugin', 'mdConfig.js'); ?>
    <?php use_plugin_javascript('mastodontePlugin', 'jquery/jquery-1.6.1.min.js'); ?>
    <?php use_plugin_javascript('mastodontePlugin', 'mdLoadController.js'); ?>

    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <!-- Header -->
    <header id="top">
      <div class="wrapper-login">
        <div id="title"><span><?php echo __('Home_Jardin'); ?></span></div>        
      </div>
    </header>
    <!-- End of Header -->
    
    <!-- Page title -->
    <div id="pagetitle">
      <div class="wrapper-login"></div>
    </div>
    <!-- End of Page title -->
	
    <!-- Page content -->
    <div id="page">
      <!-- Wrapper -->
      <div class="wrapper-login">
        
        <?php echo $sf_content ?>

      </div>
      <!-- End of Wrapper -->
    </div>
    <!-- End of Page content -->
	
    <!-- Page footer -->
    <!-- <footer id="bottom">
      <div class="wrapper-login">
        <p>Copyright &copy; 2011 <b><a href="#" title="">Mastodonte</a></b></p>
      </div>
    </footer>-->
    <!-- End of Page footer -->
    
  </body>
</html>
