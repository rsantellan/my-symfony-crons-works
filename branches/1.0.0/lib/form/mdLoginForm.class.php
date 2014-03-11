<?php

class mdLoginForm extends sfForm {

  public function configure() {
		sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
    $this->setWidgets(
      array(
        'username' => new sfWidgetFormInput (array('label' => __('Usuarios_Username'))),
        'password' => new sfWidgetFormInputPassword (array('label' => __('Usuarios_Clave')))
      )
    );

    $this->widgetSchema->setNameFormat('login[%s]');




    $error_message = array(
    'required'=> __('Usuarios_Error Campo requerido'),
    'invalid' => __('Usuarios_Error Formato incorrecto')
    );


    $this->setValidators(
      array(
        'username' => new sfValidatorString(
          array(
            'required' => true
          ), $error_message
        ),
        'password' => new sfValidatorPass(
          array(
            'required' => true
          ),$error_message
        )
      )
    );
  }

}
