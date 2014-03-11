<?php
/**
 *   MODOS DE USO PARA IMAGENES
 *   //Carga todos los albums para el objeto $mdObject
 *   $instance = mdMediaManager::getInstance(mdMediaManager::IMAGES, $mdObject)->load();
 *   //Devuelve el avatar del album default si lo tiene
 *   $instance->getAvatar();
 *   //Devuelve el nombre del album default si lo tiene
 *   $instance->getTitle();
 *   //Devuelve la cantidad de imagenes del album default si lo tiene
 *   $instance->getCount();
 *   //Devuelve la descripcion del album default si lo tiene
 *   $instance->getDescription();
 *   //Devuelve las imagenes del album default si lo tiene
 *   $instance->getItems();
 *   /##################################################################################/
 *   //Carga todos los albums para el objeto $mdObject
 *   $instance = mdMediaManager::getInstance(mdMediaManager::IMAGES, $mdObject)->load();
 *   //Devuelve el avatar del album Galeria
 *   $instance->getAvatar('Galeria');
 *   //Devuelve el nombre del album Galeria
 *   $instance->getTitle('Galeria');
 *   //Devuelve la cantidad de imagenes del album Galeria
 *   $instance->getCount('Galeria');
 *   //Devuelve la descripcion del album Galeria
 *   $instance->getDescription('Galeria');
 *   //Devuelve las imagenes del album Galeria si lo tiene
 *   $instance->getItems('Galeria');
 *   /##################################################################################/
 *   //Carga todos los objetos de el album Galeria para el objeto $mdObject
 *   $instance = mdMediaManager::getInstance(mdMediaManager::IMAGES, $mdObject)->load('Galeria');
 *   //Devuelve el avatar del album Galeria
 *   $instance->getAvatar();
 *   //Devuelve el nombre del album Galeria
 *   $instance->getTitle();
 *   //Devuelve la cantidad de imagenes del album Galeria
 *   $instance->getCount();
 *   //Devuelve la descripcion del album Galeria
 *   $instance->getDescription();
 *   //Devuelve las imagenes del album Galeria si lo tiene
 *   $instance->getItems();
 *
 *
 */

class mdMediaManager
{
    const VIDEOS    = mdMediaAlbum::VIDEOS;

    const YOUTUBEVIDEOS    = mdMediaAlbum::YOUTUBEVIDEOS;
    
    const VIMEO     = mdMediaAlbum::VIMEO;    

    const IMAGES    = mdMediaAlbum::IMAGES;

    const FILES     = mdMediaAlbum::FILES;

    const MIXED     = mdMediaAlbum::MIXED;
    
    const ALL       = "ALL";

    const ITEMS_BY_PAGE     = 100;

    const MD_FILTER_PRIORITY = "priority";

    const MD_FILTER_ID       = "id";
    
    public static $LOAD_ON_DEMAND_CONTENT = false;

    private $mdObject       = NULL;

    private $key            = NULL;

    private $album_loaded   = NULL;

    private $albums         = array();

    private $count_albums   = NULL;

    private $count_comments_albums  = NULL;

    private $hashMap        = array();

    private $filter         = self::MD_FILTER_PRIORITY;

    public static function getInstance($key = self::IMAGES, $mdObject = NULL)
    {
        $valid_keys = array(self::VIDEOS, self::IMAGES, self::FILES, self::MIXED, self::YOUTUBEVIDEOS, self::VIMEO, self::ALL);
        if(!in_array($key, $valid_keys))
        {
            throw new Exception('The key ' . $key . ' is not valid', 101);
        }

        if(is_null($mdObject))
        {
            throw new Exception('you have to set an mdObject in mdMediaManager::getInstance()', 100);
        }
        else
        {
            $instance           = new mdMediaManager();
            $instance->mdObject = $mdObject;
            $instance->key      = $key;
            return $instance;
        }
    }

