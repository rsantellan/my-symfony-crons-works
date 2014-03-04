<?php

class saveMdNewsLetterContentAction extends sfAction {

    public function execute($request)
    {
      $salida = array();
      
      $postParameters = $request->getParameter('md_newsletter_content');
      if(is_numeric($postParameters["id"]))
      {
        $this->forward404Unless($mdNewsletterContent = Doctrine::getTable('mdNewsletterContent')->find(array($postParameters['id'])), sprintf('Object md_product does not exist (%s).', $postParameters["id"]));
      }
      else
      {
        $mdNewsletterContent = new mdNewsletterContent();
      }
      $form = new mdNewsletterContentForm($mdNewsletterContent);
      $form->bind($postParameters);
      if($form->isValid())
      {
        $mdNewsletterContent = $form->save();
        $salida['result'] = 1;
        $salida['id'] = $mdNewsletterContent->getId();
        $salida['content'] = $this->getPartial ( 'open_box', array ('form'=> $form ) );        
      }
      else
      {
        $body = $this->getPartial ( 'add_box', array ('form'=> $form) );
        $salida['result'] = 0;
        $salida['body'] = $body;
      }
      return $this->renderText(json_encode($salida));
    }
}
