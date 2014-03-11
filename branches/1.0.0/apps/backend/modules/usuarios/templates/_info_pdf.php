<?php $mes_current = date('n'); ?>
<?php $isSetiembreOrOctubre = $mes_current == 9 || $mes_current == 10; ?>
<?php $descuento = $usuario->calcularDescuento(); ?>
<?php $billetera = $usuario->getBilletera(); ?>
<?php $saldo = $usuario->getSaldo(); ?>
<?php $actividades = $usuario->getUsuarioActividades(); ?>

<div id="wrapper">
  
  <div class="cabezal">
    <img src="<?php echo sfConfig::get('sf_web_dir') . '/images/logo-pdf.jpg'; ?>" class="float_left" />
    <span class="mes" style="float:right;"><?php echo ucfirst(mdHelp::month($mes_current)) . ' ' . date('Y'); ?></span>
    <div class="clear"></div>
  </div>
  
  <div class="descripcion">
    
    <?php if($usuario->getHorario() == 'matutino' || $usuario->getHorario() == 'vespertino'): ?>
    <span class="cuota"><?php echo __('PDF_Cuota fija mensual:') . ' ' . costos::getSymbol() . ' ' . costos::getCosto($usuario->getHorario()); ?>
      <?php if($isSetiembreOrOctubre): ?>
        <?php echo ' - ' . __('PDF_Matricula:') . ' ' . costos::getSymbol() . ' ' . number_format(costos::getCosto('matricula')/2, 2, '.', ''); ?>
      <?php endif; ?>
    </span><br />
    <?php endif; ?>
    
    <?php if($usuario->getHorario() == 'doble_horario'): ?>
    <span class="cuota"><?php echo __('PDF_Cuota fija mensual:') . ' ' . costos::getSymbol() . ' ' . costos::getCosto('doble_horario'); ?>
      <?php if($isSetiembreOrOctubre): ?>
        <?php echo ' - ' . __('PDF_Matricula:') . ' ' . costos::getSymbol() . ' ' . number_format(costos::getCosto('matricula')/2, 2, '.', ''); ?>
      <?php endif; ?>
    </span><br />
    <?php endif; ?>
    
    <?php if($actividades->count() > 0): ?>
      <strong><?php echo __('PDF_Actividades adicionales:'); ?></strong>&nbsp;
      <?php $first = true; ?>
      <?php foreach($actividades as $usuarioActividad): ?>

        <?php if(!$first): ?>
          <?php echo ' - '; ?>
        <?php endif; ?>
        <?php $first = false; ?>

        <?php echo $usuarioActividad->getActividad()->getNombre() . ': ' . ' ' . costos::getSymbol() . ' ' . $usuarioActividad->getActividad()->retrieveCosto(); ?>

      <?php endforeach; ?><br />
    <?php endif; ?>
    
    <?php if($saldo != 0): ?>
    <strong><?php echo __('PDF_Saldo:'); ?></strong>&nbsp;<?php echo costos::getSymbol() . ' ' . $saldo; ?>    
    <?php endif; ?>    

  </div>
  
  <div class="total"><?php echo __('PDF_Total:') . ' ' . costos::getSymbol() . ' ' . $usuario->calcularTotal(); ?></div>    
  
  <div class="footer">
    <div class="alumno">
      <?php echo __('PDF_Nombre Alumno:') . ' ' . $usuario->getNombre() . ' ' . $usuario->getApellido(); ?><br />
      <?php echo __('PDF_Referencia bancaria:') . ' ' . $usuario->getReferenciaBancaria(); ?>
    </div>
  </div>
  
</div>
