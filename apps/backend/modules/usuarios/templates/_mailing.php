<?php $mes_current = date('n'); ?>
<?php $isSetiembreOrOctubre = $mes_current == 9 || $mes_current == 10; ?>
<?php $descuento = $usuario->calcularDescuento(); ?>
<?php $billetera = $usuario->getBilletera(); ?>
<?php $saldo = $usuario->getSaldo(); ?>
<?php $actividades = $usuario->getUsuarioActividades(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Bunny's Kinder</title>
    </head>

    <body style="background:#FFFFFF; margin:15px 0 0 30px;">
        <table cellpadding="0" cellspacing="0" style="border:none; width:600px; margin:15px 0 0 30px;">
            <tr>
                <td style="margin:10px 0">
                    <?php echo image_tag('logo-pdf.jpg', array('absolute' => true, 'size' => '124x53')); ?>
                </td>
                <td style="font-size:14px; padding:15px 0 8px 0; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; font-weight:bold; text-align:right;"><?php echo ucfirst(mdHelp::month($mes_current)) . ' ' . date('Y'); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-size:14px; padding:10px 0 0 0; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; font-weight:bold; text-align:left;">
                    <?php if ($usuario->getHorario() == 'matutino' || $usuario->getHorario() == 'vespertino'): ?>
                        <?php echo __('PDF_Cuota fija mensual:'); ?>&nbsp;
                        <span style="font-size:14px; padding:0 0 0x 5px; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; text-align:left; font-weight:normal;">    
                            <?php echo costos::getSymbol() . ' ' . costos::getCosto($usuario->getHorario()); ?>
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php if ($isSetiembreOrOctubre): ?>
                <tr>
                    <td colspan="2" style="font-size:14px; padding:10px 0 0 0; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; font-weight:bold; text-align:left;">
                        <?php if ($usuario->getHorario() == 'matutino' || $usuario->getHorario() == 'vespertino'): ?>
                            <?php echo __('PDF_Matricula:'); ?>&nbsp;
                            <span style="font-size:14px; padding:0 0 0x 5px; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; text-align:left; font-weight:normal;">    
                                <?php echo costos::getSymbol() . ' ' . costos::getCosto('matricula') / 2; ?>
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>                
            <?php endif; ?>

            <?php if ($actividades->count() > 0): ?>
                <tr>
                    <td colspan="2" style="font-size:14px; padding:5px 0 0 0; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; font-weight:bold; text-align:left;">
                        <?php echo __('PDF_Actividades adicionales:'); ?>&nbsp;
                        <?php $first = true; ?>
                        <?php foreach ($actividades as $usuarioActividad): ?>
                            <span style="font-size:14px; padding:0 0 0 5px; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; text-align:left; font-weight:normal;">
                                <?php if (!$first): ?>
                                    <?php echo ' - '; ?>
                                <?php endif; ?>
                                <?php $first = false; ?>

                                <?php echo $usuarioActividad->getActividad()->getNombre() . ': ' . ' ' . costos::getSymbol() . ' ' . $usuarioActividad->getActividad()->getCosto(); ?>
                            </span>
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endif; ?>

            <?php if ($saldo != 0): ?>
                <tr>
                    <td colspan="2" style="font-size:14px; padding:5px 0 10px 0; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; font-weight:bold; text-align:left;">
                        <?php echo __('PDF_Saldo:'); ?>&nbsp;
                        <span style="font-size:14px; padding:0 0 0 5px; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; text-align:left; font-weight:normal;">
                            <?php echo costos::getSymbol() . ' ' . $saldo; ?>
                        </span>
                    </td>
                </tr>
            <?php endif; ?>

            <tr>
                <td colspan="2" style="font-size:14px; padding:10px 0 10px 0; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; font-weight:bold; text-align:left;">
                    <?php echo __('PDF_Total:'); ?>&nbsp;
                    <span style="font-size:14px; padding:0 0 0 5pxpx; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; text-align:left; font-weight:normal;">
                        <?php echo costos::getSymbol() . ' ' . $usuario->calcularTotal(); ?>
                    </span>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="font-size:14px; padding:8px 0 0 0; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; font-weight:bold; text-align:left;">
                    <?php echo __('PDF_Nombre Alumno:'); ?>&nbsp;
                    <span style="font-size:14px; padding:0 0 0 5px; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; text-align:left; font-weight:normal;"> 
                        <?php echo $usuario->getNombre() . ' ' . $usuario->getApellido(); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="font-size:14px; padding:8px 0 0 0; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; font-weight:bold; text-align:left;"> 
                    <?php echo __('PDF_Referencia bancaria:'); ?>&nbsp;
                    <span style="font-size:14px; padding:0 0 0 5px; font-family:Lucida Grande, Lucida Sans Unicode, sans-serif; color:#353535; text-align:left; font-weight:normal;"> 
                        <?php echo $usuario->getReferenciaBancaria(); ?>
                    </span>
                </td>
            </tr>
        </table>
    </body>
</html>