    public function  __construct()
    {
    }

    /**
     * Carga los objetos del album $album
     * Si $album es NULL carga todos los albums
     *
     * @param <string> $album
     * @param <array> $options,
     *      Opciones:
     *          "order" => "ID" | "PRIORITY"
     * @return <mdMediaManager>
     */
    public function load($album = NULL, $options = array())
    {
        try
        {
            $this->filter = ((empty ($options) || !array_key_exists("order", $options)) ? mdMediaManager::MD_FILTER_PRIORITY : $options["order"]);

            if(is_null($album))
            {
                //Cargo todos los albums
                $mdMediaAlbums = $this->mdObject->retrieveMdMedia()->retrieveAlbums($this->key);
                $this->count_albums = count($mdMediaAlbums);
                $counter_comments = 0;

                foreach($mdMediaAlbums as $mdAlbum)
                {

                    $this->hashMap[$mdAlbum['title']]               = (int)$mdAlbum['id'];
                    $this->albums[(int)$mdAlbum['id']]              = new stdClass();
                    $this->albums[(int)$mdAlbum['id']]->id          = (int)$mdAlbum['id'];
                    try
                    {
                        $this->albums[(int)$mdAlbum['id']]->avatarId= (is_null($mdAlbum['md_media_content_id']) ? NULL : (int)$mdAlbum['md_media_content_id']);
                        $this->albums[(int)$mdAlbum['id']]->avatar  = NULL;
                        if($this->albums[(int)$mdAlbum['id']]->avatarId != NULL)
                        {
                            $this->albums[(int)$mdAlbum['id']]->avatar = mdMediaAlbum::retrieveMdContentConcrete((int)$mdAlbum['md_media_content_id']);
                        }
                    }catch(Exception $e){
                        $this->albums[(int)$mdAlbum['id']]->avatar  = NULL;
                    }
                    $this->albums[(int)$mdAlbum['id']]->title       = $mdAlbum['title'];
                    $this->albums[(int)$mdAlbum['id']]->description = $mdAlbum['description'];
                    $this->albums[(int)$mdAlbum['id']]->contentIds  = array();
                    $this->albums[(int)$mdAlbum['id']]->count       = mysqlMdMediaAlbum::retrieveCountCache($mdAlbum['id']);
                    if( sfConfig::get( 'sf_plugins_media_commentable', false ) )
                    {
                        $this->albums[(int)$mdAlbum['id']]->count_comments = mdCommentsHandler::retrieveCountComments("mdMediaAlbum", (int)$mdAlbum['id']);
                        $counter_comments+= $this->albums[(int)$mdAlbum['id']]->count_comments;
                    }
                    $this->albums[(int)$mdAlbum['id']]->contents    = array();

                    //Sino se carga a demanda, cargo todos los objetos para cada album
                    if(!self::$LOAD_ON_DEMAND_CONTENT)
                    {
                        $mdItemIds = MdMediaAlbum::retrieveContentIds($mdAlbum['id'], $this->filter);
                        $this->albums[(int)$mdAlbum['id']]->contentIds = $mdItemIds;
                        $limit = (!is_null(sfConfig::get('app_objectsByPage'))) ? sfConfig::get('app_objectsByPage') : self::ITEMS_BY_PAGE;
                        $this->albums[(int)$mdAlbum['id']]->contents = $this->loadItems($mdAlbum['title'], 1, $limit);
                    }
                }
                $this->count_comments_albums = $counter_comments;
            }
            else
            {
//                Doctrine::getTable('mdMediaAlbum')->findAlbums($this->mdObject->retrieveMdMedia()->getId(), mdMediaManager::IMAGES);
                //Cargo los datos del album $album
                $mdAlbum = Doctrine::getTable('mdMediaAlbum')->retrieveAlbum($this->mdObject->retrieveMdMedia()->getId(), $album);

                if($mdAlbum)
                {
                    $this->hashMap[$mdAlbum['title']]               = (int)$mdAlbum['id'];
                    $this->albums[(int)$mdAlbum['id']]              = new stdClass();
                    $this->albums[(int)$mdAlbum['id']]->id          = (int)$mdAlbum['id'];
                    try
                    {
                        $this->albums[(int)$mdAlbum['id']]->avatarId= (is_null($mdAlbum['md_media_content_id']) ? NULL : (int)$mdAlbum['md_media_content_id']);
                        $this->albums[(int)$mdAlbum['id']]->avatar  = NULL;
                        if($this->albums[(int)$mdAlbum['id']]->avatarId != NULL)
                        {
                            $this->albums[(int)$mdAlbum['id']]->avatar = MdMediaAlbum::retrieveMdContentConcrete((int)$mdAlbum['md_media_content_id']);
                        }
                    }catch(Exception $e){
                        $this->albums[(int)$mdAlbum['id']]->avatar  = NULL;
                    }
                    $this->albums[(int)$mdAlbum['id']]->title       = $mdAlbum['title'];
                    $this->albums[(int)$mdAlbum['id']]->description = $mdAlbum['description'];
                    $this->albums[(int)$mdAlbum['id']]->contentIds  = array();
                    $this->albums[(int)$mdAlbum['id']]->count       = mysqlMdMediaAlbum::retrieveCountCache($mdAlbum['id']);
                    if( sfConfig::get( 'sf_plugins_media_commentable', false ) )
                    {
                        $this->albums[(int)$mdAlbum['id']]->count_comments = mdCommentsHandler::retrieveCountComments("mdMediaAlbum", (int)$mdAlbum['id']);
                    }
                    $this->albums[(int)$mdAlbum['id']]->contents    = array();

                    //Sino se carga a demanda, cargo todos los objetos para el album
                    if(!self::$LOAD_ON_DEMAND_CONTENT)
                    {
                        $mdItemIds = MdMediaAlbum::retrieveContentIds($mdAlbum['id'], $this->filter);
                        $this->albums[(int)$mdAlbum['id']]->contentIds = $mdItemIds;
                        $limit = (!is_null(sfConfig::get('app_objectsByPage')) ? sfConfig::get('app_objectsByPage') : self::ITEMS_BY_PAGE);
                        $this->albums[(int)$mdAlbum['id']]->contents = $this->loadItems($mdAlbum['title'], 1, $limit);
                    }
                    $this->album_loaded = $mdAlbum['title'];
                }
                else
                {
                    throw new Exception('The album ' . $album . ' not exist for the object of id ' . $this->mdObject->getId(), 103);
                }
            }
        }
        catch(Exception $e)
        {
            throw $e;
        }

        return $this;
    }

