<?php
class resetPasswordForm extends sfForm
{
  
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
    
    $this->setWidgets(array(
        'email'                 => new sfWidgetFormInputHidden(),
        'password'              => new sfWidgetFormInputPassword(array('always_render_empty' => false)),
        'password_confirmation' => new sfWidgetFormInputPassword(array('always_render_empty' => false))   
      ));

    $error_message = array('required'=> __('Inicio_Requerido.'), 'invalid' => __('Inicio_Los passwords no coinciden.'));

    $this->setValidators(array(
        'email'       => new sfValidatorString(array('required' => true)),
        'password'    => new sfValidatorString(array('required' => true), $error_message),
        'password_confirmation' => new sfValidatorString(array('required' => true), $error_message)
    ));
    
    $this->mergePostValidator ( new sfValidatorSchemaCompare ( 'password', sfValidatorSchemaCompare::EQUAL, 'password_confirmation', array (), array ('invalid' => __('Login_Los passwords no coinciden.') ) ) );
    
    $this->widgetSchema->setNameFormat('resetpsw[%s]');
  }
  
}
