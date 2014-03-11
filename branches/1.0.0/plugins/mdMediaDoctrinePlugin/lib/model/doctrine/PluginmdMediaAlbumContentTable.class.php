<?php
/**
 */
class PluginmdMediaAlbumContentTable extends Doctrine_Table
{
    /**
     * Devuelve los mdContentIds de el album de identificador $mdAlbumId
     *
     * @param <integer> $mdMediaAlbumId
     * @param <integer> $timeToLife
     * @return <array>
     * @author Gaston Caldeiro
     */
    public function retrieveContentIds($mdMediaAlbumId, $timeToLife = 86400, $filter = mdMediaManager::MD_FILTER_PRIORITY)
    {
        //Creamos la Doctrine Query
        $query = Doctrine_Query::create()
                ->select('mdAC.md_media_content_id')
                ->from('mdMediaAlbumContent mdAC')
                ->where('mdAC.md_media_album_id = ?', $mdMediaAlbumId);

        switch ($filter){
            case mdMediaManager::MD_FILTER_PRIORITY:
                    $query = $query->orderBy('mdAC.priority ASC');
                break;
            case mdMediaManager::MD_FILTER_ID:
                    $query = $query->orderBy('mdAC.md_media_content_id DESC');
                break;
        }

        //Seteamos modo de hidratacion
        $query->setHydrationMode(Doctrine_Core::HYDRATE_NONE);

        //Cacheamos el resultado
        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $mdMediaAlbumId);
        }

        return $query->execute();
    }

    public function setPriorityToAlbum($objectClass, $content_id, $priority, $album_id){
        $query = Doctrine_Query::create()
            ->update('mdMediaAlbumContent c')
            ->set('priority', $priority)
            ->where('c.object_class_name=?', $objectClass)
            ->andWhere('c.md_media_content_id=?', $content_id)
            ->andWhere('c.md_media_album_id=?', $album_id);

        return $query->execute();
    }
}