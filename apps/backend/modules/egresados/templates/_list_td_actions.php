<td>
  <ul class="sf_admin_td_actions">
    <li class="sf_admin_action_edit"><a href="<?php echo url_for('usuario_edit', $usuario); ?>">Editar</a></li>
    <?php echo $helper->linkToDelete($usuario, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  </ul>
</td>
