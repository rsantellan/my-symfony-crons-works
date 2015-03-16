<?php

/**
 * Accion del traductor i18n
 *
 * @package    lenguages
 * @subpackage mdTranslator
 * @author     maui, rodrigo
 */
class mdPluginTranslatorActions extends sfActions {

    /**
     * manejador mastodonte del traductor i18n
     *
     * @var mdI18nTranslator
     */
    private $mdI18nTranslator;

    public $selected_lang;

    public function preExecute() {

        if (!$this->getUser()->hasPermission('Admin')) {
            $this->getUser()->setFlash('noPermission', 'noPermission');
            $this->redirect($this->getRequest()->getReferer());
        }
        if (!$this->getUser()->hasPermission('Backend Use Translator')) {
            $this->getUser()->setFlash('noPermission', 'noPermission');
            $this->redirect($this->getRequest()->getReferer());
        }
    }

    /**
     * Accion Index
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        
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
    }

    private function getSfFormForSelection() {

        $form = new sfForm ();
        if (count($this->mdI18nTranslator->getPluginList()) == 1) {
            $form->setWidget('plugin', new sfWidgetFormSelect(array('choices' => $this->mdI18nTranslator->getApplicationList(), 'default' => $this->mdI18nTranslator->getSelectedPlugin()), array('style' => 'display:none')));
        } else {
            $form->setWidget('plugin', new sfWidgetFormSelect(array('label' => 'Plugin', 'choices' => array_combine($this->mdI18nTranslator->getPluginList(),$this->mdI18nTranslator->getPluginList()), 'default' => $this->mdI18nTranslator->getSelectedPlugin())));
        }
        $form->setWidget('catalogue', new sfWidgetFormInputHidden(array('default' => 'messages')));
        $form->setWidget('language', new sfWidgetFormSelect(array('label' => 'Lenguaje', 'choices' => $this->mdI18nTranslator->getLangList(), 'default' => $this->mdI18nTranslator->getSelectedLang())));
        $form->setWidget('pages', new sfWidgetFormChoice(array('label' => 'paginas disponibles', 'multiple' => true, 'choices' => $this->mdI18nTranslator->getApplicationPages())));
        $baseLang[''] = 'Referencia'; //dejo el primero vacio para que sea la referencia
        foreach ($this->mdI18nTranslator->getLangList() as $l) {
            $baseLang[$l] = $l;
        }

        $form->setWidget('base_language', new sfWidgetFormSelect(array('label' => 'Lenguaje Base', 'choices' => $baseLang, 'default' => $this->getUser()->getCulture())));

        return $form;
    }

    private function loadM18nTranslator(sfWebRequest $request)
    {
        if ($request->hasParameter('plugin')) {
            $selected_plugin = $this->getRequestParameter('plugin');
        } elseif ($this->getUser()->hasFlash('selected_plugin')) {
            $selected_plugin = $this->getUser()->getFlash('selected_plugin');
        } else {
            if(!is_null(sfConfig::get('app_i18n_plugins'))){
                $plugins = sfConfig::get('app_i18n_plugins');
            }else{
                $plugins = mdI18nTranslatorHandler::directoryList(sfConfig::get('sf_plugins_dir'));
            }
            $selected_plugin = $plugins[0];
        }
        $this->getUser()->setFlash('selected_plugin', $selected_plugin);

        $this->mdI18nTranslator = new mdI18nTranslatorHandler(array('selected_plugin' => $selected_plugin), true);

        // levanto el lenguage
        if ($request->hasParameter('lang')) {
            $this->selected_lang = $request->getParameter('lang');
        } elseif ($this->getUser()->hasFlash('selected_lang'))
            $this->selected_lang = $this->getUser()->getFlash('selected_lang');

        if (!in_array($this->selected_lang, $this->mdI18nTranslator->getLangList())) {
            $tmp = $this->mdI18nTranslator->getLangList();
            $this->selected_lang = reset($tmp);
        }
        $this->getUser()->setFlash('selected_lang', $this->selected_lang);

        // levanto el catalogo
        $selected_catalogue = $request->getParameter('catalogue');
        if ($this->getUser()->hasFlash('selected_catalogue'))
            $selected_catalogue = $this->getUser()->getFlash('selected_catalogue');

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

    public function executeGetApplicationPagesAjax(sfWebRequest $request)
    {
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
        $form->setWidget('translation_new_' . $id, new sfWidgetFormTextareaTinyMCE(array(
                    'width' => 600,
                    'config' => 'theme_advanced_disable: "anchor,image,cleanup,help"',
                        ), array(
                    'onChange' => 'save($F("translation_source_' . $id . '"),$F("translation_new_' . $id . '"),' . $id . ');'
                ))
        );


        $form->getWidget('translation_new_' . $id)->setDefault($values[0]);
        $form->setWidget('translation_base_' . $id, new sfWidgetFormInputText(array(), array('value' => $base)));
        $form->getWidget('translation_base_' . $id)->setDefault($base);

        return $form;
    }

    public function executeGetTranslationsFormsAjax(sfWebRequest $request) {
        sfContext::getInstance()->getLogger()->log('[TRANSLATION] load parameters');
        $index = $request->getParameter('index');
        $selected_page = $request->getParameter('page');

        $baseLang = $request->getParameter('baselang');
        $baseIndex = $index;

        $baseEnabled = ($baseLang != '' ? true : false);

        sfContext::getInstance()->getLogger()->log('[TRANSLATION] call loadM18nTranslator');

        $this->loadM18nTranslator($request);

        $baseMdTranslator = new mdI18nTranslatorHandler(array(
                    'selected_plugin' => $this->mdI18nTranslator->getSelectedPlugin(),
                    'selected_lang' => $baseLang,
                    'selected_catalogue' => $this->mdI18nTranslator->getSelectedCatalogue()), true
        );

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
        $translation = html_entity_decode($request->getParameter('translation'), ENT_COMPAT, 'UTF-8');

        $this->loadM18nTranslator($request);

        $update_result = $this->mdI18nTranslator->update($source, $translation);

        if ($update_result) {
            $this->getUser()->setAttribute('hasToPublish', true);
            return $this->renderText('ok');
        } else {
            return $this->renderText('error');
        }
    }

    public function executeClearCache(sfWebRequest $request) {
        //$this->loadM18nTranslator($request);
        exec('php ' . sfConfig::get('sf_root_dir') . DIRECTORY_SEPARATOR . 'symfony cache:clear --type=i18n');

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
        $this->selected_module = $request->getParameter('plugin');
        $page = $request->getParameter('page');
        $index = $request->getParameter('index');

        return $this->renderPartial('formList', array('forms' => $this->getTranslationForms(), 'index' => $index));
    }

    public function executeGetLangsAjax(sfWebRequest $request) {
        $plugin = $request->getPostParameter('plugin');
        $i18n = sfContext::getInstance ()->getI18N();

        $i18n_dir = sfConfig::get ( 'sf_plugins_dir' ) . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . 'i18n';

        if (!is_dir($i18n_dir)) {
            $this->logMessage('<-- Muere 1 -->');
            unset($this->message_source);
            throw new Exception('not dir', 100);
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

}
