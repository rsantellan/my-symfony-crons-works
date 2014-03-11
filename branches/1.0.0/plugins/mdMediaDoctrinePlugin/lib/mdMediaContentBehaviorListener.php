<?php
 
class mdMediaContentBehaviorListener extends Doctrine_Record_Listener
{
    /**
     * Guarda el mdMediaContent referenciando a el objeto recien creado
     * @param Doctrine_Event $event
     */
    public function postSave(Doctrine_Event $event)
    {
        Md_Cache::$_use_cache = false;
        $object = $event->getInvoker();
        $mdMediaContent = Doctrine::getTable('mdMediaContent')->retrieveByObject($object);
        if(!$mdMediaContent)
        {
            $mdMediaContent = new mdMediaContent();
            $mdMediaContent->setObjectClassName(get_class($object));
            $mdMediaContent->setMdUserIdTmp($object->getMdUserIdTmp());
            $mdMediaContent->setObjectId($object->getId());
            $mdMediaContent->save();
        }

        $this->cleanCache($mdMediaContent, $object);
        Md_Cache::$_use_cache = true;
    }

    /**
     * Elimina mdMediaContent que referenciaba al objeto y ademas elimina al
     * contenido de todos los albums en los que estaba
     * @param Doctrine_Event $event
     */
    public function preDelete(Doctrine_Event $event)
    {
        Md_Cache::$_use_cache = false;
        sfContext::getInstance()->getLogger()->log('>>>>>>>>> POST DELETE ');
        $object = $event->getInvoker();
        sfContext::getInstance()->getLogger()->log('>>>>>>>>> POST DELETE CLASE :  '.$object->getObjectClass());
        $mdMediaContentConcreteId = $object->getId();
        $mdMediaContent = $object->retrieveMdMediaContent();
        $mdMediaContentId = $mdMediaContent->getId();

        sfContext::getInstance()->getLogger()->log('>>>>>>>>> FOREACH');
        //Elimino el contenido de todos los albums en los que este
        foreach($mdMediaContent->getMdMediaAlbumContent() as $mdMediaContentAlbum){
            $mdMediaAlbum = $mdMediaContentAlbum->getMdMediaAlbum();
            sfContext::getInstance()->getLogger()->log('>>>>>>>>> DELETE CONTENT ALBUM');
            $mdMediaContentAlbum->delete();
            if($mdMediaAlbum->getMdMediaContentId() == $mdMediaContent->getId())
            { //si es el avatar
                sfContext::getInstance()->getLogger()->log('>>>>>>>>> avatar');
                $contentIds = mdMediaAlbum::retrieveContentIds($mdMediaAlbum->getId());
                $contentId = (count($contentIds) > 0 ? $contentIds[0] : NULL);
                $mdMediaAlbum->setMdMediaContentId($contentId);
                $mdMediaAlbum->save();
                
                $mdMedia = $mdMediaAlbum->getMdMedia();
                if($mdMedia->getObjectClassName() == "mdUserProfile")
                {
                  $src = NULL;
                  if(!is_null($contentId))
                  {
                    $mdMediaContent = Doctrine::getTable("mdMediaContent")->find($mdMediaContentId);
                    $object = $mdMediaContent->retrieveObject();
                    $src = $object->getObjectSource();          
                  }
                  mdUserSearchHandler::saveAvatar($src, $mdMedia->getObjectId());
                }
            }
        }
        sfContext::getInstance()->getLogger()->log('>>>>>>>>> DELETE media content');
        $mdMediaContent->delete();

        //Limpiamos el cache
        $this->cleanCache($mdMediaContent, $object);
        Md_Cache::$_use_cache = true;
        
        /****************** SI SE HABIA NEWSFEADO ***************/
        if(class_exists("mdNewsfeedHandler"))
        {
          mdNewsfeedHandler::deleteObjectNewsFeeds($object->getId(), $object->getObjectClass()); 
        }
        /********************************************************/        
    }

    private function cleanCache($mdMediaContent, $mdObject)
    {
        if(sfConfig::get('sf_driver_cache'))
        {
            sfContext::getInstance()->getLogger()->log('>>>>>>>>> CLEAN CACHE');
            $manager = Doctrine_Manager::getInstance()->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
            //Eliminar mdMediaContent del cache
            $key1 = sfConfig::get('sf_root_dir').  '_' . $mdMediaContent->getTable()->getTableName() . '_' . $mdMediaContent->getId();
            $key2 = sfConfig::get('sf_root_dir') . '_' . $mdMediaContent->getTable()->getTableName() . '_' . $mdObject->getObjectClass() . '-' . $mdObject->getId();
            sfContext::getInstance()->getLogger()->log('>>>>>>>>> DELETE ' . $key1);
            $manager->delete($key1);
            sfContext::getInstance()->getLogger()->log('>>>>>>>>> DELETE ' . $key2);
            $manager->delete($key2);
            //Eliminar mdMediaContentConcrete del cache
            $key1 = sfConfig::get('sf_root_dir').  '_' . $mdObject->getTable()->getTableName() . '_' . $mdObject->getId() . '_' . Doctrine_Core::HYDRATE_ARRAY;
            $key2 = sfConfig::get('sf_root_dir').  '_' . $mdObject->getTable()->getTableName() . '_' . $mdObject->getId() . '_' . Doctrine_Core::HYDRATE_RECORD;
            sfContext::getInstance()->getLogger()->log('>>>>>>>>> DELETE ' . $key1);
            $manager->delete($key1);
            sfContext::getInstance()->getLogger()->log('>>>>>>>>> DELETE ' . $key2);
            $manager->delete($key2);
            //Eliminar colecciones que podrian contener contenidos borrados
            $key1 = sfConfig::get('sf_root_dir').  '_' . $mdMediaContent->getTable()->getTableName() . '_IDS_';
            sfContext::getInstance()->getLogger()->log('>>>>>>>>> DELETE BY PREFIX' . $key1);
            $manager->deleteByPrefix($key1);
            //Eliminamos los albums en los cuales estaba
            foreach($mdMediaContent->getMdMediaAlbumContent() as $mdMediaContentAlbum){
                $album = $mdMediaContentAlbum->getMdMediaAlbum();
                $key1 = sfConfig::get('sf_root_dir').  '_md_media_album_content_' . $album->getId();
                sfContext::getInstance()->getLogger()->log('>>>>>>>>> DELETE ' . $key1);
                $manager->delete($key1);
            }

        }
    }
}