    public function getMdObject()
    {
        return $this->mdObject;
    }

    /**
     *
     * Devuelve el avatar del album $album
     * Si $album es NULL entonces devuelve el avatar del
     * album por default si lo tiene
     *
     * @param <string> $album
     * @param <mdObject> $object
     * @return <string>
     */
    public function getAvatar($album = NULL, $object = false)
    {
        if(is_null($album))
        {
            //Si cargue todos los albums
            if(is_null($this->album_loaded))
            {
                if(array_key_exists(mdMedia::$default, $this->hashMap))
                {
                    $avatar = $this->albums[$this->hashMap[MdMedia::$default]]->avatar;
                }
                else
                {
                    throw new Exception('The album ' . mdMedia::$default . ' is not loaded', 102);
                }
            }
            //Si cargue un album en particular
            else
            {
                $avatar = $this->albums[$this->hashMap[$this->album_loaded]]->avatar;
            }
        }
        else
        {
            if(array_key_exists($album, $this->hashMap))
            {
                $avatar = $this->albums[$this->hashMap[$album]]->avatar;
            }
            else
            {
                throw new Exception('The album ' . $album . ' is not loaded', 102);
            }
        }

        if($object) return $avatar;

        if(is_null($avatar)) return mdMediaAlbum::AVATAR_ALBUM_DEFAULT;
        
        return $avatar->getSource();
    }

