<?php
class contentHandler
{
    const DYNAMIC_CONTENT   = 'mdDynamicContent';
    
    private static $instance = NULL;

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new contentHandler();
        }
        return self::$instance;
    }

    private function  __construct() {}

    /**
     * Devuelve los tipos de contenidos dinamicos padres
     *
     * @return <array> ejemplo:
     * array(2) {
     *     [0]=>
     *      array(3) {
     *          ["className"]=> string(16) "mdDynamicContent"
     *          ["typeName"]=> string(6) "imagen"
     *          ["profileId"]=> int(2)
     *          ["profileName"]=> string(6) "imagen"
     *          ["relations"]; ARRAY
     *      }
     *     [1]=>
     *      array(3) {
     *          ["className"]=> string(16) "mdDynamicContent"
     *          ["typeName"]=> string(5) "video"
     *          ["profileId"]=> int(3)
     *          ["profileName"]=> string(6) "video"
     *          ["relations"]; ARRAY
     *     }
     */
    public function retrieveDynamicParents()
    {

        $parents = array();
        $contentRelations = sfConfig::get('app_plugins_content_relations');
        foreach($contentRelations as $contentRelation)
        {
            if($contentRelation['className'] == self::DYNAMIC_CONTENT)
            {
                $parents[] = $contentRelation;
            }
        }
        return $parents;
    }

    /**
     * Devuelve un arreglo con la configuracion de los objetos de
     * clase $className. Si es un mdDynamicContent devuelve la configuracion
     * del tipo $typeName.
     *
     * @param <string> $className
     * @param <string> $typeName
     * @return <array> ejemplo:
     * array(4) {
     *  ["className"]=> string(16) "mdDynamicContent"
     *  ["typeName"]=> string(8) "proyecto"
     *  ["profileId"]=> int(7)
     *  ["profileName"]=> string(6) "proyecto"
     *  ["relations"]=> array(2) {
     *     [0]=> array(3) {
     *       ["className"]=> string(16) "mdDynamicContent"
     *       ["typeName"]=> string(6) "imagen"
     *       ["profileId"]=> int(2)
     *       ["profileName"]=> string(6) "imagen"
     *     }
     *     [1]=> array(3) {
     *       ["className"]=> string(16) "mdDynamicContent"
     *       ["typeName"]=> string(5) "video"
     *       ["profileId"]=> int(3)
     *       ["profileName"]=> string(6) "video"
     *     }
     */
    public function retrieveConfiguration($className, $typeName = NULL)
    {
        $contentRelations = sfConfig::get('app_plugins_content_relations');
        foreach($contentRelations as $contentRelation)
        {
            if($contentRelation['className'] == $className)
            {
                if(is_null($contentRelation['typeName']) || $contentRelation['typeName'] == $typeName)
                {
                    return $contentRelation;
                }
                else
                {
                    $relations = $contentRelation['relations'];
                    if(!is_null($relations))
                    {
                        foreach($relations as $relation)
                        {
                            if($relation['className'] == $className)
                            {
                                if(is_null($relation['typeName']) || $relation['typeName'] == $typeName)
                                {
                                    return $relation;
                                }
                            }
                        }
                    }
                }
            }
        }
        return NULL;
    }

    /**
     * Devuelve la configuracion de un hijo de un contenido dado por su clase y tipo
     *
     * @param <type> $className
     * @param <type> $typeName
     */
    public function retrieveRelationConfiguration($classNameOwner, $className, $typeNameOwner = NULL, $profileId = NULL)
    {
        $ownerConfiguration = $this->retrieveConfiguration($classNameOwner, $typeNameOwner);

        if(!is_null($ownerConfiguration))
        {
            foreach($ownerConfiguration['relations'] as $relation)
            {
                if($relation['className'] == $className && $profileId == $relation['profileId'])
                {
                    return $relation;
                }
            }
        }
        return NULL;
    }

    /**
     * Devuelve un arreglo con la configuracion de los objetos de
     * clase $className. Si es un mdDynamicContent devuelve la configuracion
     * del perfil de identificador $mdProfileId.
     *
     * @param <string> $className
     * @param <int> $mdProfileId
     * @return <array> ejemplo:
     * array(4) {
     *  ["className"]=> string(16) "mdDynamicContent"
     *  ["typeName"]=> string(8) "proyecto"
     *  ["profileId"]=> int(7)
     *  ["relations"]=> array(2) {
     *     [0]=> array(3) {
     *       ["className"]=> string(16) "mdDynamicContent"
     *       ["typeName"]=> string(6) "imagen"
     *       ["profileId"]=> int(2)
     *     }
     *     [1]=> array(3) {
     *       ["className"]=> string(16) "mdDynamicContent"
     *       ["typeName"]=> string(5) "video"
     *       ["profileId"]=> int(3)
     *     }
     */
    public function retrieveConfigurationByMdProfileId($className, $mdProfileId = NULL)
    {
        $contentRelations = sfConfig::get('app_plugins_content_relations');
        foreach($contentRelations as $contentRelation)
        {
            if($contentRelation['className'] == $className)
            {
                if(is_null($contentRelation['profileId']) || $contentRelation['profileId'] == $mdProfileId)
                {
                    return $contentRelation;
                }
                else
                {
                    $relations = $contentRelation['relations'];
                    if(!is_null($relations))
                    {
                        foreach($relations as $relation)
                        {
                            if($relation['className'] == $className)
                            {
                                if(is_null($relation['profileId']) || $relation['profileId'] == $mdProfileId)
                                {
                                    return $relation;
                                }
                            }
                        }
                    }
                }
            }
            else
            {
              $relations = $contentRelation['relations'];
              if(!is_null($relations))
              {
                  foreach($relations as $relation)
                  {
                      if($relation['className'] == $className)
                      {
                          if(is_null($relation['profileId']) || $relation['profileId'] == $mdProfileId)
                          {
                              return $relation;
                          }
                      }
                  }
              }
            }
        }
        return NULL;
    }
    
    /**
     * Devuelve true si $content puede asociarse a $owner
     *
     * @return <bool>
     */
    public function validate($ownerClassName, $contentClassName, $typeNameOwner = NULL, $typeNameContent = NULL)
    {
        $ownerConfiguration = contentHandler::getInstance()->retrieveConfiguration($ownerClassName, $typeNameOwner);

        if(is_null($ownerConfiguration)) return false;

        foreach($ownerConfiguration["relations"] as $contentRelation)
        {
            if($contentRelation['className'] == $contentClassName)
            {
                if(is_null($typeNameContent) || $contentRelation['typeName'] == $typeNameContent)
                {
                    return true;
                }
            }
        }

        return false;
    }
}
