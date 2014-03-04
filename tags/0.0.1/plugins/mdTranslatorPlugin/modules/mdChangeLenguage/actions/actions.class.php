<?php

/**
 * static actions.
 *
 * @package    lenguages
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mdChangeLenguageActions extends sfActions {

  public function executeChangeLanguage(sfWebRequest $request) {
    $app = sfContext::getInstance()->getConfiguration()->getApplication();
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
      $url = '@homepage';
    }
    $this->getUser()->setFlash('changeLenguage', 'true');
    //return $this->redirect('localized_homepage');
    return $this->redirect($url);
  }

}
