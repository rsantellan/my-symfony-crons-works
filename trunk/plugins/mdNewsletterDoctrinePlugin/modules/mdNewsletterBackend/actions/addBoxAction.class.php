<?php

class addBoxAction extends sfAction {
  public function execute($request)
  {
    $form = new mdNewsletterContentForm();
    $salida = $this->getPartial('add_box', array('form' => $form));
    return $this->renderText(json_encode( array('content' => $salida)));
  }
      
}
