<?php slot('homepage', true) ?>
  	<h1><?php echo __('Inicio_Bienvenidos') ?></h1>
      <div class="banner_home">
				<div id="content_banner"></div>
	  <script type="text/javascript">
              var flashvars = {url: "www.google.com"};
              var params = {menu: "false", wmode: "transparent" };
              var attributes = {};
              swfobject.embedSWF("/media/banner.swf", "content_banner", "860", "250", "9.0.0","", flashvars, params, attributes);
            </script>
      </div>
      <div class="tex_home">
      	<p><?php echo __('Inicio_Texto') ?></p>
      </div>
