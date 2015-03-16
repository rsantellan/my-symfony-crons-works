<?php
/**
 */
class PluginmdMediaContentTable extends Doctrine_Table
{
    /**
     * retrieve an mdMediaContent object from an object that implements mdMediaContentBehavior
     *
     * @param mdMediaContentBehavior $object
     * @return mdMediaContent
     * @author Rodrigo Santellan
     */
    public function retrieveByObject($object, $timeToLife = 86400)
    {
        $query = Doctrine_Query::create()
                ->select('mdC.*')
                ->from('mdMediaContent mdC')
                ->where('mdC.object_class_name = ?', $object->getObjectClass())
                ->addWhere('mdC.object_id = ?', $object->getId());

        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $object->getObjectClass() . '-' . $object->getId());
        }

        return $query->fetchOne();
    }

    /**
     *
     * @param <type> $mdMediaContentId
     * @param <type> $timeToLife
     * @return <type> 
     */
    public function retrieveByPk($mdMediaContentId, $timeToLife = 86400)
    {
        $query = Doctrine_Query::create()
                ->select('mdC.*')
                ->from('mdMediaContent mdC')
                ->where('mdC.id = ?', $mdMediaContentId);

        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $mdMediaContentId);
        }

        return $query->fetchOne();
    }

    /**
     *
     * @param <type> $contentIds
     * @param <type> $timeToLife
     * @return <type> 
     */
    public function retrieveMdMediaContents($contentIds, $timeToLife = 86400, $hydrationMode = Doctrine_Core::HYDRATE_ARRAY, $objectClass = NULL)
    {
        $query = Doctrine_Query::create()
                ->select('c.*')
                ->from('mdMediaContent c')
                ->whereIn('c.id', $contentIds);
        if($objectClass != NULL){
            $query->addWhere('c.object_class_name=?', $objectClass);
        }

        //Seteamos modo de hidratacion ARRAY
        $query->setHydrationMode($hydrationMode);

        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_IDS_' . implode('-', $contentIds) . '_' . $hydrationMode);
        }

        return $query->execute();
    }

    public function retrieveContentIdByClassAndObjectId($class, $id){
        $query = Doctrine_Query::create()
                ->select('c.*')
                ->from('mdMediaContent c')
                ->where('c.object_class_name=?', $class)
                ->andWhere('c.object_id=?',$id);

        return $query->fetchOne();
    }
}