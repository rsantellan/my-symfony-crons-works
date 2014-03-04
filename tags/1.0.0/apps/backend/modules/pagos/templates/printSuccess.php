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
                <td><strong>Usuario</strong></td>
                <td><strong>Precio</strong></td>
                <td><strong>Mes</strong></td>
              </tr>
            </thead>
            <tbody>
              <?php foreach($pager->getResults() as $pago): ?>
              <tr>
                <td><?php echo $pago->getUsuario(); ?></td>
                <td><?php echo costos::getSymbol() . ' ' . $pago->getPrice(); ?></td>
                <td><?php echo mdHelp::month($pago->getMes()); //echo format_date($pago->getFecha(), 'd/M/yyyy'); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <script type="text/javascript">
            javascript:window.print();
            setTimeout(function(){parent.$.fancybox.close()}, 5000);
        </script>
    </body>
</html>
