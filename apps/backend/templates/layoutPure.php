<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    
    <!-- We need to emulate IE7 only when we are to use excanvas -->
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <![endif]-->    
    
    <link rel="shortcut icon" href="/favicon.ico" />
    
    
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    

    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/grids-responsive-old-ie-min.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/grids-responsive-min.css">
    <!--<![endif]-->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

<style>
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

/*
 * -- BASE STYLES --
 * Most of these are inherited from Base, but I want to change a few.
 */
body {
    line-height: 1.7em;
    color: #7f8c8d;
    font-size: 13px;
}

h1,
h2,
h3,
h4,
h5,
h6,
label {
    color: #34495e;
}

.pure-img-responsive {
    max-width: 100%;
    height: auto;
}

/*
 * -- LAYOUT STYLES --
 * These are some useful classes which I will need
 */
.l-box {
    padding: 1em;
}

.l-box-lrg {
    padding: 2em;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.is-center {
    text-align: center;
}



/*
 * -- PURE FORM STYLES --
 * Style the form inputs and labels
 */
/*
.pure-form label {
    margin: 1em 0 0;
    font-weight: bold;
    font-size: 100%;
}

.pure-form input[type] {
    border: 2px solid #ddd;
    box-shadow: none;
    font-size: 100%;
    width: 100%;
    margin-bottom: 1em;
}
*/
/*
 * -- PURE BUTTON STYLES --
 * I want my pure-button elements to look a little different
 */
.pure-button {
    background-color: #1f8dd6;
    color: white;
    padding: 0.5em 2em;
    border-radius: 5px;
}

a.pure-button-primary {
    background: white;
    color: #1f8dd6;
    border-radius: 5px;
    font-size: 120%;
}


/*
 * -- MENU STYLES --
 * I want to customize how my .pure-menu looks at the top of the page
 */

.home-menu {
    padding: 0.5em;
    text-align: center;
    box-shadow: 0 1px 1px rgba(0,0,0, 0.10);
}
.home-menu.pure-menu-open {
    background: #fcedd2;;
}
.pure-menu.pure-menu-open.pure-menu-fixed {
    /* Fixed menus normally have a border at the bottom. */
    border-bottom: none;
    /* I need a higher z-index here because of the scroll-over effect. */
    z-index: 4;
}

.home-menu .pure-menu-heading {
    color: black;
    font-weight: 400;
    font-size: 120%;
}

.home-menu .pure-menu-selected a {
    color: white;
}

.home-menu a {
    color: #6FBEF3;
}
.home-menu li a:hover,
.home-menu li a:focus {
    background: none;
    border: none;
    color: #AECFE5;
}



/*
 * -- TABLET (AND UP) MEDIA QUERIES --
 * On tablets and other medium-sized devices, we want to customize some
 * of the mobile styles.
 */
@media (min-width: 48em) {

    /* We increase the body font size */
    body {
        font-size: 16px;
    }
    /* We want to give the content area some more padding */
    .content {
        padding: 1em;
    }

    /* We can align the menu header to the left, but float the
    menu items to the right. */
    .home-menu {
        text-align: left;
    }
        .home-menu ul {
            float: right;
        }

    /* We remove the border-separator assigned to .l-box-lrg */
    .l-box-lrg {
        border: none;
    }

}

/*
 * -- DESKTOP (AND UP) MEDIA QUERIES --
 * On desktops and other large devices, we want to over-ride some
 * of the mobile and tablet styles.
 */
@media (min-width: 78em) {
    /* We increase the header font size even more */
    .splash-head {
        font-size: 300%;
    }
}
ul.radio_list {
    list-style-type: none;
}
ul.checkbox_list {
    list-style-type: none;
}
</style>
  </head>
  <body>
    <div class="header">
        <div class="home-menu pure-menu pure-menu-open pure-menu-horizontal">
            <a class="pure-menu-heading" href="">Bunnys Kinder Administrador</a>

            <ul class="sf-menu">
            <li class="<?php echo (has_slot('alertas') ? 'current' : ''); ?>"><a href="<?php echo url_for('@alertas'); ?>">Alertas</a></li>        
            <li class="<?php echo (has_slot('textos') ? 'current' : ''); ?>"><a href="<?php echo url_for('@mdTranslator'); ?>">Textos</a></li>
            <li class="<?php echo (has_slot('progenitores') ? 'current' : ''); ?>"><a href="<?php echo url_for('@usuario'); ?>">Alumnos Corrientes</a></li>
            <li class="<?php echo (has_slot('progenitores') ? 'current' : ''); ?>"><a href="<?php echo url_for('@egresado'); ?>">Alumnos Egresados</a></li>
            <li class="<?php echo (has_slot('progenitores') ? 'current' : ''); ?>"><a href="<?php echo url_for('@progenitor'); ?>">Padres</a></li>
            <li class="<?php echo (has_slot('actividades') ? 'current' : ''); ?>"><a href="<?php echo url_for('@actividades'); ?>">Actividades</a></li>
            <li class="<?php echo (has_slot('newsletter') ? 'current' : ''); ?>"><a href="<?php echo url_for('@manage_newsletter') ?>">Newsletter</a></li>        
            <li class="<?php echo (has_slot('pagos') ? 'current' : ''); ?>">
              <a href="<?php echo url_for('@cuentas'); ?>">Cuentas</a>
            </li>
            <li><a href="<?php echo url_for('@md_galeria')?>" class="<?php if(has_slot('md_galeria')){ echo 'current'; } else { echo ''; } ?>">Galeria de imágenes</a></li>
            <li class="<?php echo (has_slot('settings') ? 'current' : ''); ?>">
              <a href="<?php echo url_for('@logout'); ?>">Salir</a>
            </li>
          </ul>
        </div>
    </div>
    
    <div class="content-wrapper">
        <?php echo $sf_content ?>
    </div>
    
  </body>
</html>
