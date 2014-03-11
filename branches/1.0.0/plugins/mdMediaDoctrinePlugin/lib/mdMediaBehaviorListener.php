<?php
 
class mdMediaBehaviorListener extends Doctrine_Record_Listener
{  
    public function postSave(Doctrine_Event $event)
    {
        //sfContext::getInstance()->getLogger()->log('>>>>> postSave mdMediaBehavior');
        Md_Cache::$_use_cache = false;
        $object = $event->getInvoker();
        $mdMedia = Doctrine::getTable('mdMedia')->retrieveByObject($object);
        //sfContext::getInstance()->getLogger()->log('>>>>> POST SAVE MDMEDIA ' . $event->getInvoker()->getObjectClass() . ' ' . $event->getInvoker()->getId());
        if(!$mdMedia){
            //sfContext::getInstance()->getLogger()->log('>>>>> NEW MDMEDIA ');
            $mdMedia = new mdMedia();
            $mdMedia->setObjectClassName(get_class($object));
            $mdMedia->setObjectId($object->getId());
            $mdMedia->save();
        }
        $this->cleanCache($mdMedia, $object);
        Md_Cache::$_use_cache = true;
    }

    public function preDelete(Doctrine_Event $event)
    {
        Md_Cache::$_use_cache = false;
        $object = $event->getInvoker();
        $mdMedia = Doctrine::getTable('mdMedia')->retrieveByObject($object);
        $this->cleanCache($mdMedia, $object);
        if($mdMedia)
            $mdMedia->delete();
        Md_Cache::$_use_cache = true;
    }

    private function cleanCache($mdMedia, $mdObject)
    {
        //Eliminar mdMedia del cache
        if(sfConfig::get('sf_driver_cache'))
        {
            $manager = Doctrine_Manager::getInstance()->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
            $key = sfConfig::get('sf_root_dir').  '_' . $mdMedia->getTable()->getTableName() . '_' . $mdObject->getObjectClass() . '-' . $mdObject->getId();
            $manager->delete($key);
        }
    }
    
}