    public function getAvatarUrl($album = NULL, $options = array('width' => 46,'height' => 46))
    {
        if(is_null($album))
        {
            //Si cargue todos los albums
            if(is_null($this->album_loaded))
            {
                if(array_key_exists(mdMedia::$default, $this->hashMap))
                {
                    $avatar = $this->albums[$this->hashMap[MdMedia::$default]]->avatar;
                }
                else
                {
                    throw new Exception('The album ' . mdMedia::$default . ' is not loaded', 102);
                }
            }
            //Si cargue un album en particular
            else
            {
                $avatar = $this->albums[$this->hashMap[$this->album_loaded]]->avatar;
            }
        }
        else
        {
            if(array_key_exists($album, $this->hashMap))
            {
                $avatar = $this->albums[$this->hashMap[$album]]->avatar;
            }
            else
            {
                throw new Exception('The album ' . $album . ' is not loaded', 102);
            }
        }

        if(is_null($avatar)) return mdMediaAlbum::AVATAR_ALBUM_DEFAULT;
        
        if($avatar->getObjectClass() == 'mdMediaVideo'){
            return $avatar->getAvatarVideo($options);
        }
        return $avatar->getUrl($options);
    }

    /**
     * Devuelve la cantidad de objetos que tiene el album $album
     * Si $album es NULL entonces devuelve la cantidad de objetos del
     * album default
     *
     * @param <string> $album
     */
    public function getCount($album = NULL)
    {
        if(is_null($album))
        {
            //Si cargue todos los albums
            if(is_null($this->album_loaded))
            {
                if(array_key_exists(mdMedia::$default, $this->hashMap))
                {
                    return $this->albums[$this->hashMap[MdMedia::$default]]->count;
                }
                else
                {
                    throw new Exception('The album ' . mdMedia::$default . ' is not loaded', 102);
                }
            }
            //Si cargue un album en particular
            else
            {
                return $this->albums[$this->hashMap[$this->album_loaded]]->count;
            }
        }
        else
        {
            if(array_key_exists($album, $this->hashMap))
            {
                return $this->albums[$this->hashMap[$album]]->count;
            }
            else
            {
                throw new Exception('The album ' . $album . ' is not loaded', 102);
            }
        }
    }

    /**
     * Devuelve la cantidad de comentarios que tiene el album $album
     * Si $album es NULL entonces devuelve la cantidad de comentarios del
     * album default
     *
     * @param <string> $album
     */
    public function getCountComments($album = NULL)
    {
        if(is_null($album))
        {
            //Si cargue todos los albums
            if(is_null($this->album_loaded))
            {
                if(array_key_exists(mdMedia::$default, $this->hashMap))
                {
                    return $this->albums[$this->hashMap[MdMedia::$default]]->count_comments;
                }
                else
                {
                    throw new Exception('The album ' . mdMedia::$default . ' is not loaded', 102);
                }
            }
            //Si cargue un album en particular
            else
            {
                return $this->albums[$this->hashMap[$this->album_loaded]]->count_comments;
            }
        }
        else
        {
            if(array_key_exists($album, $this->hashMap))
            {
                return $this->albums[$this->hashMap[$album]]->count_comments;
            }
            else
            {
                throw new Exception('The album ' . $album . ' is not loaded', 102);
            }
        }
    }

