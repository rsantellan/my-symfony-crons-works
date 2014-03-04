<?php slot('pagos'); ?>
<?php slot('nav') ?>Cuentas<?php end_slot(); ?>
<?php use_stylesheet('rodrigosantellan.css', 'last');?>
<h2>Cuentas con saldo negativo</h2>
<?php  include_partial('cuentas/listTable', array('cuentas' => $cuentasPositive, 'trclass' => 'cuentas-row-orange'));?>
<div class="clear"></div>
<h2>Cuentas con saldo a favor</h2>
<div id="table_account_negative">
  <?php  include_partial('cuentas/listTable', array('cuentas' => $cuentasNegative, 'trclass' => 'cuentas-row-green'));?>
</div>
<h2>Cuentas con saldo cero</h2><a href="javascript:void(0)" onclick="$('#table_account_zero').toggle()">Ver</a>
<div id="table_account_zero" class="hidden">
  <?php  include_partial('cuentas/listTable', array('cuentas' => $cuentasZero, 'trclass' => 'cuentas-row-yellow'));?>
</div>
<div class="clear"></div>
