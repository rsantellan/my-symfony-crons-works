<?php if($error == 1): ?>
  <?php echo __("newsletter_El archivo subido no esta soportado.");?> 
<?php endif; ?>
<?php if($sf_user->hasFlash("importNewsletter")) : ?>
  <?php echo __("newsletter_Se han importado correctamente los usuarios.");?> 
<?php endif;?>
<form action="<?php echo url_for("mdNewsletterBackend/importar");?>" method="POST" enctype="multipart/form-data">
  <?php echo $form;?>
  <input type="submit" value="subir"/>
</form>
