<?php
 
class mdContentBehavior extends Doctrine_Template
{
    private $_md_contents = array();
    
    public function setTableDefinition()
    {
        $this->addListener(new mdContentBehaviorListener());
    }

    public function getMdUserIdTmp(){
        return $this->getInvoker()->mdUserIdTmp;
    }

    public function setMdUserIdTmp($id){
        $this->getInvoker()->mdUserIdTmp = $id;
    }

    public function setMdUserTmp(mdUser $mdUser){
        $this->getInvoker()->mdUserIdTmp = $mdUser->getId();
    }

    public function getMdUser(){
        $mdContent = Doctrine::getTable('mdContent')->retrieveByObject($this->getInvoker());
        return doctrine::getTable('mdUser')->find($mdContent->getMdUserId());
    }

    public function getMdUserProfileByApplicationId($md_application_id){
        $mdUser = $this->getMdUser();
        return $mdUser->getMdUserProfile($md_application_id);
    }
    
    /**
     * Returns the invoker class
     * @return String class of the object
     * @author Rodrigo Santellan
     */
    public function getObjectClass(){
    	return get_class($this->getInvoker());
    }

    public function addContent($contentConcrete)
    {
        $typeNameOwner      = NULL;
        $typeNameContent    = NULL;
        if( $this->getInvoker() instanceof mdDynamicContent ){ $typeNameOwner = $this->getInvoker()->getTypeName(); }
        if( $contentConcrete instanceof mdDynamicContent ){ $typeNameContent = $contentConcrete->getTypeName(); }

        if(contentHandler::getInstance()->validate($this->getInvoker()->getObjectClass(), $contentConcrete->getObjectClass(), $typeNameOwner, $typeNameContent))
        {
            //Obtengo el mdContent del invoker
            $mdContent = Doctrine::getTable('mdContent')->retrieveByObject($this->getInvoker());
            //Obtener el mdContent del $content
            $mdContenToAdd = Doctrine::getTable('mdContent')->retrieveByObject($contentConcrete);
            //Los asocio
            mdContentRelation::addContent($mdContent, $mdContenToAdd, $typeNameContent);
        }
        else
        {
            throw new Exception('you can not add a content of class ' . $contentConcrete->getObjectClass() . ' to a content of class ' . $this->getInvoker()->getObjectClass(), 100);
        }
    }
    
    public function removeContent($contentConcrete)
    {
        $typeNameContent    = NULL;

        if( $contentConcrete instanceof mdDynamicContent ){ $typeNameContent = $contentConcrete->getTypeName(); }

        //Obtengo el mdContent del invoker
        $mdContent = Doctrine::getTable('mdContent')->retrieveByObject($this->getInvoker());
        //Obtener el mdContent del $content
        $mdContenToRemove = Doctrine::getTable('mdContent')->retrieveByObject($contentConcrete);
        //Elimino la relacion
        mdContentRelation::removeContent($mdContent, $mdContenToRemove, $typeNameContent);
    }
    
    public function retrieveContents($object_class_name = NULL, $profileName = NULL, $page = 1, $limit = 15)
    {
        //Obtengo el mdContent del invoker
        $mdContent = Doctrine::getTable('mdContent')->retrieveByObject($this->getInvoker());

        //Obtenemos los punteros a los objetos relacionados
        $this->_md_contents = mdContentRelation::retrieveContentRelationIds($mdContent->getId(), $object_class_name, $profileName);

        // PAGINARLO
        $contentRelations = $this->paging($this->_md_contents, $page, $limit);

        // Tenemos que obtener los mdContent
        $mdContents = Doctrine::getTable('mdContent')->retrieveMdContents2($mdContent->getId(), $contentRelations, 86400, Doctrine_Core::HYDRATE_RECORD);

        $collection = array();
        foreach ($mdContents as $mdContent)
        {
            $contentConcrete = $mdContent->retrieveObject();
            array_push($collection, $contentConcrete);
        }

        usort($collection, "cmpPriority");

        return $collection;
    }

