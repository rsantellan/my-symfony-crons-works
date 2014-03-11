<?php

class mdForgotPassForm extends sfForm {

  public function configure()
  {
    parent::configure();
    
    sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
 
    $this->setWidgets(array(
      'email'         => new sfWidgetFormInput()
    ));
 
    $this->setValidators(array(
      'email'         => new sfValidatorEmail(array('required'=>true),  array('required' => __('Home_El email es obligatorio')))
    ));
 
    $this->widgetSchema->setNameFormat('forgot[%s]');
  }

}