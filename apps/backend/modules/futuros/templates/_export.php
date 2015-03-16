<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php echo __('PDF_Titulo'); ?></title>
  <link rel="stylesheet" type="text/css" href="css/export.css" media="screen"/>
  </head>
  <body>
    <?php $i = 0; ?>
    <?php foreach($usuarios as $usuario): ?>

      <?php if($i % 4 == 0): ?>
        <?php echo '<br /><br />'; ?>
      <?php endif; ?>
    
      <?php include_partial('usuarios/info_pdf', array('usuario' => $usuario)); ?>

      <?php $i++; ?>    
    
    <?php endforeach; ?>
  </body>
</html>