    /**
     * Devuelve el id del album $album
     * Si $album es NULL entonces devuelve el id del album por default
     *
     * @param <string> $album
     */
    public function getId($album = NULL)
    {
        if(is_null($album))
        {
            //Si cargue todos los albums
            if(is_null($this->album_loaded))
            {
                if(array_key_exists(mdMedia::$default, $this->hashMap))
                {
                    return $this->albums[$this->hashMap[mdMedia::$default]]->id;
                }
                else
                {
                    throw new Exception('The album ' . mdMedia::$default . ' is not loaded', 102);
                }
            }
            //Si cargue un album en particular
            else
            {
                return $this->albums[$this->hashMap[$this->album_loaded]]->id;
            }
        }
        else
        {
            if(array_key_exists($album, $this->hashMap))
            {
                return $this->albums[$this->hashMap[$album]]->id;
            }
            else
            {
                throw new Exception('The album ' . $album . ' is not loaded', 102);
            }
        }
    }

    /**
     * Devuelve la descripcion del album $album
     * Si $album es NULL entonces devuelve la descripcion del
     * album por default
     *
     * @param <string> $album
     */
    public function getDescription($album = NULL)
    {
        if(is_null($album))
        {
            //Si cargue todos los albums
            if(is_null($this->album_loaded))
            {
                if(array_key_exists(mdMedia::$default, $this->hashMap))
                {
                    return $this->albums[$this->hashMap[MdMedia::$default]]->description;
                }
                else
                {
                    throw new Exception('The album ' . mdMedia::$default . ' is not loaded', 102);
                }
            }
            //Si cargue un album en particular
            else
            {
                return $this->albums[$this->hashMap[$this->album_loaded]]->description;
            }
        }
        else
        {
            if(array_key_exists($album, $this->hashMap))
            {
                return $this->albums[$this->hashMap[$album]]->description;
            }
            else
            {
                throw new Exception('The album ' . $album . ' is not loaded', 102);
            }
        }
    }

    /**
     * Devuelve el nombre del album $album
     * Si $album es NULL entonces devuelve el nombre del album por default
     *
     * @param <string> $album
     */
    public function getTitle($album = NULL)
    {
        if(is_null($album))
        {
            //Si cargue todos los albums
            if(is_null($this->album_loaded))
            {
                if(array_key_exists(mdMedia::$default, $this->hashMap))
                {
                    return $this->albums[$this->hashMap[MdMedia::$default]]->title;
                }
                elseif(count($this->hashMap) > 0)
                {
                    $albums_key = array_keys($this->hashMap);
                    return $this->albums[$this->hashMap[$albums_key[0]]]->title;
                } else {
                    throw new Exception('The album ' . mdMedia::$default . ' is not loaded', 102);
                }
            }
            //Si cargue un album en particular
            else
            {
                return $this->albums[$this->hashMap[$this->album_loaded]]->title;
            }
        }
        else
        {
            if(array_key_exists($album, $this->hashMap))
            {
                return $this->albums[$this->hashMap[$album]]->title;
            }
            else
            {
                throw new Exception('The album ' . $album . ' is not loaded', 102);
            }
        }
    }

