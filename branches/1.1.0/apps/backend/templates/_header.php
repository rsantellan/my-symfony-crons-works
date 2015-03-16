<!-- Header -->
<header id="top">
  <div class="wrapper">
    
    <!-- Title/Logo - can use text instead of image -->
    <div id="title"><span><?php echo __('Home_Jardin'); ?>&nbsp; <?php echo date('Y'); ?></span></div>
    
    <!-- Top navigation -->
    <div id="topnav">
      <!-- <a href="#"><img class="avatar" SRC="/images/user_32.png" alt="" /></a>-->
      Hola <b><?php echo sfContext::getInstance()->getUser()->getUsername(); ?></b>
      <!-- <span>|</span> <a href="#">Settings</a>-->
      <span>|</span> <a href="<?php echo url_for('@logout'); ?>">Salir</a><br />
      <!-- <small>You have <a href="#" class="high"><b>1</b> new message!</a></small>-->
    </div>
    <!-- End of Top navigation -->
    
    <!-- Main navigation -->
    <nav id="menu">
      <ul class="sf-menu">
        <li class="<?php echo (has_slot('alertas') ? 'current' : ''); ?>"><a href="<?php echo url_for('@alertas'); ?>">Alertas</a></li>        
        <li class="<?php echo (has_slot('textos') ? 'current' : ''); ?>"><a href="<?php echo url_for('@mdTranslator'); ?>">Textos</a></li>
        <li class="<?php echo (has_slot('usuarios') ? 'current' : ''); ?>">
            <a href="<?php echo url_for('@usuario'); ?>">Alumnos</a>
            <ul>
              <li>
                <a href="<?php echo url_for('@usuario'); ?>">Corrientes</a>
              </li>
              <li>
                <a href="<?php echo url_for('@exportarDatosAlumnos'); ?>">Exportar Corrientes</a>
              </li>
              <li>
                <a href="<?php echo url_for('@usuario_futuros'); ?>">Futuros</a>
              </li>             
              <li>
                <a href="<?php echo url_for('@egresado'); ?>">Egresados</a>
              </li>             
            </ul>        
        </li>
        <li class="<?php echo (has_slot('progenitores') ? 'current' : ''); ?>"><a href="<?php echo url_for('@progenitor'); ?>">Padres</a></li>
        <li class="<?php echo (has_slot('actividades') ? 'current' : ''); ?>"><a href="<?php echo url_for('@actividades'); ?>">Actividades</a></li>
        <li class="<?php echo (has_slot('newsletter') ? 'current' : ''); ?>"><a href="<?php echo url_for('@manage_newsletter') ?>">Newsletter</a></li>        
        <li class="<?php echo (has_slot('pagos') ? 'current' : ''); ?>">
          <a href="javascrip:void(0)">Cuentas</a>
          <ul>
            <li><a href="<?php echo url_for('@cuentas'); ?>">Cuentas</a></li>
            <li><a href="<?php echo url_for('@pagos'); ?>">Pagos(Obsoleto)</a></li>
          </ul>
          
        </li>
       	<li><a href="<?php echo url_for('@md_galeria')?>" class="<?php if(has_slot('md_galeria')){ echo 'current'; } else { echo ''; } ?>">Galeria de imágenes</a></li>
        <li class="<?php echo (has_slot('settings') ? 'current' : ''); ?>">
          <a href="<?php echo url_for('@costos'); ?>">Configuraciones</a>
          <ul>
              <li>
                <a href="<?php echo url_for('@costos'); ?>">Costos</a>
              </li>
              <li>
                <a href="<?php echo url_for('@descuentos'); ?>">Descuentos</a>
              </li>
              <li>
                <a href="<?php echo url_for('@emails'); ?>">Newsletter</a>
              </li>              
          </ul>
        </li>
      </ul>
    </nav>
    <!-- End of Main navigation -->
    
    <!-- Aside links -->
    <!-- <aside><b>English</b> &middot; <a href="#">Spanish</a> &middot; <a href="#">German</a></aside>-->
    <!-- End of Aside links -->
  </div>
</header>
<!-- End of Header -->


<!-- Page title -->
<div id="pagetitle">
  <div class="wrapper">
    <h1>
        <?php if(has_slot('nav')): ?>
          <?php include_slot('nav'); ?>
        <?php endif; ?>
    </h1>    
    <!-- Quick search box -->
    <!-- <form action="" method="get"><input class="" type="text" id="q" name="q" /></form> -->
  </div>
</div>
<!-- End of Page title -->
