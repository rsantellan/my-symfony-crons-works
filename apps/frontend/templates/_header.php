<div class="header header_home">
<div id="content_flash"></div>
	  <script type="text/javascript">
              var flashvars = {url: "www.google.com"};
              var params = {menu: "false", wmode: "transparent" };
              var attributes = {};
              swfobject.embedSWF("/media/header.swf", "content_flash", "900", "145", "9.0.0","", flashvars, params, attributes);
            </script>
      <div class="menu">
      	<ul>
          	<li><a href="<?php echo url_for('@homepage'); ?>" class="home <?php (has_slot('homepage')?'current':'') ?>"><?php echo __('Menu_inicio') ?></a></li>
              <li><a href="<?php echo url_for('@filosofia'); ?>" class="filosofia <?php (has_slot('filosofia')?'current':'') ?>"><?php echo __('Menu_filosofia') ?></a></li>
              <li><a href="<?php echo url_for('@historia'); ?>" class="historia <?php (has_slot('historia')?'current':'') ?>"><?php echo __('Menu_historia') ?></a></li>
              <li><a href="<?php echo url_for('@actividades'); ?>" class="actividades <?php (has_slot('actividades')?'current':'') ?>"><?php echo __('Menu_actividades') ?></a></li>
              <li><a href="<?php echo url_for('@galeria'); ?>" class="galeria <?php (has_slot('galeria')?'current':'') ?>"><?php echo __('Menu_galeria') ?></a></li>
              <li><a href="<?php echo url_for('@inscripciones'); ?>" class="inscripciones <?php (has_slot('inscripciones')?'current':'') ?>"><?php echo __('Menu_inscripciones') ?></a></li>
          </ul>
      </div>  
  </div><!--HEADER-->