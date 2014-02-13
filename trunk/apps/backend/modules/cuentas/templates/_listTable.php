<table>
  <thead>
    <tr>
      <th>Referencia Bancaria</th>
      <th>Alumnos</th>
      <th>Padres</th>
      <th>Saldo de la cuenta</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($cuentas as $cuentaData): ?>

    <?php
      $cuenta = $cuentaData['cuenta'];
      $usuarios = $cuentaData['usuarios'];
      $parents = $cuentaData['parents'];
    ?>
    <tr class="<?php echo $trclass;?>">
      <td>
        <a href="<?php echo url_for("@detallecuenta?id=".$cuenta->getId());?>">
          <?php echo $cuenta->getReferenciabancaria();?>
        </a>
      </td>
      <td>
        <?php 
        $first = true;
        foreach($usuarios as $usuario): 
        if(!$first) echo '|';
        ?>
          <a href="<?php echo url_for('usuarios/edit/?id=' . $usuario->getId()); ?>"><?php echo $usuario->getNombre(). " ".$usuario->getApellido();?></a>
        <?php 
        $first = false;
        endforeach; ?>
      </td>
      <td>
        <?php 
        $first = true;
        foreach($parents as $parent): 
        if(!$first) echo '|';
        ?>
          <a href="<?php echo url_for('progenitores/edit/?id=' . $parent->getId()); ?>"><?php echo $parent->getNombre();?>(<?php echo $parent->getMail();?>)</a>
        <?php 
        $first = false;
        endforeach; 
        ?>
      </td>
      <td>
        <?php echo $cuenta->getDiferencia();?>
      </td>
      <td>
        Accion.
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<div class="clear"></div>