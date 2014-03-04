<?php

/**
* Manejador del traductor de templates
*/
class mdI18nTranslatorHandler
{
  /**
   * Lista de catalogos
   *
   * @var array
   */
  private $list_catalogues = array ();

  /**
   * Catalogo seleccionado
   *
   * @var string
   */
  private $selected_catalogue;

  /**
   * Lista de lenguages
   *
   * @var array
   */
  private $list_lang = array ();

  /**
   * Lenguage seleccionado
   *
   * @var string
   */
  private $selected_lang;

  /**
   * Lista de aplicaciones
   *
   * @var array
   */
  private $app_list=array();

  /**
   * Aplicación seleccionada
   *
   * @var string
   */	
  private $selected_app;

  /**
   * Lista de aplicaciones
   *
   * @var array
   */
  private $plugin_list=array();

  /**
   * Aplicación seleccionada
   *
   * @var string
   */
  private $selected_plugin;

  /**
   * MessageSource del i18n
   *
   * @var sfMessageSource
   */
  private $message_source;

  /**
   * Buscar palabra
   * 
   * @var string
   */
  private $filter_word;

  /**
   * Indica si se filtra tambien por target
   * 
   * @var boolean
   */
  private $filter_target = false;

  /**
   * Indica si es una busqueda
   * 
   * @var boolean
   */
  private $is_filter = false;

  private $i18n_dir;
	
  public function __construct(array $arguments, $plugins = false)
  {
    try {
      if(isset($arguments['selected_app']))
        $this->selected_app = $arguments['selected_app'];

      if(isset($arguments['selected_plugin']))
        $this->selected_plugin = $arguments['selected_plugin'];

      $this->i18n_dir = sfConfig::get ( 'sf_root_dir' ) . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR . $this->selected_app . DIRECTORY_SEPARATOR . 'i18n';

      if($plugins)
      {
        $this->i18n_dir = sfConfig::get ( 'sf_plugins_dir' ) . DIRECTORY_SEPARATOR . $this->selected_plugin . DIRECTORY_SEPARATOR . 'i18n';
      }

      if(isset($arguments['selected_lang']))
          $this->setSelectedLang($arguments['selected_lang']);

      if(isset($arguments['selected_catalogue']))
          $this->setSelectedCatalogue($arguments['selected_catalogue']);
      
      if(isset($arguments['restrict_to_applications']))
      {
          $this->loadApplications($arguments['restrict_to_applications']);
      }
      else
      {
          $this->loadApplications();
      }
      
      if(isset($arguments['search']) && !empty($arguments['search'])){
        $this->is_filter = true;
        $this->filter_word = $arguments['search'];
      }

      $this->filter_target = (isset($arguments['search_target']) && $arguments['search_target'] == 'true');        

      $this->loadPlugins();
      
      $this->loadCatalogues();
      
    } catch (Exception $e) {
      throw new Exception('crear archivos i18n para las aplicaciones activadas en settings, prueba correr el comando: php symfony i18n:extract backend en --auto-save | original message: ' . $e->getMessage());
    }
  }

  public function setSelectedLang($value)
  {
    $this->selected_lang = $value;
    return $this;
  }

  public function setSelectedCatalogue($value)
  {
    $this->selected_catalogue = $value;
    return $this;
  }

  public function getSelectedLang()
  {
    return $this->selected_lang;
  }

  public function getSelectedCatalogue()
  {
    return $this->selected_catalogue;
  }

  public function getSelectedApplication()
  {
    return $this->selected_app;
  }

  public function getSelectedPlugin()
  {
    return $this->selected_plugin;
  }

  public function getLangList()
  {
    return $this->list_lang;
  }

  public function getApplicationList()
  {
    return $this->app_list;
  }

  public function getPluginList()
  {
    return $this->plugin_list;
  }

  public function getCatalogueList()
  {
    return $this->list_catalogues;
  }

  public function getMessageSource()
  {
    if(!isset($this->message_source)){
            throw new Exception('No i18n files in application', 106);
    }
    return $this->message_source;
  }

