<?php

class showUsersSendedAction extends sfAction {

    public function execute($request)
    {
        $this->id = $request->getParameter("id");
        $this->forward404Unless($this->id);

        $mdNewsletterContentSended = Doctrine::getTable("mdNewsletterContentSended")->find($this->id);//mdNewsletterHandler::retrieveAllMdNewsletterContentSendedOfId($id);
        $this->forward404Unless($mdNewsletterContentSended);
        $this->results = array();
        foreach($mdNewsletterContentSended->getMdNewsletterSend() as $send)
        {
          array_push($this->results, $send->getMdNewsLetterUser()->getMdUser());
        }
        
    }
}
