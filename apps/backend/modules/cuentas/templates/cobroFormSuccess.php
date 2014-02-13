<form action="<?php echo url_for('@salvarcuenta'); ?>" method="post" onsubmit="return sendNewCobro(this);">
<?php echo $form->renderHiddenFields(false) ?>
<?php echo $form->renderGlobalErrors() ?>
  
  <div>
    <?php echo $form['fecha']->renderLabel() ?>
    <?php echo $form['fecha']->renderError() ?>
    <?php echo $form['fecha'] ?>
  </div>
  <div class="clear"></div>
  <div>
    <?php echo $form['monto']->renderLabel() ?>
    <?php echo $form['monto']->renderError() ?>
    <?php echo $form['monto'] ?>
  </div>
<?php
//echo $form;
?>
  <input type="submit" value="Crear cobro" />
</form>  