    /**
     *
     * @param <string> $album
     * @param <integer> $page
     * @param <integer> $limit
     * @return <array>
     */
    public function getItems($album = NULL, $page = 1, $limit = NULL)
    {
        try
        {
            if(is_null($album))
            {
                //Si cargue todos los albums
                if(is_null($this->album_loaded))
                {
                    if(array_key_exists(mdMedia::$default, $this->hashMap))
                    {
                        $album = MdMedia::$default;
                    }
                    else
                    {
                        throw new Exception('The album ' . mdMedia::$default . ' is not loaded', 102);
                    }
                }
                //Si cargue un album en particular
                else
                {
                    $album = $this->album_loaded;
                }
            }
            else
            {
                if(!array_key_exists($album, $this->hashMap))
                {
                    throw new Exception('The album ' . $album . ' is not loaded', 102);
                }
            }

            if(self::$LOAD_ON_DEMAND_CONTENT)
            {
                $mdItemIds = MdMediaAlbum::retrieveContentIds($this->hashMap[$album], $this->filter);
                $this->albums[$this->hashMap[$album]]->contentIds = $mdItemIds;
            }

            if(is_null($limit))
            {
                $limit = (!is_null(sfConfig::get('app_objectsByPage')) ? sfConfig::get('app_objectsByPage') : self::ITEMS_BY_PAGE);
            }

            $this->albums[$this->hashMap[$album]]->contents = $this->loadItems($album, $page, $limit);

            return $this->albums[$this->hashMap[$album]]->contents;
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    /**
     *
     * @param <string> $album
     * @param <integer> $page
     * @param <integer> $limit
     * @return <array>
     */
    public function getItemsIds($album = NULL, $page = 1, $limit = NULL)
    {
        try
        {
            if(is_null($album))
            {
                //Si cargue todos los albums
                if(is_null($this->album_loaded))
                {
                    if(array_key_exists(mdMedia::$default, $this->hashMap))
                    {
                        $album = MdMedia::$default;
                    }
                    else
                    {
                        throw new Exception('The album ' . mdMedia::$default . ' is not loaded', 102);
                    }
                }
                //Si cargue un album en particular
                else
                {
                    $album = $this->album_loaded;
                }
            }
            else
            {
                if(!array_key_exists($album, $this->hashMap))
                {
                    throw new Exception('The album ' . $album . ' is not loaded', 102);
                }
            }

            if(self::$LOAD_ON_DEMAND_CONTENT)
            {
                $mdItemIds = MdMediaAlbum::retrieveContentIds($this->hashMap[$album], $this->filter);
                $this->albums[$this->hashMap[$album]]->contentIds = $mdItemIds;
            }

            if(is_null($limit))
            {
                $limit = (!is_null(sfConfig::get('app_objectsByPage')) ? sfConfig::get('app_objectsByPage') : self::ITEMS_BY_PAGE);
            }

            return $this->albums[$this->hashMap[$album]]->contentIds;
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    /**
     * Devuelve todos los albums siempre que se hayan cargados todos en el load
     * sino devuelve el album que se ha cargado en el load
     * 
     * @param <string> $album
     * @return <array>
     */
    public function getAlbums($album = NULL)
    {
        if(is_null($album))
        {
            //Si cargue todos los albums
            if(is_null($this->album_loaded))
            {
                return $this->albums;
            }
            //Si cargue un album en particular
            else
            {
                return $this->albums[$this->hashMap[$this->album_loaded]];
            }
        }
        else
        {
            if(array_key_exists($album, $this->hashMap))
            {
                return $this->albums[$this->hashMap[$album]];
            }
            else
            {
                throw new Exception('The album ' . $album . ' is not loaded', 102);
            }
        }
    }

    /**
     * @return <integer>
     */
    public function getCountAlbums()
    {
        //Si no cargue todos los albums
        if(!is_null($this->album_loaded))
        {
            $mdMediaAlbums = $this->mdObject->retrieveMdMedia()->retrieveAlbums($this->key);
            $this->count_albums = count($mdMediaAlbums);
        }

        return $this->count_albums;
    }

    /**
     * Carga los el contenido de los items de el album $album
     * pre: los contentIds tienen que estar cargados previamente
     *
     * @param <integer> $page
     * @param <integer> $limit
     * @return <array>
     */
    private function loadItems($album, $page, $limit)
    {
        $contentIds = array();
        $array_contents = array_chunk($this->albums[$this->hashMap[$album]]->contentIds, $limit);

        if(array_key_exists(($page-1), $array_contents))
        {
            $contentIds = $array_contents[$page-1];
        }
        else
        {
            return $contentIds;
        }

        $itemsOrdered = MdMediaAlbum::retrieveItems($contentIds, $this->key);

        switch ($this->filter){
            case mdMediaManager::MD_FILTER_PRIORITY:
                    usort($itemsOrdered, "cmpMdMediaContentPriority");
                break;
            case mdMediaManager::MD_FILTER_ID:
                    usort($itemsOrdered, "cmpMdMediaContentId");
                break;
        }

        return $itemsOrdered;
    }

    public function getKey(){
        return $this->key;
    }

    /**
     *
     * @param <string> $album
     * @return <boolean>
     */
    public function hasAlbum($album)
    {
        //Si cargue todos los albums
        if(is_null($this->album_loaded))
        {
            return array_key_exists($album, $this->hashMap);
        }
        //Si cargue un album en particular, hago la consulta
        else
        {
            return $this->mdObject->retrieveMdMedia()->hasAlbum($album);
        }
    }
    
    /**
     *
     * @param <string> $album
     * @return <boolean>
     */
    public function hasAvatar($album = NULL)
    {
        if(is_null($album))
        {
            //Si cargue todos los albums
            if(is_null($this->album_loaded))
            {
                if(array_key_exists(mdMedia::$default, $this->hashMap))
                {
                    $avatar = $this->albums[$this->hashMap[MdMedia::$default]]->avatar;
                }
                else
                {
                    throw new Exception('The album ' . mdMedia::$default . ' is not loaded', 102);
                }
            }
            //Si cargue un album en particular
            else
            {
                $avatar = $this->albums[$this->hashMap[$this->album_loaded]]->avatar;
            }
        }
        else
        {
            if(array_key_exists($album, $this->hashMap))
            {
                $avatar = $this->albums[$this->hashMap[$album]]->avatar;
            }
            else
            {
                throw new Exception('The album ' . $album . ' is not loaded', 102);
            }
        }

        return ($avatar !== NULL);
    }    

    /**
     * Crea un album y lo devuelve
     *
     * @param <array> $options
     *  El array debe estar formado de la siguiente manera:
     *  $options = array(  "title" => $title,
     *                    "description" => $description,
     *                    "type" => $type);
     *  type se obtiene de los tipos estaticos definidos en mdMediaManager
     *  mdMediaManager::VIDEOS, mdMediaManager::MIXED, mdMediaManager::FILES, mdMediaManager::IMAGES.
     * @return <mdMediaAlbum>
     */
    public function createAlbum($options = array())
    {
        if($this->hasAlbum($options['title']))
        {
            throw new Exception("The album " . $options['title'] . " already exist for object of id " . $this->mdObject->getId() . " and classname " . $this->mdObject->getObjectClass() , 200);
        }
        else
        {
            return $this->mdObject->retrieveMdMedia()->createAlbum($options);
            //Borro el cache APC correspondiente
            //update local collection album
            //return $album;
        }
    }

    public function getCountCommentsAlbums()
    {
        if( !sfConfig::get( 'sf_plugins_media_commentable', false ) )
        {
            throw new Exception("sf_plugins_media_commentable not available in settings configuration", 111);
        }

        if(is_null($this->count_comments_albums))
        {
            if(!is_null($this->album_loaded))
            {
                $counter = 0;
                $mdMediaAlbums = $this->mdObject->retrieveMdMedia()->retrieveAlbums($this->key);
                foreach($mdMediaAlbums as $album)
                {
                    $counter+= mdCommentsHandler::retrieveCountComments("mdMediaAlbum", $album->id);
                }
            }
            else
            {
                throw new Exception("something is bad in load function", 112);
            }

            $this->count_comments_albums = $counter;
        }

        return $this->count_comments_albums;
    }
}

function cmpMdMediaContentPriority($obj1, $obj2)
{
    if(  $obj1->retrievePriority() ==  $obj2->retrievePriority() ){ return 0 ; }
    return ($obj1->retrievePriority() < $obj2->retrievePriority()) ? -1 : 1;
}

function cmpMdMediaContentId($obj1, $obj2)
{
    if(  $obj1->getId() ==  $obj2->getId() ){ return 0 ; }
    return ($obj1->getId() < $obj2->getId()) ? 1 : -1;
}
