<?php use_helper('mdAsset') ?>

<?php // esto ya se incluyo en el componente de los padres ?>
<?php //use_plugin_stylesheet('mastodontePlugin', 'autoSuggest.css', 'last'); ?>
<?php //use_plugin_javascript('mastodontePlugin', 'jquery/plugins/autosuggest/jquery.autoSuggest.js', 'last'); ?>
<!-- <style type="text/css">
  .cursor-pointer{
    cursor: pointer;
  }
</style> -->

<div class="hermanos">
  <h3><?php echo __('Usuarios_Hermanos', array(), 'messages') ?></h3>
  
  <?php if($usuario->hasHermanos()): ?>
  
    <ul id="jardin-hermanos-list">
      <?php foreach($hermanos as $hermano): ?>
        
        <li>
          <a href="<?php echo url_for('@usuario_edit?id=' . $hermano->getUserTo()->getId()); ?>">
            <?php echo $hermano->getUserTo()->getNombre() . ' ' . $hermano->getUserTo()->getApellido(); ?>
            <?php 
              if($hermano->getUserTo()->getEgresado() == 1):
            ?>
            <strong>Egresado</strong>
            <?php
              endif;
            ?>
          </a>
        </li>
        
      <?php endforeach; ?>
    </ul>
  
  <?php else: ?>
  
    <ul id="jardin-hermanos-list" style="display: none;"></ul>
    <p id="jardin-no-hermanos" style="margin-bottom: 1em;"><?php echo str_replace('{usuario}', $usuario->getNombre() . ' ' . $usuario->getApellido(), __('Usuarios_No tiene hermanos')) ; ?></p>
  
  <?php endif; ?>
