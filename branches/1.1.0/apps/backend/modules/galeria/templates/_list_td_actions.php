<td>
  <ul class="sf_admin_td_actions">
    <li class="sf_admin_action_promote">
			<a href="galeria/promote?id=<?php echo $md_galeria->getId()?>"></a>
    </li>
    <li class="sf_admin_action_demote">
			<a href="galeria/demote?id=<?php echo $md_galeria->getId()?>"></a>
    </li>

<?php echo $helper->linkToEdit($md_galeria, 'E') ?>



<?php echo $helper->linkToDelete($md_galeria, array('label'=>'B', 'confirm'=>'Realmente desea borrar "' . $md_galeria->getTitulo() . '" ?')) ?>


  </ul>
</td>
