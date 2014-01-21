<div class="contenido_left">
	<h1><?php echo __('Galeria_Titulo') ?></h1>
      <img src="/images/frontend/titl_galeria.jpg" class="titl" />
      <p><?php echo __('Galeria_Habilitado para cursos') ?>:</p>
<?php foreach($grupos as $grupo): ?>
      <p class="group_name"><?php echo ucfirst($grupo); ?></p>
      <ul class="galeria_list">
  <?php foreach($galerias[$grupo] as $galeria): ?>
      	<li><a href="<?php echo url_for('galeria_detalle', $galeria) ?>"><div class="float_left"><?php echo $galeria->getTitulo() ?></div> <img src="/images/frontend/flecha.jpg" /></a></li>
  <?php endforeach; ?>
      </ul>
<?php endforeach; ?>
  </div><!--CONTENIDO LEFT-->
  <div class="contenido_right">
  	<img src="/images/frontend/galeria.jpg" />
  </div><!--CONTENIDO RIGHT-->
