<?php

/**
 */
class PluginmdUserProfileTable extends Doctrine_Table {

    public function addFilterByCountry($query, $country, $options = array()) {
        //inicializo las opciones
        if (!isset($options['excluded']))
            $options['excluded'] = array();

        //soluciono problema de hidratacion
        if ($query->getType() == Doctrine_Query_Abstract::SELECT)
            $query->select($query->getRootAlias() . '.*');

        $query->addFrom('mdUserProfile mdUP, mdContent mdC')
                ->addWhere($query->getRootAlias() . '.id = mdC.md_user_id')
                ->addWhere('mdC.object_class = "mdUserProfile"')
                ->addWhere('mdC.object_id = mdUP.id')
                ->addWhere('mdUP.country_code = ?', $country);
        return $query;
    }

    public function retrieveAllMdUserProfiles($excludeIds = array(), $onlyActive = true, $withProfile = array(), $isQuery = true)
    {
        $query = $this->createQuery("mdUP");
        if(count($excludeIds) > 0)
        {
            $query = $this->retrieveAllMdUserProfilesNotInList($query, $excludeIds);
        }
        if($onlyActive)
        {
            $query = $this->retrieveAllMdUserProfilesWithActiveLike($query, $onlyActive);
        }
        if(count($withProfile) > 0)
        {
            $query = $this->retrieveMdUserProfileWithProfilesQuery($query, $withProfile);
        }
        if($isQuery)
        {
            return $query;
        }
        return $query;
    }

    public function retrieveMdUserProfileWithProfilesQuery($query = null, $withProfiles = array()){
        if($query == null)
        {
            $query = $this->createQuery("mdUP");
        }
        if(count($withProfile) > 0)
        {
            $query = Doctrine::getTable("mdProfileObject")->addJoinWithProfiles($query, $withProfile);
        }
        return $query;
    }

    
    public function retrieveAllMdUserProfilesNotInList($query = null, $excludeIds = array())
    {
        if($query == null){
            $query = $this->createQuery("mdUP");
        }
        if ($query->getType() == Doctrine_Query_Abstract::SELECT)
            $query->select($query->getRootAlias() . '.*');
        $query->whereNotIn($query->getRootAlias().'.id', $excludeIds);
        return $query;
    }
    
    public function retrieveAllMdUserProfilesWithActiveLike($query = null, $activeStatus = true)
    {
        if($query == null){
            $query = $this->createQuery("mdUP");
        }
        if ($query->getType() == Doctrine_Query_Abstract::SELECT)
            $query->select($query->getRootAlias() . '.*');
        $query->addFrom('mdContent mdC, mdPassport mdP');
        $query->addWhere("mdC.object_id = ".$query->getRootAlias().".id");
        $query->addWhere("mdC.object_class = ?", "mdUserProfile");
        $query->addWhere("mdC.md_user_id = mdP.md_user_id");
        $query->addWhere("mdP.account_active = ?", $activeStatus);
        return $query;
    }

    public function retrieveAllMdUserProfilesWithNames($name, $lastname, $excludeIds = array(), $onlyActive = true)
    {
        $query = $this->createQuery("mdUP");
        $query->addWhere("(mdUP.name LIKE ? OR mdUP.last_name LIKE ?)", array('%'.$name.'%', '%'.$lastname.'%'));
        //$query->orWhere("mdUP.last_name LIKE ?", '%'.$lastname.'%');
        $query = $this->retrieveAllMdUserProfilesNotInList($query, $excludeIds);
        $query = $this->retrieveAllMdUserProfilesWithActiveLike($query, $onlyActive);
        return $query;
    }

    public function getAllMdUserProfileOfProfile($mdProfileId) {
        $query = Doctrine_Query::create ()
                        ->select('mdP.*')
                        ->from('mdUserProfile mdP, mdProfileObject mdPO')
                        ->where('mdPO.object_id = mdP.id')
                        ->addWhere('mdPO.object_class_name = ?', "mdUserProfile")
                        ->addWhere('mdPO.md_profile_id = ?', $mdProfileId);
        return $query->execute();
    }

    public function getAllMdUserProfileOfProfileIds($profilesId = array()) {
        $query = Doctrine_Query::create ()
                        ->select('mdP.*')
                        ->from('mdUserProfile mdP, mdProfileObject mdPO')
                        ->where('mdPO.object_id = mdP.id')
                        ->addWhere('mdPO.object_class_name = ?', "mdUserProfile");

        if (count($profilesId) != 0) {
            $query->andWhereIn('mdPO.md_profile_id', $profilesId);
        }

        return $query->execute();
    }

    public function getAllMdUserProfileOfProfileIdsQuery($profilesId = array()) {
        $query = Doctrine_Query::create ()
                        ->select('mdP.*')
                        ->from('mdUserProfile mdP, mdProfileObject mdPO')
                        ->where('mdPO.object_id = mdP.id')
                        ->addWhere('mdPO.object_class_name = ?', "mdUserProfile");

        if (count($profilesId) != 0) {
            $query->andWhereIn('mdPO.md_profile_id', $profilesId);
        }


        return $query;
    }

    public function findByMdUserId($md_user_id, $timeToLife = 86400) {

        $query = Doctrine_Query::create ()
                        ->select('mdP.*')
                        ->from('mdUserProfile mdP, mdContent mdC')
                        ->where('mdC.object_id = mdP.id')
                        ->addWhere('mdC.object_class = ?', 'mdUserProfile')
                        ->addWhere('mdC.md_user_id = ?', $md_user_id);
        if (sfConfig::get('sf_driver_cache')) {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_findByMdUserId_' . $md_user_id);
        }
        return $query->fetchOne();
    }

    public function retrieveObject($id, $timeToLife = 86400) {
        $q = $this->createQuery('j')
                        ->where('j.id = ?', $id);
        if (sfConfig::get('sf_driver_cache')) {
            //$q->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_id_' . $id);
        }
        return $q->fetchOne();
    }

    public function removeCacheByPrefix($keyPart) {
        $manager = Doctrine_Manager::getInstance();
        $cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
        $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . $keyPart;
        @$cacheDriver->deleteByPrefix($key);
    }

    public function refreshCacheId($id, $label = null) {
        if (sfConfig::get('sf_driver_cache')) {
            $manager = Doctrine_Manager::getInstance();
            $cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
            $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_id_' . $id;
            $cacheDriver->delete($key);
        }
    }

}
