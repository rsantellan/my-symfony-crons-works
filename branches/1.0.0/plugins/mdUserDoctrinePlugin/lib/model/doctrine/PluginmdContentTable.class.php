<?php
/**
 */
class PluginmdContentTable extends Doctrine_Table
{
	/**
	 * retreive an mdContent object from an object that implements mdContentBehavior
	 *
	 * @param mdContentBehavior $object 
	 * @return mdContent
	 * @author Rodrigo Santellan
	 */
	public function retrieveByObject($object){
		$query = Doctrine_Query::create()
                    ->select('mdC.*')
                    ->from('mdContent mdC')
                    ->where('mdC.object_class = ?',$object->getObjectClass())
                    ->addWhere('mdC.object_id = ?',$object->getId());
		return $query->fetchOne();
	}
	
	/**
	 * Retrieve the collection of objects of the given class for the user.
	 * @param $mdUserId
	 * @param $class
	 * @return Array();
	 * @author Rodrigo Santellan
	 */
	public function retrieveByMdUserClassName($mdUserId,$class){
		if(is_null($mdUserId) && is_null($class)) return null;
		$query = Doctrine_Query::create()
					->select('mdC.*')
					->from('mdContent mdC')
					->where('mdC.md_user_id = ?', $mdUserId)
					->addWhere ( 'mdC.object_class = ?', $class);
		return $query->execute();
	}
	
	/**
	 * Retrieve the collection of objects of the given class for the user.
	 * @param $mdUserId
	 * @param $class
	 * @return Array();
	 * @author Rodrigo Santellan
	 */
	public function retrieveByMdUserClassNameAndApplication($mdUserId,$class, $appId){
		if(is_null($mdUserId) && is_null($class)) return null;
		$query = Doctrine_Query::create()
					->select('mdC.*')
					->from('mdContent mdC, mdContentApplication mdCA')
					->where('mdC.md_user_id = ?', $mdUserId)
					->addWhere ( 'mdC.object_class = ?', $class)
					->addWhere('mdCA.md_content_id = mdC.id')
					->addWhere('mdCA.application_id = ?', $appId);
		return $query->execute();
	}
	
/**
	 * Retrieve one mdContent of the given class for the user.
	 * @param $mdUserId
	 * @param $class
	 * @return Array();
	 * @author Rodrigo Santellan
	 */
	public function retrieveOneByMdUserClassNameAndApplication($mdUserId,$class, $appId){
		if(is_null($mdUserId) && is_null($class)) return null;
		$query = Doctrine_Query::create()
					->select('mdC.*')
					->from('mdContent mdC, mdContentApplication mdCA')
					->where('mdC.md_user_id = ?', $mdUserId)
					->addWhere ( 'mdC.object_class = ?', $class)
					->addWhere('mdCA.md_content_id = mdC.id')
					->addWhere('mdCA.application_id = ?', $appId);
		return $query->fetchOne();
		
	}
	
	public function findByMultiples($keys = array(), $values = array()){
            $query = Doctrine_Query::create ()
                        ->select ('mdC.*')
                        ->from ('mdContent mdC');
            
            for ($i = 0; $i < count($keys); $i++){
                $query->addWhere('mdC.' . $keys[$i] . ' = ?', $values[$i]);
            }

            return $query->execute();
        }
        
	/**
	 * 
	 * @param String $class name of the class
	 * @param int $application id of the application
	 * @return mdContent
	 * @author Rodrigo Santellan
	 */
	public function retrieveByClassNameAndApplication($mdUserId, $class, $application){
		if(is_null($application) && is_null($class)) return null;
		$query = Doctrine_Query::create()
					->select('mdC.*')
					->from('mdContent mdC')
					->where ( 'mdC.object_class = ?', $class)
					->addWhere ( 'mdC.md_user_id = ?', $mdUserId)
					->leftJoin('mdC.application a')
					->addWhere('a.id = ?',$application);
		
		return $query->fetchOne(); 
	}


    /**
     *
     * @param <type> $contentIds
     * @param <type> $timeToLife
     * @return <type>
     */
    public function retrieveMdContents($contentIds, $timeToLife = 86400, $hydrationMode = Doctrine_Core::HYDRATE_ARRAY)
    {
        if(count($contentIds) == 0) return array();
        
        $query = Doctrine_Query::create()
                ->select('c.*')
                ->from('mdContent c')
                ->whereIn('c.id', $contentIds);

        //Seteamos modo de hidratacion
        $query->setHydrationMode($hydrationMode);

        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_IDS_' . implode('-', $contentIds) . '_' . $hydrationMode);
        }

        return $query->execute();
    }

    public function retrieveMdContents2($mdContentId, $contentIds, $timeToLife = 86400, $hydrationMode = Doctrine_Core::HYDRATE_ARRAY)
    {
        if(count($contentIds) == 0) return array();
        
        $query = Doctrine_Query::create()
                ->select('c.*')
                ->from('mdContent c')
                ->whereIn('c.id', $contentIds);

        //Seteamos modo de hidratacion
        $query->setHydrationMode($hydrationMode);

        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $mdContentId . '_IDS_' . implode('-', $contentIds) . '_' . $hydrationMode);
        }

        return $query->execute();
    }
}
