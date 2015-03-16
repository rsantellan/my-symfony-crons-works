<!--<div id='group_container'>
	<dl>
    	<?php foreach($groups as $group):?>
    	<dt><input type="checkbox"  class="checkbox" onclick ="addGroupsForRemove(<?php echo $group->getId()?>,'<?php echo $group->getName()?>')"/><?php echo $group->getName();?></dt>
        <?php foreach($group->getMdGroupPermission() as $mdGroupPermission):?>
            <dd><?php echo ' - '.$mdGroupPermission->getMdPermission()->getName();?></dd>
        <?php endforeach;?>
		<?php endforeach;?>
    </dl>
</div>-->

<div id="categories_tree">
<ul class="md_categories">
    <?php foreach($groups as $group):?>
    <li class="md_category_level_0"><?php echo $group->getName()?></li>
    <li>
        <ul class="md_categories">
            <?php foreach($group->getMdGroupPermission() as $mdGroupPermission):?>
            <li class="md_category_level_1"><?php echo $mdGroupPermission->getMdPermission()->getName();?>
                <div style="display: none;" class="md_category_remove" onclick="deleteGroup(<?php echo $mdPassportId ?>,<?php echo $group->getId() ?>)"></div>
            </li>
            <?php endforeach; ?>
        </ul>
    </li>
    <?php endforeach; ?>
</ul>
</div>