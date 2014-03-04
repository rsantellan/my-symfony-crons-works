<?php use_helper('I18N', 'Date','mdAsset') ?>
<?php include_partial('galeria/assets') ?>

<?php use_plugin_javascript('mastodontePlugin', 'easySlider1.5.js', 'last'); ?>
<?php use_javascript('tiny_mce/tiny_mce.js', 'last'); ?>
<?php include_partial('mdMediaContentAdmin/javascriptInclude'); ?>

<div id="sf_admin_container">
  <h1><?php echo __('Edit Galeria', array(), 'messages') ?></h1>

  <?php include_partial('galeria/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('galeria/form_header', array('md_galeria' => $md_galeria, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('galeria/form', array('md_galeria' => $md_galeria, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('galeria/form_footer', array('md_galeria' => $md_galeria, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

	<hr />

	<div id="news_extra_info">

	  <div id="user_images" style="width:550px">

	    <?php include_component('mdMediaContentAdmin', 'showAlbums', array('object' => $md_galeria)) ?>

	  </div>

	</div>

	<div class="clear"></div>

	<hr />

</div>

<script type="text/javascript">
  $(document).ready(function() {
    initializeLightBox('<?php echo $md_galeria->getId(); ?>', '<?php echo $md_galeria->getObjectClass(); ?>', MdAvatarAdmin.getInstance().getDefaultAlbumId());
  });
</script>
