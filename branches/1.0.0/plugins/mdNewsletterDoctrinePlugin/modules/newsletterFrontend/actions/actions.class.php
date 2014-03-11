<?php

/**
 * newsletterFrontend actions.
 *
 * @package    newsletterBackend
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsletterFrontendActions extends sfActions {

  public function executeCreate(sfWebRequest $request) {
    $this->form = new mdNewsletterForm();
    $ok = false;

    if ($request->isMethod('post')) {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid()) {
        mdNewsletterHandler::registerUser($this->form->getValue('mail'));
        $ok = true;
      }
    }
    
    return $this->renderText(mdBasicFunction::basic_json_response($ok, array("body" => $this->getPartial("newsletterFrontend/form", array("form" => $this->form)))));
  }

}
