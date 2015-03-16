<?php
/**
 */
class PluginmdMediaTable extends Doctrine_Table
{
    /**
     * retreive an mdMedia object from an object that implements mdMediaBehavior
     * post: El resultado debe ser un objeto de Doctrine, no cambiar el modo de hidratacion
     *       en esta funcion
     * @param mdMediaBehavior $object
     * @return mdMedia
     * @author Rodrigo Santellan
     */
    public function retrieveByObject($object, $timeToLife = 86400)
    {
        $query = Doctrine_Query::create()
                ->select('mdC.*')
                ->from('mdMedia mdC')
                ->where('mdC.object_class_name = ?',$object->getObjectClass())
                ->addWhere('mdC.object_id = ?',$object->getId());

        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $object->getObjectClass() . '-' . $object->getId());
        }

        return $query->fetchOne();
    }
}