    public function retrieveContentsParentsOrChilds($onlyParents = true, $object_class_name = NULL, $profileName = NULL, $page = 1, $limit = 15)
    {
        //Obtengo el mdContent del invoker
        $mdContent = Doctrine::getTable('mdContent')->retrieveByObject($this->getInvoker());

        //Obtenemos los punteros a los objetos relacionados
        if($onlyParents)
        {
            $this->_md_contents = mdContentRelation::retrieveContentRelationIds($mdContent->getId(), $object_class_name, $profileName);
        }
        else
        {
            $this->_md_contents = mdContentRelation::retrieveContentRelationIdsByChilds($mdContent->getId(), $object_class_name, $profileName);
        }
        

        // PAGINARLO
        $contentRelations = $this->paging($this->_md_contents, $page, $limit);

        // Tenemos que obtener los mdContent
        $mdContents = Doctrine::getTable('mdContent')->retrieveMdContents2($mdContent->getId(), $contentRelations, 86400, Doctrine_Core::HYDRATE_RECORD);

        $collection = array();
        foreach ($mdContents as $mdContent)
        {
            $contentConcrete = $mdContent->retrieveObject();
            array_push($collection, $contentConcrete);
        }

        usort($collection, "cmpPriority");

        return $collection;
    }
    
    public function retrieveTotal()
    {
        return count($this->_md_contents);
    }

    /**
     * Carga los el contenido de los items de el album $album
     * pre: los contentIds tienen que estar cargados previamente
     *
     * @param <integer> $page
     * @param <integer> $limit
     * @return <array>
     */
    private function paging($ids, $page, $limit)
    {
        $contentIds = array();
        $array_contents = array_chunk($ids, $limit);

        if(array_key_exists(($page-1), $array_contents))
        {
            $contentIds = $array_contents[$page-1];
        }

        return $contentIds;
    }

    /*public function getParentContents($object_class_name = ''){
    	//Obtengo el mdContent del invoker
        $mdContent = Doctrine::getTable('mdContent')->retrieveByObject($this->getInvoker());
        $contentRelations = Doctrine::getTable('mdContentRelation')->retreiveParentsByMdContentId($mdContent->getId());
        $collection = array();
        foreach ($contentRelations as $contentRelation){
            if($object_class_name == '' || $object_class_name == $contentRelation->getObjectClassName()){
                try{
                    $content = Doctrine::getTable('mdContent')->find($contentRelation->getMdContentIdFirst());
                    $contentConcrete = Doctrine::getTable($content->getObjectClass())->find($content->getObjectId());
                    array_push($collection, $contentConcrete);
                }catch(Exception $e){
                    
                }
            }
        }
        return $collection;
    }
    */
    
    /**
     * Devuelve el objeto mdContent del invoker
     */
    public function retrieveMdContent()
    {
        return Doctrine::getTable('mdContent')->retrieveByObject($this->getInvoker());
    }

    public function getDetail()
    {
        return $this->getInvoker()->__toString();
    }

    public function retrieveParent()
    {
        $parent = false;
        $mdContentRelationParent = $this->retrieveMdContent()->retrieveParents();
        if($mdContentRelationParent->count() > 0)
        {
            $parent = $mdContentRelationParent->getFirst()->getMdContentRelation1()->retrieveObject();
        }
        return $parent;
    }

    public function retrieveParents()
    {
        $parents = array();
        $mdContentRelationParents = $this->retrieveMdContent()->retrieveParents();
        if($mdContentRelationParents->count() > 0)
        {
            foreach($mdContentRelationParents as $mdContentRelationParent)
            {
                echo $mdContentRelationParent->getMdContentRelation1()->retrieveObject()->getId();
                $parents[] = $mdContentRelationParent->getMdContentRelation1()->retrieveObject();
            }
        }
        return $parents;
    }
}

function cmpPriority($obj1, $obj2)
{
    //Esto es temporal y esta hecho solo para mdDynamicContent
    if(( $obj1 instanceof mdDynamicContent ) && ( $obj2 instanceof mdDynamicContent ))
    {
        if(  $obj1->getPriority() ==  $obj2->getPriority() ){ return 0 ; }
        return ($obj1->getPriority() < $obj2->getPriority()) ? -1 : 1;
    }
    else
    {
        return 0;
    }
}