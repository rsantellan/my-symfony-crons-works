<?php use_helper('Text') ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo stylesheet_path('main', $absolute = true);?>" media="screen"/>
</head>

<body class="mail">
	<div id="wrapper_mail">
    	<div id="cabezal">
        </div>
        <div id="centro">
        	<h1><?php echo __('Contacto_titulo');?></h1>
            <ul>
							<?php foreach ($form as $field): ?>
            		<li><strong><?php echo $field->renderLabelName() ?>:</strong> <?php echo $form->getValue($field->getName()); ?></li>
							<?php endforeach;?>
            </ul>
        </div>
	</div><!--FIN WRAPEPR-->
</body>
</html>
