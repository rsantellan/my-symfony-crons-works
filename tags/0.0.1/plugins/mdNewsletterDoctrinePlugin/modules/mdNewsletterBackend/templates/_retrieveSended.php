<table id="hor-minimalist-b">
  <thead>
    <tr>
      <th><?php echo __("newsletter_enviado");?></th>
      <th><?php echo __("newsletter_Destinatario");?></th>
      <th><?php echo __("newsletter_Fecha de envio");?></th>
      <th><?php echo __("newsletter_Acciones");?></th>
    </tr>
  </thead>
  <tbody id="table_body_of_sended">
    <?php foreach($list as $contentSended): ?>
      <?php include_partial("newsletter_table_line", array("contentSended"=>$contentSended));?>
    <?php endforeach;?>
  </tbody>
</table>

