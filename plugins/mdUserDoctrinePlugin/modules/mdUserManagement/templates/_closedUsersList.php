<ul id="objects" class="md_objects">
    <li id ='new_product_' style='display: none;' class='md_objects open'></li>
    <?php foreach($pager->getResults() as $mdUser):?>
        <?php //echo $mdUserContent->getId()?>
        <?php include_partial('closedUser',array('mdUser'=> $mdUser))?>
			
        <script type="text/javascript">
						createMdObjectBox(<?php echo $mdUser->getId() ?>);
        </script>

     <?php endforeach;?>
    <?php if($sf_user->hasPermission('Backend Create User')):?>
    <?php endif;?>
    <?php if ($pager->haveToPaginate()): ?>
    <div id="md_pager">
        <a href="<?php echo url_for('mdUserManagement/index?page='.$pager->getPreviousPage()) ?>"> < </a>
        <?php $pagerCount = count($pager->getLinks())?>
        <?php $pagerIndex = 0?>
        <?php foreach ($pager->getLinks() as $page): ?>
            <?php if ($page == $pager->getPage()): ?>
                <a class="current"><?php echo $page ?></a>
            <?php else: ?>
            <a href="<?php echo url_for('mdUserManagement/index?page='.$page) ?>"><?php echo $page ?></a>
            <?php endif; ?>
            <?php
                if($pagerIndex < $pagerCount -1){
                    echo " | ";
                    $pagerIndex++;
                }
            ?>
        <?php endforeach; ?>
        <a href="<?php echo url_for('mdUserManagement/index?page='.$pager->getNextPage()) ?>">
            >
        </a>
    </div>
    <?php endif;?>
    </ul><!--UL PRODUCTO-->
