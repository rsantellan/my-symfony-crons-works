<?php
/**
 */
class PluginmdContentRelationTable extends Doctrine_Table
{

  public function deleteRelatedOfId($mdContentId)
  {
    $query = Doctrine_Query::create()
            ->delete('mdContentRelation mdC')
            ->where('mdC.md_content_id_first = ?', $mdContentId)
            ->addWhere("mdC.md_content_id_second = ?", $mdContentId);
    $query->execute();
  }


    public function retrieveContentRelationIds($mdContentId, $object_class_name = NULL, $profileName = NULL , $timeToLife = 86400)
    {

        $query = Doctrine_Query::create()
                ->select('mdC.md_content_id_second')
                ->from('mdContentRelation mdC')
                ->where('mdC.md_content_id_first = ?', $mdContentId);

        $identifierClass = '';
        
        if(!is_null($object_class_name))
        {
            $query->addWhere('mdC.object_class_name = ?', $object_class_name);
            $identifierClass = '-' . $object_class_name;
        }

        $profileIdentifier = '';
        
        if(!is_null($profileName))
        {
            $query = $query->addWhere('mdC.profile_name = ?', $profileName);
            $profileIdentifier = '-' . $profileName;
        }

        $query->setHydrationMode(Doctrine_Core::HYDRATE_NONE);

        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $mdContentId . $identifierClass . $profileIdentifier);
        }

        return $query->execute();
    }

    public function retrieveContentRelationIdsByChilds($mdContentId, $object_class_name = NULL, $profileName = NULL , $timeToLife = 86400)
    {

        $query = Doctrine_Query::create()
                ->select('mdC.md_content_id_first')
                ->from('mdContentRelation mdC')
                ->where('mdC.md_content_id_second = ?', $mdContentId);

        $identifierClass = '';

        if(!is_null($object_class_name))
        {
            $query->addWhere('mdC.object_class_name = ?', $object_class_name);
            $identifierClass = '-' . $object_class_name;
        }

        $profileIdentifier = '';

        if(!is_null($profileName))
        {
            $query = $query->addWhere('mdC.profile_name = ?', $profileName);
            $profileIdentifier = '-' . $profileName;
        }

        $query->setHydrationMode(Doctrine_Core::HYDRATE_NONE);

        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $mdContentId . $identifierClass . $profileIdentifier);
        }

        return $query->execute();
    }
    
    public function refreshCache($mdContentId, $object_class_name, $profile_name)
    {
        if(sfConfig::get('sf_driver_cache'))
        {
            $identifierClass = array('', '-' . $object_class_name, '-' . $object_class_name . '-' . $profile_name);

            $manager = Doctrine_Manager::getInstance();
            $cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);

            foreach($identifierClass as $objectClassName)
            {
                $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' .$mdContentId . $objectClassName;
                $cacheDriver->delete($key);
            }
        }
    }

    public function retrieveParents($mdContentId, $timeToLife = 86400)
    {

        $query = Doctrine_Query::create()
                ->select('mdC.*')
                ->from('mdContentRelation mdC')
                ->where('mdC.md_content_id_second = ?', $mdContentId);

        return $query->execute();
    }

    public static function retrieveIfObjectsHasRelations($mdObjectParent, $mdObjectSon)
    {
        try
        {
            $sql = "SELECT `md_content_id_first`
                        FROM `md_content_relation`
                        WHERE `md_content_id_first` = :id_first
                        AND `md_content_id_second` = :id_second";

            $db = Doctrine_Manager::getInstance()->getConnection('doctrine')->getDbh();
            $st = $db->prepare($sql);
            $st->setFetchMode(Doctrine_Core::FETCH_ASSOC);
            $st->execute(array(":id_first" => $mdObjectParent->getId(), ":id_second" => $mdObjectSon->getId()));
            $result = $st->fetchColumn(0);
            if(!$result) return false;
            return true;
        }
        catch(Exception $e)
        {
            throw new Exception("mdContentRelationTable::retrieveIfObjectsHasRelations - " . $e->getMessage(), $e->getCode());
        }
    }

}
