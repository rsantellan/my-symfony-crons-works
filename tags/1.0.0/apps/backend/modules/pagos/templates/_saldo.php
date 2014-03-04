<?php $usuario = $pagos->getUsuario(); ?>
<?php $saldo = $usuario->getSaldo(); ?>

<?php echo costos::getSymbol() . ' ' . $saldo; ?>
