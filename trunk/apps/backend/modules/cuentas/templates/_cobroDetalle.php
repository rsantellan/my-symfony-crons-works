<div class="cobroslistcontainer">
  <span>Monto: <?php echo $cobro->getFormatedMonto();?></span>
  <span>Fecha: <?php echo format_date($cobro->getFecha(), 'D'); ?></span>
</div>