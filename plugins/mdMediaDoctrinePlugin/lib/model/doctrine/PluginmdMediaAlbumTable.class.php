<?php
/**
 */
class PluginmdMediaAlbumTable extends Doctrine_Table
{
    /**
     * Devuelve los albums de tipo $key de la media de identificador $mdMediaId
     *
     * @param <integer> $mdMediaId
     * @param <string> $key {Image, Video, File, Mixed}
     * @return <array>
     * @author Gaston Caldeiro
     */
    public function findAlbums($mdMediaId, $key, $timeToLife = 86400, $hydrationMode = Doctrine_Core::HYDRATE_ARRAY)
    {
        //Creamos la Doctrine Query
        $query = Doctrine_Query::create()
                ->select('mdA.*')
                ->from('mdMediaAlbum mdA')
                ->where('mdA.md_media_id = ?', $mdMediaId)
                ->orderBy("mdA.id DESC");
                
        if($key != mdMediaManager::ALL)
        {
          //Descomentar esta linea cuando tengamos soporte por tipo de album
          $query->addWhere('mdA.type = ?', $key);
        }

        //Seteamos modo de hidratacion
        $query->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

        //Cacheamos el resultado
        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $mdMediaId . '_' . $hydrationMode);
        }

        return $query->execute();
    }

    /**
     *
     * @param <type> $mediaId
     * @param <type> $album
     * @param <type> $timeToLife
     * @param <type> $hydrationMode
     * @return <type>
     * @author Gaston Caldeiro
     */
    public function retrieveAlbum($mediaId, $album, $timeToLife = 86400, $hydrationMode = Doctrine_Core::HYDRATE_ARRAY)
    {
        //Creamos la Doctrine Query
        $query = Doctrine_Query::create()
                ->select('mdA.*')
                ->from('mdMediaAlbum mdA')
                ->where('mdA.md_media_id = ?', $mediaId);

        if(is_integer($album))
        {
            $query->andWhere('mdA.id = ?', $album);
        }
        else
        {
            $query->andWhere('mdA.title = ?', $album);
        }

        //Seteamos modo de hidratacion
        $query->setHydrationMode($hydrationMode);

        //Cacheamos el resultado
        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $mediaId . '-' . $album . '_' . $hydrationMode);
        }

        return $query->fetchOne();
    }
}

class mysqlMdMediaAlbum
{
    public static function retrieveCountCache($mdAlbumId)
    {
        try
        {
            $sql = "SELECT counter_content as counter FROM md_media_album WHERE id = " . $mdAlbumId;

            $db = Doctrine_Manager::getInstance()->getConnection('doctrine')->getDbh();
            $st = $db->prepare($sql);
            $st->setFetchMode(Doctrine_Core::FETCH_ASSOC);
            $st->execute();
            $result = $st->fetchObject();
            if($result) return $result->counter;
            else return 0;
        }
        catch(Exception $e)
        {
            throw new Exception("mysqlMdMediaAlbum::retrieveCountCache - " . $e->getMessage(), $e->getCode());
        }
    }
}
