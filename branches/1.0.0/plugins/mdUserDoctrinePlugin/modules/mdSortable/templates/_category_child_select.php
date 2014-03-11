<div class="category_child_container">
  <select onchange="mdSortingManagement.getInstance().retriveChilds(this, '<?php echo url_for("mdSortable/bringChilds"); ?>', '<?php echo $className?>');">
    <option value="0">-</option>
<?php foreach($list as $child): ?>
    <option value="<?php echo $child->getId();?>"><?php echo $child->getName();?></option>
<?php endforeach; ?>    
  </select>
  
</div
