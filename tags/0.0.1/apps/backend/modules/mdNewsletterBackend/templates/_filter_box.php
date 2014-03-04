<h3><?php echo __("newsletter_agregar usuario");?></h3>
<div id="new_newsletter_container">
  <?php include_component("mdNewsletterBackend", "addUser");?>
</div>
<h3><?php echo __("newsletter_eliminar usuario");?></h3>
<div id="remove_newsletter_container">
  <?php include_component("mdNewsletterBackend", "removeUser");?>
</div>
<hr/>
<a href="<?php echo url_for('@export_newsletter')?>"><?php echo __('newsletter_exportar'); ?></a>
<a id="import_link" href="<?php echo url_for('mdNewsletterBackend/importar')?>" class="iframe"><?php echo __('newsletter_importar'); ?></a>
