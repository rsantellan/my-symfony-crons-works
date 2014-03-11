<?php
class mdMediaContentAdminComponents extends sfComponents {

    public function executeShowAlbums(sfWebRequest $request)
    {
        mdMediaManager::$LOAD_ON_DEMAND_CONTENT = true;
        $this->manager = mdMediaManager::getInstance(mdMediaManager::ALL, $this->object)->load();

        try{
            $this->album_title = $this->manager->getTitle();
        } catch(Exception $e){
            $this->album_title = null;
        }

    }
    
    public function executeYoutubeList(sfWebRequest $request)
    {
        $instance = mdMediaManager::getInstance(mdMediaManager::YOUTUBEVIDEOS, $this->object)->load(NULL, array("order" => mdMediaManager::MD_FILTER_ID));
        if (!$instance->hasAlbum("youtube")) 
        {
            $album = $instance->createAlbum(array(
                "title" => "youtube",
                "description" => "videos youtube",
                "type" => mdMediaManager::YOUTUBEVIDEOS));
            $id = $album->getId();
        }
        else
        {
            $album = $instance->getAlbums("youtube");
            $id = $album->id;
        }
        $instance = mdMediaManager::getInstance(mdMediaManager::YOUTUBEVIDEOS, $this->object)->load("youtube", array("order" => mdMediaManager::MD_FILTER_ID));

        $count = $instance->getCount();
        
        $this->manager = $instance;
        $this->count = $count;
        $this->album = $instance->getAlbums();
        $this->form = new mdMediaYoutubeVideoForm();
    }

}
