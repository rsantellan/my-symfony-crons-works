<?php

class newsletterFrontendComponents extends sfComponents {

    public function executeGetBasicForm(sfWebRequest $request)
    {
        $this->form = new mdNewsletterForm();
    }
}