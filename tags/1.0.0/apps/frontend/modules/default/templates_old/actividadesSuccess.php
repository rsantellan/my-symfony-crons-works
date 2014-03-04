<?php use_javascript('frontend/ga.js') ?>
<?php use_stylesheet('frontend/tabs-accordion.css') ?>
<div class="contenido_left">
	<h1><?php echo __('Actividades_Titulo') ?></h1>
      <img src="/images/frontend/titl_actividades.jpg" class="titl" />
      <p><?php echo __('Actividades_Tips') ?></p>
      <div id="accordion">
<?php foreach($actividades as $actividad): ?>
        <h2 <?php if(!isset($first)) echo 'class="current"'; ?>><img src="/images/frontend/bullets.jpg" /><?php echo __('Actividades_' . $actividad . ' Titulo') ?></h2>
        <div class="pane" <?php if(!isset($first)) echo 'style="display:block"'; ?>>
          <p style="clear:both">
					<?php echo __('Actividades_' . $actividad . ' Texto') ?>
          </p>
          <img src="/images/frontend/<?php echo strtolower($actividad) ?>1.jpg" style="margin-right:10px;"/>
          <img src="/images/frontend/<?php echo strtolower($actividad) ?>2.jpg" />
        </div>
        <div class="clear"></div>
<?php $first=false;endforeach; ?>      
        
        </div><!--ACCORDION-->
  </div><!--CONTENIDO LEFT-->
  <div class="contenido_right">
  	<img src="/images/frontend/actividades.jpg" />
  </div><!--CONTENIDO RIGHT-->


	<script>
	  $(function() {
	    $("#accordion").tabs(
	    "#accordion div.pane",
	    {tabs: 'h2', effect: 'slide', initialIndex: null}
	  );
	    });
	</script>
