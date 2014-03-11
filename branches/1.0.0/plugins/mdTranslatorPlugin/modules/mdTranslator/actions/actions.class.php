<?php

/**
 * Accion del traductor i18n
 *
 * @package    lenguages
 * @subpackage mdTranslator
 * @author     maui, rodrigo
 */
class mdTranslatorActions extends sfActions {

    public function preExecute() {

        if (!$this->getUser()->isSuperAdmin()) {
            if (!$this->getUser()->hasGroup('admin')) {
                $this->getUser()->setFlash('noPermission', 'noPermission');
                $this->redirect($this->getRequest()->getReferer());
            }
            $has_permission = false;
            if (!$this->getUser()->hasGroup('traductores del sitio español'))
            {
                $has_permission = true;
            }
            if (!$this->getUser()->hasGroup('traductores del admin español'))
            {
                $has_permission = true;
            }
            if (!$this->getUser()->hasGroup('translators frontend english'))
            {
                $has_permission = true;
            }
            if (!$this->getUser()->hasGroup('translators backend english'))
            {
                $has_permission = true;
            }
            if (!$has_permission) {
                
                $this->getUser()->setFlash('noPermission', 'noPermission');
                $this->redirect($this->getRequest()->getReferer());
            }
        }
    }

    /**
     * manejador mastodonte del traductor i18n
     *
     * @var mdI18nTranslator
     */
    private $mdI18nTranslator;
    var $selected_lang;

    /**
     * Accion Index
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        //sdsdsd

        $this->loadM18nTranslator($request);
        //cargo los datos para la vista
        $this->lang = $this->mdI18nTranslator->getSelectedLang();

        $this->selected_catalogue = $this->mdI18nTranslator->getSelectedCatalogue();

        if ($this->getUser()->hasAttribute('hasToPublish')) {
            $this->display = 'block';
        } else {
            $this->display = 'none';
        }

        $this->selectionForm = $this->getSfFormForSelection();
        $this->error = '';
        $this->newWordForm = $this->getSfFormNewWord();
        $this->appCount = count($this->mdI18nTranslator->getApplicationList());
    }

    private function getSfFormNewWord() {
        $form = new sfForm();
        if (count($this->mdI18nTranslator->getApplicationList()) == 1) {
            $form->setWidget('application', new sfWidgetFormSelect(array('choices' => $this->mdI18nTranslator->getApplicationList(), 'default' => $this->mdI18nTranslator->getSelectedApplication()), array('style' => 'display:none')));
        } else {
            $form->setWidget('application', new sfWidgetFormSelect(array('label' => 'Aplicacion', 'choices' => $this->mdI18nTranslator->getApplicationList(), 'default' => $this->mdI18nTranslator->getSelectedApplication())));
        }
        $form->setWidget('page', new sfWidgetFormInput(array(), array('label' => 'Page')));
        $form->setWidget('tag', new sfWidgetFormInput(array(), array('label' => 'tag')));

        $form->setValidator('page', new sfValidatorString(array('required' => true)));
        $form->setValidator('tag', new sfValidatorString(array('required' => true)));
        $form->setValidator('application', new sfValidatorString(array('required' => false)));
        $form->getWidgetSchema()->setNameFormat('newWord[%s]');
        return $form;
    }

    private function limitLangListByUserPermissions($lang_list)
    {
        if (!sfConfig::get('sf_plugins_user_groups_permissions', false))
        {
           return $lang_list;
        }
        $result = array();
        foreach($lang_list as $lang)
        {
            if($lang == "es")
            {
                if ($this->getUser()->hasGroup('traductores del sitio español') || $this->getUser()->hasGroup('traductores del admin español'))
                {
                    $result[$lang] = $lang;
                }
            }
            if($lang == "en")
            {
                if ($this->getUser()->hasGroup('translators frontend english') || $this->getUser()->hasGroup('translators backend english'))
                {
                    $result[$lang] = $lang;
                }
            }
            if($lang == "pt")
            {
                if ($this->getUser()->hasGroup('Tradutores site público em Português') || $this->getUser()->hasGroup('Site administradores tradutores em Português'))
                {
                    $result[$lang] = $lang;
                }
            }
            
        }
        return $result;
    }
    
    private function getSfFormForSelection() {

      $form = new sfForm ();
      
      if (count($this->mdI18nTranslator->getApplicationList()) == 1) {
        $form->setWidget('application', new sfWidgetFormSelect(array('choices' => $this->mdI18nTranslator->getApplicationList(), 'default' => $this->mdI18nTranslator->getSelectedApplication()), array('style' => 'display:none')));
      } else {
        $form->setWidget('application', new sfWidgetFormSelect(array('label' => 'Aplicacion', 'choices' => $this->mdI18nTranslator->getApplicationList(), 'default' => $this->mdI18nTranslator->getSelectedApplication())));
      }

      $form->setWidget('catalogue', new sfWidgetFormInputHidden(array('default' => 'messages')));
      /*
      $form->setWidget('language', new sfWidgetFormSelect(array('label' => 'Lenguaje', 'choices' => $this->limitLangListByUserPermissions($this->mdI18nTranslator->getLangList()), 'default' => $this->mdI18nTranslator->getSelectedLang())));
      */
      $form->setWidget('language', new sfWidgetFormInputHidden(array('default' => $this->getUser()->getCulture())));
      $form->setWidget('base_language', new sfWidgetFormInputHidden(array('default' => sfConfig::get('sf_default_culture'))));
      /*
      $baseLang[''] = 'Referencia'; //dejo el primero vacio para que sea la referencia
      foreach ($this->mdI18nTranslator->getLangList() as $l) {
        $baseLang[$l] = $l;
      }

      $form->setWidget('base_language', new sfWidgetFormSelect(array('label' => 'Lenguaje Base', 'choices' => $baseLang, 'default' => $this->getUser()->getCulture())));
      */
      $form->setWidget('pages', new sfWidgetFormChoice(array('label' => 'paginas disponibles', 'multiple' => true, 'choices' => $this->mdI18nTranslator->getApplicationPages())));
      
