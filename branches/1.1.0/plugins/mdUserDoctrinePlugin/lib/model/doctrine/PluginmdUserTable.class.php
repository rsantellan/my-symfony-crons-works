<?php

/**
 */
class PluginmdUserTable extends Doctrine_Table {

    
    public function retrieveSimpleQuery()
    {
        return $this->createQuery("mdU");
    }

    /**
     * Retrieves the mdUser by the given email
     * @param string $email
     * @return Doctrine_Collection
     * @author Rodrigo Santellan
     */
    public function retrieveMdUserByEmail($email) {
        $query = Doctrine_Query::create ()
                        ->select('mdU.*')
                        ->from('mdUser mdU')
                        ->where('mdU.email = ?', $email);

        if (sfConfig::get('sf_driver_cache')) {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_retrieveMdUserByEmail_' . $email);
        }

        return $query->fetchOne();
    }

    /**
     * Retrieves All the mdUsers
     * @return Doctrine_Collection
     * @author Rodrigo Santellan
     */
    public function retrieveMdUsers() {
        $query = $query = Doctrine_Query::create ()
                        ->select('mdU.*')
                        ->from('mdUser mdU');


        if (sfConfig::get('sf_driver_cache')) {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_list_md_users');
        }

        return $query;
    }

    public function retrieveMdUserById($id, $timeToLife = 86400) {
        $query = $query = Doctrine_Query::create ()
                        ->select('mdU.*')
                        ->from('mdUser mdU')
                        ->where('mdU.id = ?', $id);


        if (sfConfig::get('sf_driver_cache')) {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_md_user_' . $id);
        }

        return $query->fetchOne();
    }

    public function retrieveMdUsersReference($timeToLife = 86400) {
        //Creamos la Doctrine Query
        $query = Doctrine_Query::create()
                        ->select('mdU.id')
                        ->from('mdUser mdU');

        //Seteamos modo de hidratacion ARRAY
        $query->setHydrationMode(Doctrine_Core::HYDRATE_NONE);

        //Cacheamos el resultado

        if (sfConfig::get('sf_driver_cache')) {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_list_md_users_ids');
        }

        return $query->execute();
    }

    public function findByMd5Email($md5Email) {
        $time_to_life = 3600; //1 hora

        $query = Doctrine_Query::create ()
                        ->select('mdU.*')
                        ->from('mdUser mdU')
                        ->where('md5(mdU.email) = ?', $md5Email)
                        ->limit(1);

        if (sfConfig::get('sf_driver_cache')) {
            $query->useResultCache(true, $time_to_life, 'referer_' . $md5Email);
        }

        return $query->fetchOne();
    }

    public function removeCacheByKey($keyPart) {
        $manager = Doctrine_Manager::getInstance();
        $cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
        $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . $keyPart;
        @$cacheDriver->delete($key);
    }

    public function removeCacheByPrefix($keyPart) {
        $manager = Doctrine_Manager::getInstance();
        $cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
        $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . $keyPart;
        @$cacheDriver->deleteByPrefix($key);
    }

    public function retrieveUsersHasAccount(Array $contactList)
    {
        $q = Doctrine_Query::create()
            ->select('u.*')
            ->from('mdUser u')
            ->whereIn("u.email", $contactList);

        //Seteamos modo de hidratacion
        //$q->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

        $results = $q->execute();

        return $results;
    }
    
    public function selectBlocked($query, $blocked = true)
    {
      
        if(!$query)
          $query = $this->createQuery("mdU");
        $query->select($query->getRootAlias() . '.*');
        $query->addFrom('mdPassport mdP');
        $query->addWhere('mdP.account_blocked = ?', $blocked);
        $query->addWhere($query->getRootAlias() . '.id = mdP.md_user_id');
        return $query;
    }    

}
