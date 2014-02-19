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
						<td align="center" bgcolor="#d2ebd8" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
							<img src="<?php echo image_path('logo-pdf.jpg', array('absolute' => true)); ?>" alt="Bunny's Kinder" style="display: block;" />
						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
										<b>Factura generada para la cuenta.</b>
									</td>
								</tr>
								<tr>
									<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
										<?php 
                    //$cantidadUsuarios = $cuenta->getCuentausuario()->count();
                    $nombres = '';
                    $texto = 'A continuación se adjunta el archivo con la deuda de %s:';
                    $cantidadUsuarios = 0;
                    foreach($cuenta->getCuentausuario() as $cuentaUsuario)
                    {
                      if($cuentaUsuario->getUsuario()->getEgresado() == 0)
                      {
                        $nombres .= " ".$cuentaUsuario->getUsuario()->getNombre() . ",";
                        $cantidadUsuarios ++;
                      }
                    }
                    if($cantidadUsuarios > 1)
                    {
                      $texto = sprintf($texto, 'los alumnos');
                    }
                    else
                    {
                      $texto = sprintf($texto, 'el alumno');
                    }
                    echo $texto.rtrim($nombres, ','). ".";
                    ?>
                    Para la fecha <?php echo date('n/Y');?>.<br/>
                    Por cualquier consulta no dude en comunicarse con nosotros. <a href="http://bunnyskinder.com.uy/contacto.html">Contacto</a>
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