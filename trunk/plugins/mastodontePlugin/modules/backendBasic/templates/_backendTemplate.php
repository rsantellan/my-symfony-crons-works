<?php use_helper('mdAsset') ?>
<?php use_plugin_stylesheet('mastodontePlugin', '../js/jquery-ui-1.8.4/css/smoothness/jquery-ui-1.8.4.custom.css') ?>
<?php use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-ui-1.8.4.custom.min.js', 'last') ?>
<?php use_plugin_javascript('mastodontePlugin','jquery-ui-1.8.4/development-bundle/ui/i18n/jquery.ui.datepicker-'.sfContext::getInstance()->getUser()->getCulture().'.js','last'); ?>
<?php use_plugin_javascript('mastodontePlugin', 'jType.js') ?>
<?php use_plugin_javascript('mastodontePlugin', 'mastodontePlugin.backendBasic.js') ?>
<?php use_plugin_javascript('mastodontePlugin', 'mastodontePlugin.backendFloating.js') ?>
<?php use_plugin_javascript('mastodontePlugin','AjaxLoader.js','last'); ?>
<?php use_plugin_javascript('mastodontePlugin', 'easySlider1.5.js', 'last'); ?>

<div id="md_center_container">
    <div class="md_shadow">
        <div class="md_center">

            <div class="md_content_center">
                <h1 style="float: left">
                    <?php $type = ""; ?>
                    <?php
                        $hasParameter = false;
                        if(isset($parameters)){
                            if(isset($parameters['type'])){
                                $type = $parameters['type'];
                                echo __('layout_'.$module.$parameters['type']);
                                $hasParameter = true;
                            }
                        }
                        if(!$hasParameter)
                            echo __('layout_'.$module);

                    ?>
                    <span> (<?php echo $objects->count();?>)</span>
                </h1>
                
                <div style="float:right">
                  <?php if ($objects->haveToPaginate()): ?>
                     <?php     
                        $addToPager = "";
                       if(isset($parameters)){
                          if(isset($parameters['addToUrl'])){
                            $addToPager = "&".$parameters['addToUrl'];
                          }
                        }
                      ?>
                        <div id="md_pager">
                            <a href="javascript:void(0)" onclick="mastodontePlugin.UI.BackendBasic.getInstance().doPager('<?php echo url_for($module.'/index').'?page=' . $objects->getPreviousPage().$addToPager?>',<?php echo $objects->getPreviousPage()?>);" >
                                <
                            </a>
                            <?php $objectsCount = count($objects->getLinks()) ?>
                            <?php $objectsIndex = 0 ?>
                            <?php foreach ($objects->getLinks() as $page): ?>
                            <?php if ($page == $objects->getPage()): ?>
                                        <a class="current"><?php echo $page ?></a>
                            <?php else: ?>
                                        <a href="javascript:void(0)" onclick="mastodontePlugin.UI.BackendBasic.getInstance().doPager('<?php echo url_for($module.'/index').'?page=' . $page.$addToPager?>',<?php echo $page?>);" href="<?php echo url_for($module.'/index?page=' . $page.$addToPager) ?>)"><?php echo $page ?></a>
                            <?php endif; ?>
                            <?php
                                if ($objectsIndex < $objectsCount - 1) {
                                    echo " | ";
                                    $objectsIndex++;
                                }
                            ?>
                            <?php endforeach; ?>
                            <a href="javascript:void(0)" onclick="mastodontePlugin.UI.BackendBasic.getInstance().doPager('<?php echo url_for($module.'/index').'?page=' . $objects->getNextPage().$addToPager?>',<?php echo $objects->getNextPage()?>);" >
                                >
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="clear"></div>
                <div id="md_content_actions">
                <?php 
                if(isset($isSortable) && $isSortable):
                
                  $urlSortable = url_for("mdSortable/objectSorting");
                  $urlSortable .= "?className=".$objectClass;
                    if(isset($parameters)){
                      if(isset($parameters['addToUrl'])){
                        $urlSortable .= "&".$parameters['addToUrl'];
                      }
                    }
                  ?>
                  
                  <a id="sorter_href" href="<?php echo url_for($urlSortable);?>" class="iframe"><?php echo __('layout_Ordenar') ?></a> | 
                
                <?php   
                endif;
                ?>
                <?php if(!isset($hasAdd) || (isset($hasAdd) && $hasAdd)): ?>
                    <?php
                      
                      $url = url_for($module.'/addBox');
                      if(isset($parameters)){
                        if(isset($parameters['addToUrl'])){
                          $url .= "?".$parameters['addToUrl'];
                        }
                      }
                     ?>
                    
                    <a id="addBox" href="<?php echo $url ?>" onclick="mastodontePlugin.UI.BackendBasic.getInstance().addBox(); return false;"><?php echo __('layout_Agregar') ?></a>
                <?php endif; ?>
                </div>              
                  
                
                <div class="clear"></div>
                <div id="md_objects_container" class="md_objects">
                    <!-- PARTIAL DE BOX CERRADO -->
                    <?php foreach($objects->getResults() as $object): ?>
                    <?php $cache_key = $module."_".$object->getId();?>
                    <div>
                        <div class="accordion-header" id="accordion_header_id_<?php echo $object->getId();?>">
                            <?php include_partial($module.'/closed_box', array('object' => $object, 'sf_cache_key' => $cache_key)); ?>
                        </div>
                        
                        <!--init accordion body empty -->
                        <div class="accordion-body"></div>
                    </div>
                    <?php endforeach; ?>

                    <?php if ($objects->haveToPaginate()): ?>
                        <div id="md_pager">
                            <?php echo link_to('<', $module.'/index?page=' . $objects->getPreviousPage().$addToPager) ?>
                            <?php $objectsCount = count($objects->getLinks()) ?>
                            <?php $objectsIndex = 0 ?>
                            <?php foreach ($objects->getLinks() as $page): ?>
                            <?php if ($page == $objects->getPage()): ?>
                                        <a class="current"><?php echo $page ?></a>
                            <?php else: ?>
                                            <a href="<?php echo url_for($module.'/index?page=' . $page.$addToPager) ?>"><?php echo $page ?></a>
                            <?php endif; ?>
                            <?php
                                if ($objectsIndex < $objectsCount - 1) {
                                    echo " | ";
                                    $objectsIndex++;
                                }
                            ?>
                            <?php endforeach; ?>
                            <?php echo link_to('>', $module.'/index?page=' . $objects->getNextPage().$addToPager) ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="backend_right_filter" class="md_right_container">
