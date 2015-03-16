<?php use_helper('mdText', 'Date'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>::Newsletter Bunny's Kinder::</title>
  </head>
  <style type="text/css">
    p{
      font-family:Lucida Grande; 
      color:#333333; 
      font-size:13px; 
      margin:10px 0;      
    }
  </style>
  <body style="background:#FFFFFF; margin:0 auto;">
    <table cellpadding="0" cellspacing="0" style="border:none; width:600px; margin:0 auto;">
      <tr>
        <td><?php echo image_tag('/images/newsletter/header.jpg', array('absolute' => true)); ?></td>
        <td><img src="http://elblogverde.com/wp-content/uploads/2013/01/Paisajes-naturales.jpg" /></td>
      </tr>
      <tr>
        <td style="font-family:Lucida Grande; color:#333333; font-size:13px; float:right; margin-right:10px"><?php echo format_date(time(), 'D', 'es'); ?></td>
      </tr>
      <tr>
        <td style="font-family:Lucida Grande; color:#333333; font-size:13px; margin:10px;">
          <p style="font-family:Lucida Grande; color:#333333; font-size:13px; margin:5px 0 15px 0; font-weight:bold;"><?php echo ucfirst($subject); ?></p>
          
          <?php echo html_entity_decode(nl2br($body)); ?>
          
        </td>
      </tr>
      <tr>
        <td><?php echo image_tag('/images/newsletter/footer.jpg', array('absolute' => true)); ?></td>
      </tr>
    </table>
  </body>
</html>
