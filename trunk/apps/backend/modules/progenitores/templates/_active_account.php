<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo __('Mail_::Newsletter Bunnys Kinder::'); ?></title>
    </head>
    <body style="background:#FFFFFF; margin:0 auto;">
        <table cellpadding="0" cellspacing="0" style="border:none; width:600px; margin:0 auto;">
            <tr>
                <td>
                    <?php echo image_tag('/images/mail/header.jpg', array('absolute' => true, 'size' => '600x85')); ?>
                </td>
            </tr>
            <tr>
                <td style="font-family:Lucida Grande; color:#333333; font-size:14px; margin:10px;">
                    <p style="font-family:Lucida Grande; color:#333333; font-size:14px; margin:5px 0 15px 0; font-weight:bold;"><?php echo __('Mail_Activación de cuenta'); ?></p>
                    <p style="font-family:Lucida Grande; color:#333333; font-size:14px; margin:10px 0;">
                        <?php echo __('Mail_Estimados,'); ?><br /><?php echo __('Mail_Les informamos se le ha generdo una cuenta pora poder ingresar al a galería de imágenes del sitio web.'); ?>
                    </p>
                    <p style="font-family:Lucida Grande; color:#333333; font-size:14px; margin:10px 0;">
                        <?php echo str_replace(
                                  '%link%', 
                                  '<a href="' . $link . '" style="font-family:Lucida Grande; color:#0157af; text-decoration:underline; font-style:italic;">link</a>',
                                  __('Mail_Para activar la misma y configurar su nueva clave debe ingresar al siguiente %link%')); ?>
                    </p>
                    <p style="font-family:Lucida Grande; color:#333333; font-size:14px; margin:40px 0 10px 0;">
                        <?php echo __('Mail_Saluda Atentamente,'); ?><br /><?php echo __('Mail_Bunnys Kinder.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo image_tag('/images/mail/footer.jpg', array('absolute' => true, 'size' => '600x143')); ?>
                </td>
            </tr>
        </table>
    </body>
</html>