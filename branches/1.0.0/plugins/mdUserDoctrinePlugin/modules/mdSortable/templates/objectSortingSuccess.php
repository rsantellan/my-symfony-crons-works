<?php 
use_helper('mdAsset');
use_plugin_javascript('mdUserDoctrinePlugin', 'mdSortingManagement.js');

?>
<div style="text-align: center">
<h1><?php echo __("ordenar_Titulo");?></h1>
<?php
if(count($parentCategories) > 0):
?> 

<div class="category_child_container">
  <select id="md_category_parents_roots" onchange="mdSortingManagement.getInstance().retriveChilds(this, '<?php echo url_for("mdSortable/bringChilds"); ?>', '<?php echo $className?>');">
    <option value="0"><?php echo __("ordenar_Seleccione una categoria padre");?></option>
  <?php foreach($parentCategories as $parent):?>
    <option value="<?php echo $parent->getId();?>"><?php echo $parent->getName();?></option>
  <?php endforeach; ?>
  </select>
</div>
<input type="button" onclick="mdSortingManagement.getInstance().retriveObjects(this, '<?php echo url_for("mdSortable/bringObjects"); ?>', '<?php echo $className?>');" value="<?php echo __("ordenar_Boton");?>"/>
<div class="objects_container">
  <div id="objects_container">
  
  </div>
</div>
<input type="hidden" value="1" id="is_category_related"/>
<?php
else:
?>
<div class="objects_container">
  <div id="objects_container">
  
<?php 
      include_partial("mdSortable/sort_list_structure", array('list'=> $objectList, 'className' => $className));
      ?>
      <script type="text/javascript">
      $(document).ready(function() {
          mdSortingManagement.getInstance().startAccordion();
      });
      </script>
  </div>
</div>
<input type="hidden" value="0" id="is_category_related"/>
<input type="hidden" value="0" id="md_category_sons"/>
<?php endif;?>
</div>
