<?php

/**
 * mdMediaContentAdmin actions.
 *
 * @package    plugins
 * @subpackage mdMediaDoctrinePlugin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdMediaContentAdminActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('default', 'module');
    }

    /**
     * @param sfWebRequest $request
     * (int)    object_id           Identificador del objeto dueño del contenido
     * (string) object_class_name   Nombre de la clase del objeto dueño del contenido
     * (string) content_class       Nombre de la clase del contenido a borrar
     * (int)    content_id          Identificador del contenido a borrar
     * (int)    album_id            Identificador del album
     */
    public function executeChangeAvatar(sfWebRequest $request)
    {
        try
        {
            $mdObject = Doctrine::getTable($request->getParameter('object_class_name'))->find($request->getParameter('object_id'));

            $mdMediaAlbumId = (int)$request->getParameter('album_id');

            $mdMediaAlbum = Doctrine::getTable('mdMediaAlbum')->find($mdMediaAlbumId);

            //Obtenemos el mediaContentConcrete
            $mdMediaConcrete = Doctrine::getTable($request->getParameter('content_class'))->retrieveObject($request->getParameter('content_id'));

            //Obtenemos el mdMediaContent
            $mdMediaContent = $mdMediaConcrete->retrieveMdMediaContent();
            
            $mdMediaAlbum->changeAvatar($mdMediaContent->getId());

            // Armamos la salida
            $manager = mdMediaManager::getInstance(mdMediaManager::MIXED, $mdObject)->load($mdMediaAlbumId);

            return $this->renderText( json_encode(array(
                                                   'response' => 'OK',
                                                    'options' => array(
                                                                    'avatarUrl' => $manager->getAvatarUrl($mdMediaAlbum->getTitle(), array(mdWebOptions::WIDTH => 163, mdWebOptions::HEIGHT => 163, mdWebOptions::EXACT_DIMENTIONS => true, mdWebOptions::CODE => mdWebCodes::RESIZE)) ))));
        }
        catch(Exception $e)
        {
            return $this->renderText( json_encode(array('response' => 'ERROR', 'error' => $e->getMessage())));
        }
    }

    /**
     * @param sfWebRequest $request
     * (int) content_id  Identificador del contenido a borrar
     */
    public function executeRemoveContent(sfWebRequest $request)
    {
        try
        {
            //Obtenemos contenido
            //$mdMediaContent = Doctrine::getTable('mdMediaContent')->retrieveByPk($request->getParameter('content_id'));

            //Obtenemos el objeto concreto
            //$mdMediaContentConcrete = $mdMediaContent->retrieveObject();

            $mdMediaContentConcrete = Doctrine::getTable($request->getParameter('object_class'))->find($request->getParameter('object_id'));
            //Eliminamos
            $mdMediaContentConcrete->delete();

        }catch (Exception $e){

            return $this->renderText( json_encode(array('response' => 'ERROR', 'message' => $e->getMessage())));

        }

        return $this->renderText( json_encode(array('response' => 'OK')));
    }

    /**
     * @param sfWebRequest $request
     * (int)    object_id           Identificador del objeto dueño del contenido
     * (string) object_class_name   Nombre de la clase del objeto dueño del contenido
     * (int)    album_id            Identificador del album
     */
    public function executeUpdateContentSlider(sfWebRequest $request)
    {
        //Obtenemos el dueño
        $mdObject = Doctrine::getTable($request->getParameter('object_class_name'))->find($request->getParameter('object_id'));

        //Obtenemos albumId
        $album_id = $request->getParameter('album_id');
        if($album_id == 'undefined' || empty($album_id)){
            $album_id = NULL;
        }else{
            $album_id = (int)$request->getParameter('album_id');
        }

        $manager = mdMediaManager::getInstance(mdMediaManager::MIXED, $mdObject)->load($album_id);

        return $this->renderText(json_encode(array('content' => $this->getPartial('mdMediaContentAdmin/album_view', array('manager' => $manager, 'object' => $mdObject)))));
    }

    /**
     * @param sfWebRequest $request
     * (int)    object_id           Identificador del objeto dueño del contenido
     * (string) object_class_name   Nombre de la clase del objeto dueño del contenido
     */
    public function executeUpdateContentAlbums(sfWebRequest $request)
    {
        //Obtenemos el dueño
        $mdObject = Doctrine::getTable($request->getParameter('object_class_name'))->find($request->getParameter('object_id'));

        //$manager = mdMediaManager::getInstance($request->getParameter('album_type', mdMediaManager::IMAGES), $mdObject)->load();
        //return $this->renderText($this->getPartial('mdMediaContentAdmin/content_albums', array('manager' => $manager, 'object' => $mdObject)));
        return $this->renderComponent('mdMediaContentAdmin', 'showAlbums', array('object' => $mdObject));

    }


    public function executeUploader(sfWebRequest $request)
    {
        $this->objectId = $request->getParameter('a', 0);
        $this->objectClass = $request->getParameter('c', '');
        $this->album_id = $request->getParameter('i', '');

        $type = $request->getParameter('t', mdMediaManager::MIXED);
        try
        {
            $mdObject = Doctrine::getTable($this->objectClass)->find($this->objectId);
            mdMediaManager::$LOAD_ON_DEMAND_CONTENT = true;
            $this->manager =  mdMediaManager::getInstance($type, $mdObject)->load();

            if($this->album_id == '')
            {
                if($this->manager->getCountAlbums() > 1){
                    $albums = $this->manager->getAlbums();
                    $album = array_shift($albums);
                    $this->album_id = $album->id;
                }
            }
        } catch(Exception $e){
            print_r($e->getMessage());
        }

        $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdMediaContentAdmin', 'clean.php').'/clean');
    }
    
    public function executeUploaderEmbebidos(sfWebRequest $request)
    {      
        // BUG SINO TENGO ALBUMS TIRA ERROR
        $this->objectId = $request->getParameter('a', 0);
        $this->objectClass = $request->getParameter('c', '');
        $this->albumId = $request->getParameter('i', '');

        $type = $request->getParameter('t', mdMediaManager::MIXED);
        try
        {
            $mdObject = Doctrine::getTable($this->objectClass)->find($this->objectId);
            mdMediaManager::$LOAD_ON_DEMAND_CONTENT = true;
            $this->manager =  mdMediaManager::getInstance($type, $mdObject)->load();

            if($this->albumId == '')
            {
                if($this->manager->getCountAlbums() > 1){
                    $albums = $this->manager->getAlbums();
                    $album = array_shift($albums);
                    $this->albumId = $album->id;
                }
            }
        } catch(Exception $e){
            print_r($e->getMessage());
        }
        $this->forms = array();
        foreach(sfConfig::get('sf_plugins_media_videos_embebed_types') as $type)
        {
          $class = 'mdMedia' . ucfirst($type) . 'VideoForm';
          $this->forms[$type] = new $class();
        }

        $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdMediaContentAdmin', 'clean.php').'/clean');      
    }
    
    public function executeProcessEmbededVideo(sfWebRequest $request)
    {
      // Obtenemos los parametros enviados desde el formulario
      $postParameters = $request->getPostParameters();
      $albumId = $postParameters["albumId"];
      $objectId = $postParameters["objectId"];
      $objectClass = $postParameters["objectClass"];
      $type = $postParameters['mdVideoType'];

      try{
        
        if(!$albumId)
        {

          $object = Doctrine::getTable($objectClass)->find($objectId);
          $instance = mdMediaManager::getInstance(mdMediaManager::MIXED, $object)->load();
          if(!$instance->hasAlbum("default"))
          {
            $options = array('title' => "default", 'description' => 'Este album tendra las imagenes para mostrar.', 'type' => mdMediaManager::MIXED);
            $mdMediaAlbum = $instance->createAlbum($options);
            $albumId = $mdMediaAlbum->getId();

          }
          else
          {
            throw new Exception("Error de javascript", 192);
          }
        }
        switch ($type)
        {
          case mdVideosTypes::YOUTUBE:
              $response = $this->saveYoutube($postParameters, $albumId);
            break;
          case mdVideosTypes::VIMEO:
              $response = $this->saveVimeo($postParameters, $albumId);
            break;
          case mdVideosTypes::ISSUU:
              $response = $this->saveIssuu($postParameters, $albumId);
            break;
          default: 
              $response = array('response' => false);
            break;
        }

        if($response['response'])
        {
          $body = $this->getPartial($type . "Upload", array('form'=> $response['form'], 'albumId' => $albumId, 'objectId' => $objectId, 'objectClass' => $objectClass));
          return $this->renderText(mdBasicFunction::basic_json_response(true, array('body' => $body, 'object_id' => $objectId, 'object_class_name' => $objectClass)));
        }
        else
        {
          $body = $this->getPartial($type . "Upload", array('form'=> $response['form'], 'albumId' => $albumId, 'objectId' => $objectId, 'objectClass' => $objectClass));
          return $this->renderText(mdBasicFunction::basic_json_response(false, array('body' => $body)));
        }
        
      }catch(Exception $e){

          return $this->renderText(mdBasicFunction::basic_json_response(false, array('message' => $e->getMessage())));        
        
      }
    }
    
    private function saveYoutube($postParameters, $album_id)
    {
      $form = new mdMediaYoutubeVideoForm();
      $params = $postParameters[$form->getName()];
      $form->bind($params);
      $response = array();
      
      if($form->isValid())
      {
        $mdYoutubeVideo = new mdMediaYoutubeVideo();
        $mdYoutubeVideo->setMdUserIdTmp ( $this->getUser()->getMdUserId() );
        $mdYoutubeVideo->setSrc($params["src"]);
        $mdYoutubeVideo->setDescription($params["description"]);
        $mdYoutubeVideo->save();
        $album = Doctrine::getTable("mdMediaAlbum")->find($album_id);
        $album->addContent($mdYoutubeVideo);
        $response['response'] = true;
      }
      else
      {
        $response['response'] = false;
      }
      
      $response['form'] = $form;
      
      return $response;
    }
    
    private function saveVimeo($postParameters, $album_id)
    {
      $form = new mdMediaVimeoVideoForm();
      $params = $postParameters[$form->getName()];
      $form->bind($params);
      
      if($form->isValid())
      {
        $mdVimeoVideo = new mdMediaVimeoVideo();
        $mdVimeoVideo->setMdUserIdTmp ( $this->getUser()->getMdUserId() );
        $mdVimeoVideo->setVimeoUrl($params["vimeo_url"]);
        $mdVimeoVideo->save();
        $album = Doctrine::getTable("mdMediaAlbum")->find($album_id);
        $album->addContent($mdVimeoVideo);
        $response['response'] = true;
      }
      else
      {
        $response['response'] = false;
      }
      
      $response['form'] = $form;
      
      return $response;   
    }
    
    private function saveIssuu($postParameters, $album_id)
    {
      $form = new mdMediaIssuuVideoForm();
      $params = $postParameters[$form->getName()];
      $form->bind($params);
      $response = array();
      
      if($form->isValid())
      {
        $mdIssuuVideo = new mdMediaIssuuVideo();
        $mdIssuuVideo->setMdUserIdTmp ( $this->getUser()->getMdUserId() );
        $mdIssuuVideo->setEmbedCode($params["embed_code"]);
        $mdIssuuVideo->save();
        $album = Doctrine::getTable("mdMediaAlbum")->find($album_id);
        $album->addContent($mdIssuuVideo);
        $response['response'] = true;
      }
      else
      {
        $response['response'] = false;
      }
      
      $response['form'] = $form;
      
      return $response;
    }
  
    public function executeUploadContent(sfWebRequest $request){
    	if(!$this->getUser()->isAuthenticated())
        {
            throw new Exception('No esta autentificado', 100);
    	}

        try
        {
            $mdMediaContentConcrete = $this->upload($_FILES, $request->getParameter('objClass'), $request->getParameter('objId'), $request->getParameter('album_id', ''), $request->getParameter('filename'));
            $this->setLayout ( false );
            $url = $mdMediaContentConcrete->getObjectUrl(array('width'=>$request->getParameter('w'),'height'=>$request->getParameter('h')));

            sfConfig::set('sf_web_debug', false);
            $this->setLayout ( false );

            return $this->renderText( $url . '|' . $mdMediaContentConcrete->retrieveMdMediaContent()->getId());

        } catch (Exception $e) {
            sfContext::getInstance()->getLogger()->log('>>>>>>> ' . $e->getMessage());
            echo $e->getMessage();            
        }
    }

    public function executeUploadBasicContent(sfWebRequest $request){
    	if(!$this->getUser()->isAuthenticated())
        {
            throw new Exception('No esta autentificado', 100);
    	}

        try
        {

            $this->upload($_FILES, $request->getParameter('objClass'), $request->getParameter('objId'), $request->getParameter('album_id', ''), $request->getParameter('filename'));

            return $this->renderText( "<script>parent.endUpload(" . $request->getParameter('objId') . ",'" . $request->getParameter('objClass') . "');</script>");

        }catch(Exception $e){

            return $this->renderText( "<script>parent.endUpload(" . $request->getParameter('objId') . ",'" . $request->getParameter('objClass') . "');</script>" . $e->getMessage());

        }

    }

    private function upload($FILES, $object_class, $object_id, $album_id, $filename){
        try
        {

            $mdObject = Doctrine::getTable ( $object_class )->find($object_id);

            $path = $mdObject->getPath();

            $file_name = MdFileHandler::upload($FILES, sfConfig::get('sf_upload_dir') . $path);

            //Obtenemos el usuario logueado
						// si es un usuario sin base de datos, uso el id 1
						if(get_parent_class($this->getUser()) == 'mdSecurityFileUser')
							$mdUser = 0;
						else
            	$mdUser = $this->getUser()->getMdPassport()->getMdUser();

            $upload_name = "upload";
            
            $path_info = pathinfo ( $FILES [$upload_name] ['name'] );
            $file_extension = $path_info ["extension"];
            $name = $filename;
            $album_id = (int)$album_id;

            $options = array('name' => $name,'filename' => $file_name, 'type' => $file_extension, 'album' => $album_id);

            //Damos de alta las imagenes del usuario $mdUser al contenido $mdObject salvado anteriormente
            $mdMedia = $mdObject->retrieveMdMedia();
            $mdMediaContentConcrete = $mdMedia->upload($mdUser, $mdObject , $options);

            if($album_id == 0)
            {
                $album = Doctrine::getTable('mdMediaAlbum')->retrieveAlbum($mdMedia->getId(), mdMedia::$default);
                $album_id = (int)$album['id'];
            }

            $this->dispatcher->notify(new sfEvent($this, $this->retrieveSignal($file_extension), array('contents' => array($mdMediaContentConcrete->retrieveMdMediaContent()), 'album_id' => $album_id)));

            return $mdMediaContentConcrete;
            
        }catch(Exception $e){

            throw $e;
        }
    }

    

    public function executeUploaderVideoAvatar(sfWebRequest $request)
    {
        try {
            $this->mediaConcrete = Doctrine::getTable('mdMediaVideo')->find($request->getParameter('videoId'));

            $path = MdFileHandler::checkPathFormat(PluginmdMediaVideo::PATH);
            
            $file_name = MdFileHandler::upload($_FILES, $path);

            try{
                $avatar_path = MDVIDEOAVATAR_PATH .'/';
                MdFileHandler::delete($this->mediaConcrete->getAvatar(), $avatar_path);
            } catch(Exception $e){

            }

            
            $this->mediaConcrete->setAvatar($file_name);
            $this->mediaConcrete->save();

//            $image = new mdImageFile($path . $file_name);
//            return mdWebImage::getUrl($image, array('width' => $w, 'height' => $h));
        } catch (Exception $e) {
            $this->showUploader = 1;
            $this->setTemplate('uploaderAvatarVideoIframe');
            $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdMediaContentAdmin', 'clean.php').'/clean');
            //return $this->renderText(json_encode(array('response'=> 'ERROR', 'error' => $e->getMessage())));
        }
        $this->showUploader = 1;
        $this->setTemplate('uploaderAvatarVideoIframe');
        $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdMediaContentAdmin', 'clean.php').'/clean');
        
    }


    public function executeEditMedia(sfWebRequest $request){
        $media_concrete_id = $request->getParameter('id');
        $media_concrete_class = $request->getParameter('object');
        $ownerClass = $request->getParameter('ownerClass', '');
        $ownerId = $request->getParameter('ownerId', '');

        $mediaConcrete = Doctrine::getTable($media_concrete_class)->find($media_concrete_id);

        if($media_concrete_class == 'mdMediaImage'){
            $mediaForm = new mdMediaImageForm($mediaConcrete);

        } else if($media_concrete_class == 'mdMediaFile'){
            $mediaForm = new mdMediaFileForm($mediaConcrete);
        } else if($media_concrete_class == 'mdMediaVideo'){
            $mediaForm = new mdMediaVideoForm($mediaConcrete);
        }



        return $this->renderPartial('mdMediaContentAdmin/edit_media', array('mediaConcrete' => $mediaConcrete, 'form' => $mediaForm, 'ownerClass' => $ownerClass, 'ownerId' => $ownerId));
        
    }

    public function executeProcessMedia(sfWebRequest $request){
        $salida = array();

        if($request->hasParameter('md_media_image')){
            $mdMediaImage = $request->getParameter('md_media_image');
            $mediaConcrete = Doctrine::getTable('mdMediaImage')->find($mdMediaImage['id']);
            $mediaForm = new mdMediaImageForm($mediaConcrete);

            $mediaForm->bind($request->getParameter($mediaForm->getName()), $request->getFiles($mediaForm->getName()));

            if($mediaForm->isValid()){
                $mediaForm->save();
                $salida['response'] = 'OK';
                
            } else {
                $salida['response'] = 'NOK';
                $salida['error'] = $mediaForm->getFormattedErrors();
                
            }


        } else if($request->hasParameter('md_media_file')){
            $mdMediaFile = $request->getParameter('md_media_file');
            $mediaConcrete = Doctrine::getTable('mdMediaFile')->find($mdMediaFile['id']);
            $mediaForm = new mdMediaFileForm($mediaConcrete);

            $mediaForm->bind($request->getParameter($mediaForm->getName()), $request->getFiles($mediaForm->getName()));

            if($mediaForm->isValid()){
                $mediaForm->save();
                $salida['response'] = 'OK';
                
            } else {
                $salida['response'] = 'NOK';
                $salida['error'] = $mediaForm->getFormattedErrors();
            }

        } else if($request->hasParameter('md_media_video')){
            $mdMediaFile = $request->getParameter('md_media_video');
            $mediaConcrete = Doctrine::getTable('mdMediaVideo')->find($mdMediaFile['id']);
            $mediaForm = new mdMediaVideoForm($mediaConcrete);

            $mediaForm->bind($request->getParameter($mediaForm->getName()), $request->getFiles($mediaForm->getName()));

            if($mediaForm->isValid()){
                $mediaForm->save();
                $salida['response'] = 'OK';

            } else {
                $salida['response'] = 'NOK';
                $salida['error'] = $mediaForm->getFormattedErrors();
            }

        }
        
        return $this->renderText(json_encode($salida));
    }

    public function executeUploaderAvatarVideoIframe(sfWebRequest $request){
        $this->mediaConcrete = Doctrine::getTable('mdMediaVideo')->find($request->getParameter('id'));

        $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdMediaContentAdmin', 'clean.php').'/clean');
    }
    
    public function executeAllMediaContent(sfWebRequest $request){
        $this->forward404Unless($object_id = $request->getParameter('object_id'));
        $this->forward404Unless($object_class = $request->getParameter('object_class'));
        
        $object = Doctrine::getTable($object_class)->find($object_id);
        
        $this->forward404Unless($album = $request->getParameter('album'));
      
        $this->manager = mdMediaManager::getInstance(mdMediaManager::MIXED, $object)->load($album);
        $this->media = $this->manager->getItems();
        $this->albumId = $this->manager->getId($album);
        
        
        
    }

    public function executeSetAlbumPriorities(sfWebRequest $request){
        $priorities = $request->getParameter('priorities');
        $albumId = $request->getParameter('albumId');

        /*
         * Datos:
         * - Object class
         * - Content id
         */
        $data = explode(',', $priorities);
        $i = 1;
        foreach($data as $d){

            $datos = explode('_', $d);
            $update = Doctrine::getTable('mdMediaAlbumContent')->setPriorityToAlbum($datos[0], $datos[1], $i, $albumId);
        
            $i++;
        }

        return $this->renderText(json_encode(array('response' => 'OK')));
        
    }

    private function retrieveSignal($type)
    {
        if(in_array($type, mdMedia::$documentList))
        {
            //not implemented yet
            //return 'content.doc.create';
        }
        elseif(in_array($type, mdMedia::$videoList))
        {
            return 'content.video.create';
        }
        elseif(in_array($type, mdMedia::$imageList))
        {
            return 'content.image.create';
        }
        else
        {
            throw new Exception('feaature not implemented yet', 999);
        }
    }

    public function executeDownloadData(sfWebRequest $request)
    {
      $id = $request->getParameter("id");
      $class = $request->getParameter("class");
      $object = Doctrine::getTable($class)->find($id);

      if(!$object)
      {
          $this->redirect($this->getRequest()->getReferer());
      }
      $download = $object->getDownloadSource();
      $file_name = $object->getName();
      $file_extension = $object->getFileType();
      $this->output_file(sfConfig::get('sf_upload_dir').$download, $file_name, $file_extension);
      return $this->renderText("");
    }    

    function output_file($file, $name, $mime_type='') {
        /*
          This function takes a path to a file to output ($file),
          the filename that the browser will see ($name) and
          the MIME type of the file ($mime_type, optional).

          If you want to do something on download abort/finish,
          register_shutdown_function('function_name');
         */
        //print_r($file);
        if (!is_readable($file))
            die('File not found or inaccessible!');

        $size = filesize($file);
        $name = rawurldecode($name);

        /* Figure out the MIME type (if not specified) */
        $known_mime_types = array(
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "png" => "image/png",
            "jpeg" => "image/jpg",
            "jpg" => "image/jpg",
            "php" => "text/plain"
        );

        if ($mime_type == '') {
            $file_extension = strtolower(substr(strrchr($file, "."), 1));
            if (array_key_exists($file_extension, $known_mime_types)) {
                $mime_type = $known_mime_types[$file_extension];
            } else {
                $mime_type = "application/force-download";
            };
        };

        @ob_end_clean(); //turn off output buffering to decrease cpu usage
        // required for IE, otherwise Content-Disposition may be ignored
        if (ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');

        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');

        /* The three lines below basically make the
          download non-cacheable */
        header("Cache-control: private");
        header('Pragma: private');
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        // multipart-download and download resuming support
        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
            list($range) = explode(",", $range, 2);
            list($range, $range_end) = explode("-", $range);
            $range = intval($range);
            if (!$range_end) {
                $range_end = $size - 1;
            } else {
                $range_end = intval($range_end);
            }

            $new_length = $range_end - $range + 1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
        } else {
            $new_length = $size;
            header("Content-Length: " . $size);
        }

        /* output the file itself */
        $chunksize = 1 * (1024 * 1024); //you may want to change this
        $bytes_send = 0;
        if ($file = fopen($file, 'r')) {
            if (isset($_SERVER['HTTP_RANGE']))
                fseek($file, $range);

            while (!feof($file) &&
            (!connection_aborted()) &&
            ($bytes_send < $new_length)
            ) {
                $buffer = fread($file, $chunksize);
                print($buffer); //echo($buffer); // is also possible
                flush();
                $bytes_send += strlen($buffer);
            }
            fclose($file);
        } else
            die('Error - can not open file.');

        die();
    }
    
    /************* ESTO ES PARA MOSTRAR SOLO UNA MEDIA ***************/
    
    public function executeShowSingleMediaPartial(sfWebRequest $request)
    {
      $mdMediaContentId = $request->getParameter("mdMediaContentId");
      $mdMediaContent = Doctrine::getTable("mdMediaContent")->find($mdMediaContentId);
      return $this->renderPartial("mdMediaContentAdmin/show_single_media",
                array(
                  'mdMediaContent' => $mdMediaContent
                  )
                );
    }
    
    public function executeShowAlbumMediaPartial(sfWebRequest $request)
    {
      
      return $this->renderPartial("mdMediaContentAdmin/show_album_media", 
          array(
            'id'=>$request->getParameter("albumId"),
            'title'=>$request->getParameter("albumName")
            )
          );
    }
    
    public function executeProcessYoutube(sfWebRequest $request)
    {
      throw new Exception("Metodo deprecado", 123);
        try{
            $aux = new mdMediaYoutubeVideo();
            $aux->setMdUserIdTmp ( $this->getUser()->getMdUserId() );
            $this->form = new mdMediaYoutubeVideoForm($aux);
            $parameters = $request->getParameter($this->form->getName());
            $albumId = $request->getParameter("albumId");
            $this->form->bind($parameters);
            if($this->form->isValid())
            {
                $mdYoutubeVideo = $this->form->save();
                $album = Doctrine::getTable("mdMediaAlbum")->find($albumId);
                $album->addContent($mdYoutubeVideo);

                
                $mdMediaContent = $mdYoutubeVideo->retrieveMdMediaContent();
                
                $this->dispatcher->notify(new sfEvent($this, 'content.youtube.create', array('contents' => array($mdMediaContent))));
                
                return $this->renderText(mdBasicFunction::basic_json_response(true, array('albumId' => $albumId, 'object_id' => $album->getMdMedia()->getObjectId(), 'object_class_name' => $album->getMdMedia()->getObjectClassName())));
            }
            else
            {
                $body = $this->getPartial("mdMediaContentAdmin/youtubeUpload", array('form' => $this->form, 'albumId' => $albumId));
                return $this->renderText(mdBasicFunction::basic_json_response(false, array('albumId' => $albumId, 'errors'=>$this->form->getFormattedErrors(), 'body'=>$body)));
            } 
            
        }catch(Exception $e){
            
            return $this->renderText(mdBasicFunction::basic_json_response(false, array('error' => $e->getMessage())));
            
        }

        
    }    
}
