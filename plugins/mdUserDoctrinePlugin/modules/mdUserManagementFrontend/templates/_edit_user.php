<br/>
<br/>
<h3><?php echo __("user_editUserTitle");?></h3>

<?php
/* 
 * FORMULARIO PARA CAMBIAR EL EMAIL DEL USUARIO (MDUSER)
 * 
 */
?>
<?php include_component("mdUserManagementFrontend","changeEmail");?>
<?php
/*
 * FORMULARIO PARA CAMBIAR EL PASSWORD DEL USUARIO (MDPASSPORT)
 *
 */
?>
<div class="clear"></div>
<br/>
<?php include_component("mdUserManagementFrontend","changePassword");?>
<?php
/*
 * FORMULARIO PARA CAMBIAR DATOS BASICOS DEL USUARIO (MDUSERPROFILE)
 *
 */
?>

<div class="clear"></div>
<br/>
<?php include_component("mdUserManagementFrontend","changeUserProfile");?>
<?php
/*
 * VOLVER AL FORMULARIO DE INFORMACION
 *
 */
?>

<a href="javascript:void(0)" onclick="return mdUserManagementFrontend.getInstance().finishEditProfile('<?php echo url_for("mdUserManagementFrontend/getSmallInfoAjax"); ?>');"><?php echo __('mdUserDoctrine_text_changeMyDataFinish') ?></a>