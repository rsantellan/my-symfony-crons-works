<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Bunny's Kinder</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">	
		<tr>
			<td style="padding: 10px 0 30px 0;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr>
						<td align="center" bgcolor="#d2ebd8" style="color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
							<img src="<?php echo image_path('logo-pdf.jpg', array('absolute' => true)); ?>" alt="Bunny's Kinder" style="display: block;" />
						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
										<b>Queridos Padres:</b>
									</td>
								</tr>
								<tr>
									<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
										<?php 
                    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                    $message_account = 'La cuenta esta saldada';
                    if($cuenta->getDiferencia() > 0){
                      $message_account = sprintf('Usted debe $%s para dejar la cuenta saldada', $cuenta->getDiferencia());
                    }
                    else{
                      if($cuenta->getDiferencia() < 0)
                      {
                        $message_account = sprintf('Usted tiene el siguiente saldo a favor $%s', $cuenta->getDiferencia());
                      }
                    }
                    ?>
                    Se ha ingresado correctamente el pago en el mes de <strong><?php echo $meses[date('n')-1];?></strong>
					Del siguiente número de referencia: <strong><?php echo $cuenta->getReferenciabancaria();?></strong>
                    <strong><?php echo $message_account;?></strong>
                    El monto se encuentra en el archivo adjunto en el mail.
					Por cualquier consulta no dude en comunicarse con nosotros ,
					<strong>Bunny's Kinder</strong>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor="#d2ebd8" style="padding: 30px 30px 30px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: black; font-family: Arial, sans-serif; font-size: 14px; text-align: center" width="75%">
										&reg; Bunny's Kinder <?php echo date('Y');?><br/>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
