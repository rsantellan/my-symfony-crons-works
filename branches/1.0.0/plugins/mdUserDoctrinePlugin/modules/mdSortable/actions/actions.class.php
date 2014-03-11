<?php

/**
 * mdSortable actions.
 *
 * @package    plugins
 * @subpackage mdMediaDoctrinePlugin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdSortableActions extends sfActions
{


    public function executeObjectSorting(sfWebRequest $request)
    {
      $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdSortable', 'cleanLayout.php') . '/cleanLayout');
      
      $this->className = $request->getParameter("className");
      $this->forward404Unless($this->className);
      $typeName = $request->getParameter("typeName", NULL);
      $this->objectList = array();
      $this->parentCategories = array();
      $this->hasCategories = false;

      if(sfConfig::get( 'sf_plugins_categories_separate_by_type', false ))
      {
        $categoryProfileDisplay = sfConfig::get( 'app_plugins_category_by_elements', null );
        if(!is_null($categoryProfileDisplay))
        {
          foreach($categoryProfileDisplay as $categoryProfile)
          {
            if($categoryProfile['object_class'] == $this->className)
            {
                if($categoryProfile['object_type'] == $typeName)
                {
                    array_push($this->parentCategories, mdCategoryHandler::retrieveCategory($categoryProfile['category_root_id']));
                    $found = true;
                }
  
            }
          }
        }
      }
      else
      {
          $this->parentCategories = mdCategoryHandler::retrieveAllParentCategoriesOfClass($this->className);
      }
      if(count($this->parentCategories) > 0)
      {
        $this->hasCategories = true;
      }
      else
      {
        if($this->className == "mdDynamicContent")
        {
          $this->objectList = mdDynamicContent::retrieveCollection($typeName);
        }         
      }

    }
    
    
    
    public function executeBringChilds(sfWebRequest $request)
    {
      $categories = mdCategoryHandler::retrieveAllMdCategorySons($request->getParameter ( 'mdCategoryId' ) );
      $className = $request->getParameter ( 'className' );
      if(count($categories) == 0)
      {
        $body = "";
      }
      else
      {
        $body = $this->getPartial("mdSortable/category_child_select", array("list" => $categories, 'className' => $className));
      }
      return $this->renderText(mdBasicFunction::basic_json_response(true, array('body'=>$body)));

    }
    
    
    public function executeBringObjects(sfWebRequest $request)
    {
      $list = mdCategoryHandler::retrieveAllObjectsFromCategory($request->getParameter ( 'mdCategoryId' ), 1, NULL, NULL, false, false);
      $return_list = array();
      foreach($list as $obj)
      {
        $return_list[$obj->getId()] = $obj->getId();
        //print_r($obj->toArray());
      }
      $className = $request->getParameter ( 'className' );
      $body = $this->getPartial("mdSortable/sort_list_structure", array('list'=> $list, 'className' => $className));
      return $this->renderText(mdBasicFunction::basic_json_response(true, array('body'=>$body)));  
    }
    
    /**
     * Recibe los datos del mdContentConcrete en:
     * $_MD_Object_Ids:
     * $_MD_Object_Class_Names:
     * $_MD_Priorities:
     * 
     * @param sfWebRequest $request
     */
    public function executeSortable(sfWebRequest $request)
    {
        try {
            $_MD_Object_Ids         = explode('|', $request->getParameter("_MD_Object_Ids", ""));
            $_MD_Object_Class_Names = explode('|', $request->getParameter("_MD_Object_Class_Names", ""));
            $_MD_Priorities         = explode('|', $request->getParameter("_MD_Priorities", ""));
            $_MD_Page               = $request->getParameter("_MD_Page", 1);
            $_MD_Limit              = $request->getParameter("_MD_Limit", 0);
            $mdCategoryId             = $request->getParameter("mdCategoryId");
            $is_category_related    = $request->getParameter("is_category_related");
            $offset = $_MD_Limit * ($_MD_Page - 1);

            if($_MD_Object_Ids == "" || $_MD_Object_Class_Names == "" || $_MD_Priorities == "")
            {
                throw new Exception("wrong _MD_Object_Id or _MD_Object_Class_Name", 100);
            }

            $i = 0;
            foreach($_MD_Object_Ids as $object_id)
            {
                $object_class_name = $_MD_Object_Class_Names[$i];
                $priority = $_MD_Priorities[$i] + $offset;
                //var_dump($object_class_name);
                //var_dump($priority);
                //var_dump($is_category_related);
                //echo "<hr/>";
                if($is_category_related == 0)
                {
                  $mdContentConcrete = Doctrine::getTable($object_class_name)->find($object_id);
                  $mdContentConcrete->setPriority($priority);
                  $mdContentConcrete->save();                  
                }
                else
                {
                  $mdContentConcrete = Doctrine::getTable("mdCategoryObject")->retrieveMdCategoryObject($object_id, $mdCategoryId);
                  //var_dump(($mdContentConcrete));
                  //$mdContentConcrete = $mdCategoryObject->retrieveObject();
                  $mdContentConcrete->setPriority($priority);
                  $mdContentConcrete->save();  
                }
                
                $i++;
            }

            return $this->renderText(json_encode(array('response' => 'OK')));

        }catch(Exception $e){

            return $this->renderText(json_encode(array('response' => 'ERROR', 'options' => array('message' => $e->getMessage()))));

        }
    }
}
