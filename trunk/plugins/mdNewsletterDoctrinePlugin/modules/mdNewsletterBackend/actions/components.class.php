<?php

class mdNewsletterBackendComponents extends sfComponents {

    public function executeAddUser(sfWebRequest $request) {
        $this->form = new mdNewsletterForm();
        if( sfConfig::get( 'sf_plugins_newsletter_group_enable', false ) )
        {
          $this->groups = Doctrine::getTable("mdNewsLetterGroup")->findAll();
        }
    }
    
    public function executeRemoveUser(sfWebRequest $request) {
        $this->form = new mdNewsletterForm();
    }

    public function executeAddDates(sfWebRequest $request) {
        $mdNewsletterContentSended = new mdNewsletterContentSended();
        $mdNewsletterContentSended->setMdNewsletterContentId($this->object->getId());
        $mdNewsletterContentSended->setSendingDate(date('Y-m-d H:i:s'), time());
        $this->form = new mdNewsletterContentSendedForm($mdNewsletterContentSended);
    }    

    public function executeRetrieveSended(sfWebRequest $request) {
        $this->list = mdNewsletterHandler::retrieveAllMdNewsletterContentSendedOfId($this->object->getId());
    }     
        
}
