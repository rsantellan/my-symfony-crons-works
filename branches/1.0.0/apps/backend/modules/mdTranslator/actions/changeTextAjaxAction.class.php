<?php

class changeTextAjaxAction extends sfAction 
{

  public function execute($request) {
    $source = $request->getParameter('source');

    $original = $request->getParameter('translation');

    $translation = mdBasicFunction::xmlEntities($original);

    $this->loadM18nTranslator($request);

    $update_result = $this->mdI18nTranslator->update($source, $translation);

    if ($update_result) {
        $this->getUser()->setAttribute('hasToPublish', true);

        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Text'));

        $file_content = strip_tags($original);

        $file_content = truncate_text($file_content, 100);

        chdir(sfConfig::get('sf_root_dir')); // Trick plugin into thinking you are in a project directory

        $task = new sfCacheClearTask($this->dispatcher, new sfFormatter());

        $task->run(array(), array('type' => 'i18n'));

        return $this->renderText(mdBasicFunction::basic_json_response(true, array("message" => $file_content)));
    } else {
        return $this->renderText(mdBasicFunction::basic_json_response(false, array()));
    }
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
}