  /**
   * Lee las mensajes del catalogo
   * se usa @var selected_lang y @var selected_catalogue
   *
   * @return void
   * @author maui .-
   **/
  private function loadMessages()
  {
    $this->message_source->setCulture ( $this->selected_lang );
    $this->message_source->load ( $this->selected_catalogue );
    return $this;
  }

  /**
   * devuelve los mensajes para los datos seleccionados
   *
   * @return void
   * @author maui .-
   **/
  public function getMessages()
  {
    $this->loadMessages();
    $translations = $this->message_source->read ();
    $filename = mdEleAdminI18nTool::getFileForCatalogue ( $this->selected_lang, $this->selected_catalogue );
    $messages = $translations [$filename];

    return $messages;
  }


  /**
   * Levanta las aplicaciones de la configuración
   * y carga la lista de aplicaciones.
   *
   * @return void
   * @author maui .-
   */
  private function loadApplications($restrict_to = array()){

    if(count($restrict_to) == 0)
    {
      $mdTranslatorSettings = sfConfig::get('sf_mdI18nTranslator', '');
      $apps = $mdTranslatorSettings['translate_apps'];
      foreach ($apps as $app){

          $this->app_list[$app] = $app;
      }
    }
    else
    {
      foreach ($restrict_to as $app){
          $this->app_list[$app] = $app;
      }
    }

    return $this;

  }

  /**
   * Levanta las aplicaciones de la configuración
   * y carga la lista de aplicaciones.
   *
   * @return void
   * @author maui .-
   */
  private function loadPlugins()
  {
    if(!is_null(sfConfig::get('app_i18n_plugins'))){
        $this->plugin_list = sfConfig::get('app_i18n_plugins');
    }else{
        $this->plugin_list = self::directoryList(sfConfig::get ( 'sf_plugins_dir' ));
    }
  }

  /**
   * Carga los diccionarios para la aplicación
   *
   * @return void
   * @author maui .-
   */

  private function loadCatalogues() {
    $i18n = sfContext::getInstance ()->getI18N ();

    // module is in modules dir, but i18n does not exists
    $i18n_dir = $this->i18n_dir;

    if (! is_dir ( $i18n_dir )) {
      unset ( $this->message_source );
      throw new Exception('not exist i18n dir', 101);
    }
    $this->message_source = $i18n->createMessageSource ( $i18n_dir );

    $catalogues = $this->message_source->catalogues ();

    if (count ( $catalogues ) == 0) {
      unset ( $this->message_source );
      throw new Exception('No hay nada para traducir', 100);
    }
    
    foreach ( $catalogues as $item ) {
      if (! array_key_exists ( $item [0], $this->list_catalogues )) {
              $this->list_catalogues [$item [0]] = $item [0];
      }

      if (! array_key_exists ( $item [1], $this->list_lang )) {
              $this->list_lang [$item [1]] = $item [1];
      }
      // check permissions for each file
      $this_item_file = $i18n_dir . '/' . mdEleAdminI18nTool::getFileForCatalogue ( $item [1], $item [0] );
      if (! is_writable ( $this_item_file )) {
              @chmod ( $this_item_file, 0777 );
              if (! is_writable ( $this_item_file )) {
              //$this->errors [] = array ('id' => self::ERR_FILE_PERMISSION, '--file--' => mdEleAdminI18nTool::getFileForCatalogue ( $item [1], $item [0] ) );
              }
      }
    }
    //Comento esta linea porque esta repetida mas arriba
    //$this->message_source = $i18n->createMessageSource( $i18n_dir );
  }


  public function getApplicationPages(){
    $messages = $this->applyFilters($this->getMessages());
    $paginas = array();
    foreach ( $messages as $key => $var ) {
      $exploded_key = explode('_', $key); 
      $paginas[$exploded_key[0]] = $exploded_key[0];
    }

    array_unique($paginas);
    return $paginas;
  }
  
  public function getMessagesByPage($page)
  {
    $messages = array();
    foreach ($this->getMessages() as $key => $var)
    {
      $exploded_key = explode('_', $key);
      if ($page == $exploded_key[0])
      {
        $messages[$key] = $var;
      }
    }
    return $this->applyFilters($messages);
  }
  
