<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    
    <!-- We need to emulate IE7 only when we are to use excanvas -->
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <![endif]-->    
    
    <link rel="shortcut icon" href="/favicon.ico" />
    
    <?php include_partial('global/includeCss'); ?>
    <?php include_partial('global/includeJs'); ?>
    
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    
    <?php include_partial('global/header'); ?>    
    
    <!-- Page content -->
    <div id="page">
      <!-- Wrapper -->
      <div class="wrapper">
        
        <?php echo $sf_content ?>
        
      </div>
    <!-- End of Wrapper -->
    </div>
    <!-- End of Page content -->    
    
    <div style="clear:both"></div>
    
    <?php include_partial('global/footer'); ?>
    
    <?php include_partial('global/mdLoading'); ?>
    
  </body>
</html>
