<?php
// Enviamos los encabezados de hoja de calculo 

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=subscriptionUsers.xls");

?>

<table cellpadding="0" cellspacing="0" style="width: 450px !important;">
<tr>
    <th>E-mail</th>
</tr>

<?php foreach($results as $result): ?>
    <tr>
        <td><?php echo $result->getEmail(); ?></td>
    </tr>
<?php endforeach; ?>
</table>
