<?php

/**
 * mdRelationContent actions.
 *
 * @package    plugins
 * @subpackage mdMediaDoctrinePlugin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdRelationContentActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('default', 'module');
    }

    public function executeNewRelationContent(sfWebRequest $request)
    {
        // Obtenemos parametros
        $_MD_Object_Id         = $request->getParameter("_MD_Object_Id", "");
        $_MD_Object_Class_Name = $request->getParameter("_MD_Object_Class_Name", "");

        $mdContentConcrete = Doctrine::getTable($_MD_Object_Class_Name)->find($_MD_Object_Id);

        $typeName = (($mdContentConcrete instanceof mdDynamicContent) ? $mdContentConcrete->getTypeName() : NULL);

        $configuration = contentHandler::getInstance()->retrieveConfiguration($_MD_Object_Class_Name, $typeName);

        $this->_MD_Content_Configuration = $configuration['relations'];

        $this->is_simple = (count($this->_MD_Content_Configuration) <= 1);

        if($this->is_simple)
            $this->_MD_Content_Configuration = $this->_MD_Content_Configuration[0];

        $this->_MD_Content_Concrete_Owner = $mdContentConcrete;

        $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdRelationContent', 'layoutRelation.php') . '/layoutRelation');
    }

    public function executeNewRelationInContent(sfWebRequest $request)
    {
        // Obtenemos parametros
        $_MD_Object_Id_Owner          = $request->getParameter("_MD_Object_Id_Owner", "");
        $_MD_Object_Class_Name_Owner  = $request->getParameter("_MD_Object_Class_Name_Owner", "");
        $_MD_Object_Id                = $request->getParameter("_MD_Object_Id", "");
        $_MD_Object_Class_Name        = $request->getParameter("_MD_Object_Class_Name", "");
        $_MD_Profile_Id               = $request->getParameter("_MD_Profile_Id", "");

        $_MD_Content_Concrete_Owner = Doctrine::getTable($_MD_Object_Class_Name_Owner)->find($_MD_Object_Id_Owner);

        $typeName = (($_MD_Content_Concrete_Owner instanceof mdDynamicContent) ? $_MD_Content_Concrete_Owner->getTypeName() : NULL);

        $_MD_Content_Configuration = contentHandler::getInstance()->retrieveRelationConfiguration($_MD_Object_Class_Name_Owner, $_MD_Object_Class_Name, $typeName, $_MD_Profile_Id);

        $value = array(
            'response' => 'OK',
            'body' => $this->getPartial('mdRelationContent/simpleContent', array('_MD_Content_Concrete_Owner' => $_MD_Content_Concrete_Owner, '_MD_Content_Configuration' => $_MD_Content_Configuration))
        );

        return $this->renderText(json_encode($value));
    }

    public function executeRetrieveContentData(sfWebRequest $request)
    {
        $_MD_Object_Id         = $request->getParameter("_MD_Object_Id", "");
        $_MD_Object_Class_Name = $request->getParameter("_MD_Object_Class_Name", "");

        $page = $_POST['page'];
        $rp = $_POST['rp'];
        $sortname = $_POST['sortname'];
        $sortorder = $_POST['sortorder'];

        $mdContent = Doctrine::getTable($_MD_Object_Class_Name)->find($_MD_Object_Id);

        $mdContentConcretes = $mdContent->retrieveContents(NULL, NULL, $page, $rp);

        $total = $mdContent->retrieveTotal();

        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
        header("Cache-Control: no-cache, must-revalidate" );
        header("Pragma: no-cache" );
        header("Content-type: text/x-json");

        $rows = array();

        $i = 1;
        foreach($mdContentConcretes as $mdConcrete)
        {
            $rows[] = array(
                        'id' => $i,
                        'cell' => array($mdConcrete->getId(), $mdConcrete->getObjectClass(), $mdConcrete->getShowOnTableMdRelation(), $mdConcrete->getDetail())
                        );
            $i++;
        }
        $result = array(
                    'page'  => $page,
                    'total' => $total,
                    'rows'  => $rows
                    );

        return $this->renderText(json_encode($result));
    }

    /**
     * Recibe los datos del mdContentConcrete en:
     * $_MD_Object_Id:
     * $_MD_Object_Class_Name:
     * 
     * @param sfWebRequest $request
     */
    public function executeRemoveContent(sfWebRequest $request)
    {
        try{
            $_MD_Content_Id         = $request->getParameter("_MD_Content_Id", "");

            $_MD_Object_Ids         = explode('-', $request->getParameter("_MD_Object_Id", ""));
            $_MD_Object_Class_Names = explode('-', $request->getParameter("_MD_Object_Class_Name", ""));

            if($_MD_Object_Ids == "" || $_MD_Object_Class_Names == "" || $_MD_Content_Id == "")
            {
                throw new Exception("wrong _MD_Object_Id or _MD_Object_Class_Name", 100);
            }

            $i = 0;
            foreach($_MD_Object_Ids as $object_id)
            {
                $object_class_name = $_MD_Object_Class_Names[$i];

                // Obtenemos el mdContentConcrete owner
                $mdContentConcrete = Doctrine::getTable('mdContent')->find($_MD_Content_Id)->retrieveObject();

                // Obtenemos el mdContentConcrete to remove
                $mdContentConcreteToRemove = Doctrine::getTable($object_class_name)->find($object_id);
                $mdContentConcrete->removeContent($mdContentConcreteToRemove);

                // Eliminamos el contenido a borrar
                $mdContentConcreteToRemove->delete();

                $i++;
            }

            return $this->renderText(json_encode(array('response' => 'OK')));

        }catch(Exception $e){

            return $this->renderText(json_encode(array('response' => 'NOK', 'message' => $e->getMessage())));

        }
    }

    public function executeEditRelationContent(sfRequest $request)
    {
        try
        {
            $object_id         = $request->getParameter("_MD_Object_Id", "");
            $object_class_name = $request->getParameter("_MD_Object_Class_Name", "");
            $content_id_owner  = $request->getParameter("_MD_Content_Id", "");

            if($object_id == "" || $object_class_name == "" || $content_id_owner == "")
            {
                throw new Exception("wrong _MD_Object_Id or _MD_Object_Class_Name", 100);
            }

            $md_object = Doctrine::getTable($object_class_name)->find($object_id);

            $clase = $object_class_name . "Form";

            $this->_MD_Content_Id_Owner = $content_id_owner;
            $this->form = new $clase($md_object);

            $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdRelationContent', 'layoutRelation.php') . '/layoutRelation');

        }catch(Exception $e){

            echo $e->getMessage();

        }

    }
}
