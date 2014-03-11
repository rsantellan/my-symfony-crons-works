<?php foreach($list as $object): ?>
<div>
    <div class="accordion-header" id="accordion_header_id_<?php echo $object->getId();?>">
        <?php include_partial('mdSortable/sort_list_'.$className, array('object' => $object, 'className' => $className)); ?>
    </div>
    
    <!--init accordion body empty -->
    <div class="accordion-body"></div>
</div>
<?php endforeach; ?>
