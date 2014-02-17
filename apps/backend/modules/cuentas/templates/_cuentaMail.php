<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Bunny's Kinder</title>
        <link rel="stylesheet" type="text/css" href="<?php echo stylesheet_path('invoice', true);?>" />
    </head>
  <body style="background:#FFFFFF; margin:15px 0 0 30px;">	
<!--	<header>
		<h1>Factura</h1>
	</header>-->
		<article>
			<address data-prefix>
				<p><?php echo image_tag('logo.jpg', array('absolute' => true)); ?></p>
			</address>
			<table class="meta">
				<tr>
					<th><span data-prefix>Referencia Bancaria</span></th>
					<td><span data-prefix><?php echo $cuenta->getReferenciabancaria();?></span></td>
				</tr>
				<tr>
					<th><span data-prefix>Fecha</span></th>
					<td><span data-prefix><?php echo date('d/n/Y');?></span></td>
				</tr>
        <tr>
					<th><span data-prefix>Alumno(s)</span></th>
					<td>
					  <span data-prefix>
						<?php 
						$alumnos = "";
						$apellido = "";
						foreach($cuenta->getCuentausuario() as $cuentaUsuario)
						{
						  $alumnos .= $cuentaUsuario->getUsuario()->getNombre() . "<br/>";
						  $apellido = $cuentaUsuario->getUsuario()->getApellido();
						}
						echo rtrim($alumnos, '|');
						?>
					  </span>
					</td>
				</tr>
        <tr>
					<th><span data-prefix>Padre(s)</span></th>
					<td>
					  <span data-prefix>
						<?php 
						$padres = "";
						foreach($cuenta->getCuentapadre() as $cuentaPadre)
						{
						  $padres .= $cuentaPadre->getProgenitor()->getNombre() . " ".$apellido. "<br/>";
						}
						echo rtrim($padres, '|');
						?>
					  </span>
					</td>
				</tr>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span data-prefix>Descripción</span></th>
						<th><span data-prefix>Precio</span></th>
					</tr>
				</thead>
				<tbody>
          <?php foreach($facturas as $factura): ?>
          <?php foreach($factura->getFacturaFinalDetalle() as $facturaDetalle): ?>
          <tr>
              <td><span data-prefix><?php echo $facturaDetalle->getDescription();?></span></td>
              <td><span data-prefix>$ <?php echo $facturaDetalle->getFormatedAmount();?></span></td>
          </tr>
          <?php endforeach; ?>
        <?php if($factura->getPagadodeltotal() > 0): ?>
          <tr>
              <td><span data-prefix>Pago sobre el total</span></td>
              <td><span data-prefix>- $<?php echo $factura->getFormatedPagadoDelTotal();?></span></td>
          </tr>
        <?php endif; ?>
        <?php endforeach; ?>
				</tbody>
			</table>
			<table class="balance">
				<tr>
					<th><span data-prefix>Total</span></th>
					<td><span data-prefix>$</span><span><?php echo $cuenta->getFormatedDiferencia();?></span></td>
				</tr>
			</table>
		</article>
  </body>
</html>