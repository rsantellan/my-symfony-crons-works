<?php
 
class mdMediaBehavior extends Doctrine_Template
{
    public function setTableDefinition()
    {
            $this->addListener(new MdMediaBehaviorListener());
    }
    
    public function retrieveMdMedia(){
        //sfContext::getInstance()->getLogger()->log('>>>>> GET MDMEDIA ' . $this->getInvoker()->getObjectClass() . ' ' . $this->getInvoker()->getId());
        $mdMedia = Doctrine::getTable('mdMedia')->retrieveByObject($this->getInvoker());
        if(!$mdMedia){
            //sfContext::getInstance()->getLogger()->log('>>>>> NEW MDMEDIA ');
            $mdMedia = new mdMedia();
            $mdMedia->setObjectClassName($this->getInvoker()->getObjectClass());
            $mdMedia->setObjectId($this->getInvoker()->getId());
            $mdMedia->save();
        }
        //sfContext::getInstance()->getLogger()->log('>>>>> GET MDMEDIA ' . $mdMedia->getId());
        return $mdMedia;
    }

    public function getPath()
    {
    	try{
    		$path = $this->getInvoker()->getUploadPath();
    	}catch(Exception $e){
    		$path = '/media/'. $this->getInvoker()->getObjectClass() .'/';
    	}
    	return $path;
    }

    /**
     * Calcula un posible avatar para el objeto
     *
     * @param <type> $object
     */
    public function retrieveAvatar($options = array('width' => 46,'height' => 46), $type = mdMediaAlbum::MIXED)
    {
        try
        {
            mdMediaManager::$LOAD_ON_DEMAND_CONTENT = true;
            $manager = mdMediaManager::getInstance($type, $this->getInvoker())->load();
            $mdAlbums = $manager->getAlbums();

            if(empty($mdAlbums) || count($mdAlbums) == 0)
            {
                $url = "/..".$this->getInvoker()->retrieveDefault();
                return mdWebImage::getUrl($url, $options);
            }
            if($manager->hasAlbum("default"))
            {
                $mdAlbum = $manager->getAlbums("default");
                if($mdAlbum->avatarId != NULL)
                {
                    return $manager->getAvatarUrl($mdAlbum->title, $options);
                }
            }
            
            foreach($mdAlbums as $mdAlbum)
            {
                if($mdAlbum->avatarId != NULL)
                {
                    return $manager->getAvatarUrl($mdAlbum->title, $options);
                }
            }
            $url = "/..".$this->getInvoker()->retrieveDefault();
            return mdWebImage::getUrl($url, $options);
            //return $this->getInvoker()->retrieveDefault();

        }catch(Exception $e)
        {
            sfContext::getInstance()->getLogger()->err($e->getMessage());
            return $this->getInvoker()->retrieveDefault();
        }
    }

    public function hasAvatar($type = mdMediaAlbum::MIXED)
    {
        try
        {
            mdMediaManager::$LOAD_ON_DEMAND_CONTENT = true;
            $manager = mdMediaManager::getInstance($type, $this->getInvoker())->load();
            $mdAlbums = $manager->getAlbums();

            if(empty($mdAlbums) || count($mdAlbums) == 0)
            {
                return false;
            }
            if($manager->hasAlbum("default"))
            {
                $mdAlbum = $manager->getAlbums("default");
                if($mdAlbum->avatarId == NULL)
                {
                    return false;
                }
            }

            foreach($mdAlbums as $mdAlbum)
            {
                if($mdAlbum->avatarId != NULL)
                {
                    return true;
                }
            }

            return false;

        }catch(Exception $e){
            
            return false;

        }
    }

    public function retrieveAvatarObject($type = mdMediaAlbum::MIXED){
        mdMediaManager::$LOAD_ON_DEMAND_CONTENT = true;
        $instance   = mdMediaManager::getInstance($type, $this->getInvoker())->load();
        try
        {
          $mdObject   = $instance->getAvatar(NULL, true); //Avatar
        }catch(Exception $e)
        {
          return NULL;
        }
        
        return $mdObject;
    }
    
    public function getMediaManager(){
            $manager = mdMediaManager::getInstance(mdMediaManager::MIXED, $this->getInvoker())->load();
            return $manager;
    }
}

