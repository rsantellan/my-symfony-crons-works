<?php

class saveMdNewsLetterContentSendedAction extends sfAction {

  public function execute($request) {
    $this->form = new mdNewsletterContentSendedForm();
    $parameters = $request->getParameter($this->form->getName());

    $this->form->bind($parameters);
    $ok = false;
    $table_row = "";
    if ($this->form->isValid()) {
      $ok = true;
      $postParameters = $request->getPostParameters();
      $mdNewsletterContentSended = $this->form->save();
      $mdNewsletterContentSended->setSubject($mdNewsletterContentSended->getMdNewsletterContent()->getSubject());
      $mdNewsletterContentSended->setBody($mdNewsletterContentSended->getMdNewsletterContent()->getBody());
      $mdNewsletterContentSended->save();
      switch ($postParameters["send"]) {
        case 0:
          //Aca es para todos
          $mdNewsletterContentSended->setForStatus(mdNewsletterContentSended::FORALL);
          $mdNewsletterContentSended->save();
          mdNewsletterHandler::sendEmailToAllUsers($mdNewsletterContentSended->getId());
          break;
        case 1:
          //Aca es para algunos
          $mdNewsletterContentSended->setForStatus(mdNewsletterContentSended::FORUSERS);
          $mdNewsletterContentSended->save();
          $aux = $postParameters["send_users"];
          if ($aux == "") {
            $emails = array();
          } else {
            $emails = explode(",", $aux);
          }
          mdNewsletterHandler::sendEmailToSomeUsers($mdNewsletterContentSended->getId(), $emails);
          break;
        case 2:
          //Para los groupos
          $mdNewsletterContentSended->setForStatus(mdNewsletterContentSended::FORGROUPS);
          $mdNewsletterContentSended->save();
          $aux = $postParameters["send_groups"];
          if ($aux == "") {
            $emails = array();
          } else {
            $groupsIds = explode(",", $aux);
          }
          mdNewsletterHandler::sendEmailToGroups($mdNewsletterContentSended->getId(), $groupsIds);
          break;
        case 3:
          // Para los padres
          $mdNewsletterContentSended->setForStatus(mdNewsletterContentSended::FORPADRES);
          $mdNewsletterContentSended->save();
      }

      $table_row = $this->getPartial("newsletter_table_line", array("contentSended" => $mdNewsletterContentSended));
    }

    $body = $this->getPartial("addDates", array("form" => $this->form));

    return $this->renderText(mdBasicFunction::basic_json_response($ok, array("body" => $body, "table_row" => $table_row)));
  }

}
