<?php
/**
 */
class PluginmdMediaYoutubeVideoTable extends Doctrine_Table
{


    public function retrieveObject($object_id, $timeToLife = 86400, $hydrationMode = Doctrine_Core::HYDRATE_RECORD)
    {
        //Creamos la Doctrine Query
        $query = $this->createQuery("mdMYV")
                    ->where('mdMYV.id = ?', $object_id);

        //Seteamos modo de hidratacion
        $query = $query->setHydrationMode($hydrationMode);

        //Cacheamos el resultado
        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $object_id . '_' . $hydrationMode);
        }

        return $query->fetchOne();
    }
    
}