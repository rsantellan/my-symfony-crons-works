<?php
class mdRelationContentComponents extends sfComponents
{

    /**
     * Debe recibir en $request los siguientes parametros:
     * content_id
     * @param sfWebRequest $request
     */
    public function executeRelationContent(sfWebRequest $request)
    {
        try{
            if($this->_MD_Content_Id == "")
            {
                throw new Exception('wrong _MD_Content_Id', 100);
            }
            $mdContent = Doctrine::getTable('mdContent')->find($this->_MD_Content_Id);
            $mdObject = $mdContent->retrieveObject();

            $this->_MD_Object_Id = $mdObject->getId();
            $this->_MD_Object_Class_Name = $mdObject->getObjectClass();

            $configuration = contentHandler::getInstance()->retrieveConfiguration($this->_MD_Object_Class_Name, $this->_MD_Dynamic_Content_Type);            
            $_MD_Content_Configuration = (isset($configuration['relations']) ? $configuration['relations'] : NULL);
            $this->hasRelations = (!is_null($_MD_Content_Configuration) && count($_MD_Content_Configuration) > 0);
        }catch(Exception $e){

            echo $e->getMessage();
            
        }
    }

}