      $form->setWidget('search', new sfWidgetFormInput(array('label' => 'Buscar')));
      
      $form->setWidget('search_target', new sfWidgetFormInputCheckbox(array('label' => 'Filtrar por contenidos')));
      
      return $form;
    }

    private function loadM18nTranslator(sfWebRequest $request) {

        if ($request->hasParameter('app')) {
            $selected_app = $this->getRequestParameter('app');
        } elseif ($this->getUser()->hasFlash('selected_app')) {
            $selected_app = $this->getUser()->getFlash('selected_app');
        } else {
            $translatorSettings = sfConfig::get('sf_mdI18nTranslator', '');
            $arrApps = $translatorSettings['translate_apps'];
            $selected_app = $arrApps[0];
            // $selected_app = sfContext::getInstance ()->getConfiguration ()->getApplication ();
        }

        $this->getUser()->setFlash('selected_app', $selected_app);
        $restricted_apps = array();
        
        if(!$this->getUser()->isSuperAdmin())
        {
            $frontend = false;
            $backend = false;
            if ($this->getUser()->hasGroup('traductores del sitio español')) {
                $restricted_apps['frontend'] = 'frontend';
                
                $frontend = true;
            }
            if ($this->getUser()->hasGroup('traductores del admin español')) {
                $restricted_apps['backend'] = 'backend';
                
                $backend = true;
            }
            if ($this->getUser()->hasGroup('translators frontend english')) {
                if(!$frontend)
                    $restricted_apps['frontend'] = 'frontend';
                
            }
            if ($this->getUser()->hasGroup('translators backend english')) {
                if(!$backend)
                    $restricted_apps['backend'] = 'backend';
                
            }
            
        }
        $this->mdI18nTranslator = new mdI18nTranslatorHandler(array(
            'selected_app' => $selected_app, 
            'restrict_to_applications' => $restricted_apps,
            'search' => $request->getParameter('search', ''),
            'search_target' => $request->getParameter('search_target', 'false')            
            ));


        // levanto el lenguage
        if ($request->hasParameter('lang')) {
            $this->selected_lang = $request->getParameter('lang');
        } elseif ($this->getUser()->hasFlash('selected_lang'))
            $this->selected_lang = $this->getUser()->getFlash('selected_lang');


        if (!in_array($this->selected_lang, $this->limitLangListByUserPermissions($this->mdI18nTranslator->getLangList()))) {
            $tmp = $this->limitLangListByUserPermissions($this->mdI18nTranslator->getLangList());
            $this->selected_lang = reset($tmp);

            //unset($tmp);
        }

        $this->getUser()->setFlash('selected_lang', $this->selected_lang);

        // levanto el catalogo
        $selected_catalogue = $request->getParameter('catalogue');

        if ($this->getUser()->hasFlash('selected_catalogue')) {
            $selected_catalogue = $this->getUser()->getFlash('selected_catalogue');
        }

        if (!in_array($selected_catalogue, $this->mdI18nTranslator->getCatalogueList())) {
            $tmp = $this->mdI18nTranslator->getCatalogueList();
            $selected_catalogue = reset($tmp);
            unset($tmp);
        }

        $this->getUser()->setFlash('selected_catalogue', $selected_catalogue);


        $this->mdI18nTranslator->setSelectedLang($this->selected_lang);
        $this->mdI18nTranslator->setSelectedCatalogue($selected_catalogue);

        return $this;
    }

    public function executeGetApplicationPagesAjax(sfWebRequest $request) {

        $this->loadM18nTranslator($request);

        $paginas = $this->mdI18nTranslator->getApplicationPages();

        $index = 0;
        $salida = array();
        foreach ($paginas as $var) {
            $salida[$index]['page'] = $var;
            $index++;
        }
        return $this->renderText(json_encode($salida));
    }

    private function getSfFormForUpdate($key, $values, $id, $base) {
        $form = new sfForm ( );
        $form->setWidget('selected_lang_add', new sfWidgetFormInputHidden(array(), array('value' => $this->mdI18nTranslator->getSelectedLang())));
        $form->setWidget('selected_catalogue_add', new sfWidgetFormInputHidden(array(), array('value' => $this->mdI18nTranslator->getSelectedCatalogue())));
        $form->setWidget('translation_source_' . $id, new sfWidgetFormInputHidden(array(), array('value' => $key)));
        $form->setWidget('translation_source_text_' . $id, new sfWidgetFormInputText(array(), array('value' => $key)));
        $form->getWidget('translation_source_text_' . $id)->setDefault($key);
        
        if(!sfConfig::get( 'sf_plugins_use_file_on_tiny', false ))
        {
            $form->setWidget('translation_new_' . $id, new sfWidgetFormTextareaTinyMCE(array(
                    'width' => 540,
                    'config' => 'plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist, spellchecker",
                        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|",
                        theme_advanced_buttons2 : "bullist,numlist,|link,unlink,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|fullscreen,|,cut,copy,paste,pastetext,pasteword,|",
                        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid",
                        theme_advanced_buttons4 : ""'
                )));
        }
        else
        {
            $form->setWidget('translation_new_' . $id, new sfWidgetFormTextareaTinyMCE(array(
                    'width' => 540,
                    'config' => 'plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist, spellchecker, jfilebrowser",
                        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|",
                        theme_advanced_buttons2 : "bullist,numlist,|link,unlink,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|fullscreen,|,cut,copy,paste,pastetext,pasteword,|,jfilebrowser",
                        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid",
                        theme_advanced_buttons4 : ""'
                )));
        }

        $form->getWidget('translation_new_' . $id)->setDefault($values[0]);
        $form->setWidget('translation_base_' . $id, new sfWidgetFormInputText(array(), array('value' => $base)));
        $form->getWidget('translation_base_' . $id)->setDefault($base);

        return $form;
    }

    /**
     * USADO EN LA VERSION BRANCHES/JQUERY 0.0.1
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeGetContentToEdit(sfWebRequest $request) {
        //pagina seleccionada
        $key_page = $request->getParameter('key');
        //key completa pagina y texto a traducir
        $full_key = $request->getParameter('full_key');
        //id que neceista el formulario en este caso no nos interesa
        //porque siempre es 1 solo form
        $id = $request->getParameter('id', '1');
        //lenguage base que se usa como referencia para traducir
        $baseLang = $request->getParameter('base', '');
        $baseIndex = 1;

        $baseEnabled = ($baseLang != '' ? true : false);

        $this->loadM18nTranslator($request);

        $baseMdTranslator = new mdI18nTranslatorHandler(array(
                    'selected_app' => $this->mdI18nTranslator->getSelectedApplication(),
                    'selected_lang' => $baseLang,
                    'selected_catalogue' => $this->mdI18nTranslator->getSelectedCatalogue(),
                    'search' => $request->getParameter('search', ''),
                    'search_target' => $request->getParameter('search_target', 'false'))
        );

        $showText = ($baseLang != $this->mdI18nTranslator->getSelectedLang());

        if ($baseEnabled) { //si se eligio un base language levanta los datos del ms del leng original
            $messagesBase = $baseMdTranslator->getMessages();
        }

        foreach ($this->mdI18nTranslator->getMessages() as $key => $var) {
            $exploded_key = explode('_', $key);

            if ($baseEnabled) {
                $base = $messagesBase[$key][0];
            } else {
                $base = " ";
            }
//echo $key . ' - ' . $full_key; die();
            if ($key == $full_key) {
                $form = $this->getSfFormForUpdate($full_key, $var, $id, $base);
                return $this->renderPartial('formList', array('form' => $form, 'index' => $baseIndex, 'page' => $key_page, 'showText' => $showText));
            }
        }

        return $this->renderText('ERROR');
    }

    public function executeGetTranslationsFormsAjax(sfWebRequest $request) {

        $index = $request->getParameter('index');
        $selected_page = $request->getParameter('page');

        $baseLang = $request->getParameter('baselang');
        $baseIndex = $index;

        $baseEnabled = ($baseLang != '' ? true : false);

        $this->loadM18nTranslator($request);

        $baseMdTranslator = new mdI18nTranslatorHandler(array(
            'selected_app' => $this->mdI18nTranslator->getSelectedApplication(),
            'selected_lang' => $baseLang,
            'selected_catalogue' => $this->mdI18nTranslator->getSelectedCatalogue(),
            'search' => $request->getParameter('search', ''),
            'search_target' => $request->getParameter('search_target', 'false')         
        ));

        if ($baseEnabled) { //si se eligio un base language levanta los datos del ms del leng original
            $messagesBase = $baseMdTranslator->getMessages();
        }


        // armo lo lista de arrays de campos para los mensajes

        $forms = array();


        foreach ($this->mdI18nTranslator->getMessages() as $key => $var) {

            $exploded_key = explode('_', $key);
            if ($baseEnabled) {
                $base = $messagesBase[$key][0];
            } else {
                $base = " ";
            }


            if ($selected_page == $exploded_key[0]) {
                array_push($forms, $this->getSfFormForUpdate($key, $var, $index, $base));
                $index++;
            }
        }


        //devuelvo los formularios para los mensajes renderizados
        return $this->renderPartial('formList', array('forms' => $forms, 'index' => $baseIndex, 'page' => $selected_page));
    }

    public function executeChangeTextAjax(sfWebRequest $request) {
        $source = $request->getParameter('source');
        $original = $request->getParameter('translation');
        $translation = mdBasicFunction::xmlEntities($original);
        //var_dump($request->getParameter('translation'));
        //var_dump($translation); die();
        $this->loadM18nTranslator($request);

        $update_result = $this->mdI18nTranslator->update($source, $translation);

        if ($update_result) {
            $this->getUser()->setAttribute('hasToPublish', true);
            sfContext::getInstance()->getConfiguration()->loadHelpers(array('Text'));
            $file_content = strip_tags($original);
            $file_content = truncate_text($file_content, 100);
            return $this->renderText(mdBasicFunction::basic_json_response(true, array("message" => $file_content)));
        } else {
            return $this->renderText(mdBasicFunction::basic_json_response(false, array()));
        }
    }

    public function executeClearCache(sfWebRequest $request) {
        //$this->loadM18nTranslator($request);
        
        // run a task from action
        chdir(sfConfig::get('sf_root_dir')); // Trick plugin into thinking you are in a project directory
        $task = new sfCacheClearTask($this->dispatcher, new sfFormatter());
        $task->run(array(), array('type' => 'i18n'));
        
//        exec('php ' . sfConfig::get('sf_root_dir') . DIRECTORY_SEPARATOR . 'symfony cache:clear --type=i18n');

        $this->getUser()->getAttributeHolder()->remove('hasToPublish');
        $salida = array('response' => 'OK');
        return $this->renderText(json_encode($salida));
        //$this->redirect($request->getReferer());
    }

    /* =============== =============== =  */

    /**
     * genera un formulario de symfony con los campos necesarios
     *
     * @param integer $index
     * @return array of sfForm items
     * @author maui .-
     */
    private function getTranslationForms(int $index) {

        $baseIndex = $index;

        $messages = $this->mdI18nTranslator->getMessages();

        $forms = array();

        foreach ($messages as $key => $var) {
            $exploded_key = explode('_', $key);

            if ($this->mdI18nTranslator->getSelected() == $exploded_key[0]) {

                array_push($forms, $this->getSfFormForUpdate($key, $var, $index));
                $index++;
            }
        }
        return $forms;
    }

    /**
     * Executes Page2 action
     *
     * @param sfRequest $request A request object
     */
    public function executePage2(sfWebRequest $request) {
        $this->getUser()->setCulture('en_US');
    }

    private function getApplicationPages() {
        $translations = $this->message_source->read();
        $filename = mdEleAdminI18nTool::getFileForCatalogue($this->selected_lang, $this->selected_catalogue);
        $messages = $translations [$filename];
        $paginas = array();
        foreach ($translations[$filename] as $key => $var) {
            $exploded_key = explode('_', $key);
            $paginas[$exploded_key[0]] = $exploded_key[0];
        }
        array_unique($paginas);
        return $paginas;
    }

    public function executeGetPageTexts() {
        $lang = $request->getParameter('lang');
        $catalogue = $request->getParameter('catalogue');
        $this->selected_module = $request->getParameter('app');
        $page = $request->getParameter('page');
        $index = $request->getParameter('index');

        return $this->renderPartial('formList', array('forms' => $this->getTranslationForms(), 'index' => $index));
    }

    public function executeGetLangsAjax(sfWebRequest $request) {
        $app = $request->getPostParameter('app');
        $i18n = sfContext::getInstance ()->getI18N();
        $i18n_dir = sfConfig::get('sf_app_module_dir') . '/' . $app . '/i18n';

        // module is in modules dir, but i18n does not exists
        $i18n_dir = sfConfig::get('sf_root_dir') . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . 'i18n';

        if (!is_dir($i18n_dir)) {
            $this->logMessage('<-- Muere 1 -->');
            unset($this->message_source);
            return;
        }

        $this->message_source = $i18n->createMessageSource($i18n_dir);

        $catalogues = $this->message_source->catalogues();
        $options = array();
        $i = 0;
        foreach ($catalogues as $cat) {
            $options[$i]['id'] = $cat[1];
            $options[$i]['name'] = $cat[1];
            $i++;
        }
        return $this->renderText(json_encode($options));
    }

    /**
     * Trae las cabeceras para el accordion
     *
     *  VERSION BRANCHES/JQUERY 0.0.1
     */
    public function executeGetTranslationsFormsHeader(sfWebRequest $request) {
        $index = $request->getParameter('index');
        $selected_page = $request->getParameter('page');

        $baseLang = $request->getParameter('baselang');
        $baseIndex = $index;

        $this->loadM18nTranslator($request);

        $header_text = $this->mdI18nTranslator->getMessagesByPage($selected_page);

        return $this->renderPartial('mdTranslator/accordion_header', array('header_text' => $header_text));
    }

    public function executeChangeLanguage(sfWebRequest $request) {
        $app = sfContext::getInstance ()->getConfiguration()->getApplication();
        $i18n_dir = sfConfig::get('sf_root_dir') . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . 'config';
        $xml = simplexml_load_file($i18n_dir . "/lenguages.xml");

        $lenguageList = array();
        foreach ($xml->children() as $child) {
            $lenguageList[$child->getName()] = $child->getName();
        }
        $form = new sfFormLanguage
                        ($this->getUser(),
                        array('languages' => $lenguageList));
        $request->setParameter($form->getCSRFFieldName(), $form->getCSRFToken());
        $form->process($request);
        $url = $request->getReferer();
        if (is_null($url) || $url == "") {
            $url = 'default/index';
        }
        $this->getUser()->setFlash('changeLenguage', 'true');
        return $this->redirect($url);
    }

    public function executeAddNewWord(sfWebRequest $request) {
        $this->loadM18nTranslator($request);

        $form = $this->getSfFormNewWord();

        $parameters = $request->getParameter($form->getName());
        $form->bind($parameters, $request->getFiles($form->getName()));

        if ($form->isValid()) {
            $salida = array();
            try {
                mdI18nTranslatorHandler::addNewWordToCatalogue($parameters['application'], $parameters['page'], $parameters['tag']);
                $salida['response'] = "OK";
                $options['body'] = $this->getPartial('newWordForm', array('form' => $form));
                $options['error'] = $form->getFormattedErrors();
                $salida['options'] = $options;
            } catch (Exception $e) {
                $salida['response'] = "ERROR";
                $options['body'] = $this->getPartial('newWordForm', array('form' => $form, 'exception' => $e->getMessage()));
                $options['error'] = $form->getFormattedErrors();
                $options['exception'] = $e->getMessage();
                $salida['options'] = $options;
            }
            return $this->renderText(json_encode($salida));
        } else {
            $salida = array();
            $salida['response'] = "ERROR";
            $options['body'] = $this->getPartial('newWordForm', array('form' => $form));
            $options['error'] = $form->getFormattedErrors();
            $salida['options'] = $options;

            return $this->renderText(json_encode($salida));
        }
    }

    /*
      $place = sfConfig::get ( 'sf_root_dir' )."/apps/backend/i18n/es/messages.xml";
      print_r($place);
      print_r('<hr/>');
      $xml = simplexml_load_file ( $place );
      print_r('itero');
      print_r('<hr/>');
      $lastId = 0;
      foreach($xml->file->body as $trans)
      {
      foreach($trans as $t)
      {
      $lastId = (int) $t['id'];
      print_r($t['id']);
      print_r('<br/>');
      }

      }
      print_r('<hr/>Termino de iterar<hr/>');
      //print_r($this->xml->file->body);
      print_r($lastId + 1);
      print_r('<hr/>');
      $character = $xml->file->body->addChild('trans-unit');
      $character->addAttribute('id', $lastId + 1);
      $character->addChild('source', 'Yellow Cat');
      $character->addChild('target', 'aloof');
      $character->addChild('note', 'aloof');

      file_put_contents($place, $xml->asXML());
      die('test'); */
}
