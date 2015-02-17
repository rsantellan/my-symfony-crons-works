<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <style type="text/css">
            html, body {
                margin: 0;
                padding: 0;
                border: 0;
                outline: 0;
                font-weight: normal;
                font-style: normal;
                font-size: 12px;
                font-family: Arial, Helvetica, sans-serif;
                background-color: #ffffff;
            }
            table {
               width: 100%;
               border: 1px solid #000;
            }
            th, td {
               min-width: 10%;
               text-align: left;
               vertical-align: top;
               border: 1px solid #000;
               padding: 5px;
            }
            table thead tr td{
              font-size: 14px;
              font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div id="mym-content">
          <table>
            <thead>
              <tr>
                <td><strong>Nombre</strong></td>
                <td><strong>Apellido</strong></td>
                <td><strong>Fecha de Nacimiento</strong></td>
                <td><strong>Clase</strong></td>
              </tr>
            </thead>
            <tbody>
              <?php foreach($pager->getResults() as $usuario): ?>
              <tr>
                <td><?php echo $usuario->getNombre(); ?></td>
                <td><?php echo $usuario->getApellido(); ?></td>
                <td><?php echo format_date($usuario->getFechaNacimiento(), 'd/M/yyyy'); ?></td>
                <td><?php echo $usuario->getClase(); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <script type="text/javascript">
            javascript:window.print();
            parent.$.fancybox.close();
//          setTimeout(function(){}, 5000);
        </script>
    </body>
</html>