<?php if(isset($formFilter)): ?>
  <div class="md_right_shadow">
      <div class="md_center_right">
          <div class="md_content_right">
              <h1><?php echo __('mdUserDoctrine_text_backendFilter') ?></h1>
              <?php
                $itIsFiltered = false;
                if(isset($isFiltered))
                {
                  $itIsFiltered= true;
                }
                
                ?>
              <?php include_partial($module.'/filter_box', array('formFilter' => $formFilter, "typeName" => $type, "isFiltered" => $itIsFiltered)) ?>
          </div>
      </div>
  </div>
<?php endif; ?>
</div>
<div id="backend_right_floating"class="md_right_container">
  
</div>


<script type="text/javascript">
  var containerAuxId = <?php echo isset($accordionContainerId)? '"'.$accordionContainerId.'"' : '"#md_objects_container"';?>;
  var accordionEvent = <?php echo isset($accordionEvent)? '"'.$accordionEvent.'"' : '"click"';?>;
  var isSortable = <?php echo isset($isListSortable)? '"'.$isListSortable.'"' : 'false';?>;
  
  $(function() {
    
		mastodontePlugin.UI.BackendBasic.getInstance().init(containerAuxId, accordionEvent, isSortable);
    
	});
  $(document).ready(function () {
    $(window).scroll(function (event) {
      mastodontePlugin.UI.BackendFloating.getInstance().move($(this).scrollTop());
    });
    $("a#sorter_href").fancybox();
  });
</script>
