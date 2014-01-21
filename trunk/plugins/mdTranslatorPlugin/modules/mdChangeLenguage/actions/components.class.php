<?php
class mdChangeLenguageComponents extends sfComponents {
	
  public function executeLanguage(sfWebRequest $request) 
  {
    $lenguageList = mdI18nTranslatorHandler::getLanguages();
    $this->form = new sfFormLanguage( $this->getUser (), array ('languages' => $lenguageList ) );
  }

}