  /**
   *
   * @param array $messages
   * [key] = array(
   *          [0] => (string) texto
   *          [1] => (int) id
   *          [2] => (string) language
   *         )
   */
  private function applyFilters($messages)
  {
    // inicializamos variable de retorno
    $msgs = array();
    
    // Si se trata de una busqueda
    if($this->is_filter)
    {
      // itero sobre cada uno de los mensajes
      foreach ( $messages as $key => $var ) 
      {
        // Si matchea con la key lo guardo
        if(preg_match('/' . $this->filter_word . '/i', $key))
        {
          $msgs[$key] = $var;
        }
        else
        {
          // Sino matchea el titulo me fijo si es una busqueda por contenidos
          if($this->filter_target)
          {
            if(preg_match('/' . $this->filter_word . '/i', $var[0]))
            {
              $msgs[$key] = $var;
            }
          }
        }
      }
      return $msgs;
    }
    else
    {
      return $messages;
    }
  }

  public function update($source, $translation){
    $this->loadMessages();
    return $this->getMessageSource()->update (
            $source,
            $translation,
            $this->getSelectedLang(),
            $this->getSelectedCatalogue() );
  }

  /**
  * Devuelve un listado de plugins que tienen i18n
  *
  * @param <string> $place
  * @return array
  */
  public static function directoryList($place){
    $dirPath = $place;
    $list = array();
    // open the specified directory and check if it's opened successfully
    if ($handle = opendir($dirPath)) {
      
     // keep reading the directory entries 'til the end
     while (false !== ($file = readdir($handle))) {

      // just skip the reference to current and parent directory
      if ($file != "." && $file != ".." && $file != ".svn" && $file != ".depdblock" && $file != ".channels" && $file != ".depdb" && $file != ".filemap" && $file != ".registry" && $file != ".lock") {
       if (is_dir($dirPath . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR . 'i18n')) {
          // found a directory, do something with it?
          array_push($list, $file);
          //echo "[$file]<br>";
       }
      }
     }
     // ALWAYS remember to close what you opened
     closedir($handle);
     return $list;
    }
  }

  public static function addNewWordToCatalogue($application, $page, $tag)
  {
      $langs = self::getLanguages();
      foreach($langs as $lang)
      {
        $id = self::retrieveNextIdWordToCatalogue($application, $lang, $page, $tag);
        $place = sfConfig::get ( 'sf_root_dir' )."/apps/".$application."/i18n/".$lang."/messages.xml";


				$xml = simplexml_load_file ( $place );
        $word = $xml->file->body->addChild('trans-unit');
        $word->addAttribute('id', $id);
        $word->addChild('source', $page."_".$tag);
        $word->addChild('target', '');
        $word->addChild('note', $lang);

				$dom = new DOMDocument('1.0');
				$dom->preserveWhiteSpace = false;
				$dom->formatOutput = true;
				$dom->loadXML($xml->asXML());
        
				file_put_contents($place, $dom->saveXML());
      }
  }

  public static function retrieveNextIdWordToCatalogue($application, $lang, $page, $tag)
  {
      $place = sfConfig::get ( 'sf_root_dir' )."/apps/".$application."/i18n/".$lang."/messages.xml";
      $xml = simplexml_load_file ( $place );
      $lastId = 0;
      foreach($xml->file->body as $trans)
      {
          foreach($trans as $t)
          {
              $xmlTag = (string) $t->source;
              if(strcmp($xmlTag, $page."_".$tag) == 0)
              {
                  throw new Exception("Tag repetido en la pagina", 192);
              }
              $lastId = (int) $t['id'];
          }

      }
      return $lastId + 1;
  }
  
  public static function getLanguages()
  {
    $app = sfContext::getInstance ()->getConfiguration ()->getApplication ();
    $i18n_dir = sfConfig::get ( 'sf_root_dir' ) . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . 'config';
    $xml = simplexml_load_file ( $i18n_dir."/lenguages.xml" );
    
    if(!$xml){ throw new Exception('you have to create lenguages.xml with availables languages');}
    
    $lenguageList = array();
    foreach ( $xml->children () as $child ) {
      $lenguageList[$child->getName()] = $child->getName();
    }
    return $lenguageList;
  }
}
