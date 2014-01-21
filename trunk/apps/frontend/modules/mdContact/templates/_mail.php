<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>::Bunny's Kinder::</title>
</head>
<body style="background:#FFFFFF; margin:0 auto;">
<table cellpadding="0" cellspacing="0" style="border:none; width:600px; margin:0 auto;">
	<tr>
    	<td><img src="<?php echo image_path('mail/header.jpg', true) ?>" /></td>
    </tr>
    <tr>
    	<td style="font-family:Lucida Grande; color:#333333; font-size:14px; margin:5px 0 15px 0; font-weight:bold;">Formulario de Contacto</td>
    </tr>
    <?php foreach ($form as $field): ?>
        <?php if( $form->getCSRFFieldName()  == $field->getName()) continue; ?>
    <tr>
    	<td style="font-size:12px; padding:15px 0 8px 0; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; font-weight:bold; text-align:left"><?php echo $field->renderLabelName() ?>:
			<span style="font-size:12px; padding:5px 0 5px 10px; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; text-align:left; font-weight:normal;"><?php echo $form->getValue($field->getName()); ?></span></td>
    </tr>
    <?php endforeach; ?>
		<tr>
    	<td><img src="<?php echo image_path('mail/footer.jpg', true) ?>" /></td>
    </tr>
</table>
</body>
</html>
