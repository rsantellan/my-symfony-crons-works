<?php
class mdContactForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
        'nombre'    => new sfWidgetFormInput(array(), array('label' => 'Nombre')),
        'apellido'  => new sfWidgetFormInput(array(), array('label' => 'Apellido')),
        'mail'      => new sfWidgetFormInput(array(), array('label' => 'E-mail')),
        'telefono'  => new sfWidgetFormInput(array(), array('label' => 'Teléfono')),
        'pais'      => new sfWidgetFormI18nChoiceCountry(array('add_empty' => true, 'culture'   => sfContext::getInstance()->getUser()->getCulture())),
        'comentario'=> new sfWidgetFormTextarea(array(), array('label' => 'Comentario')),
    ));

    // if you want reCaptcha configuration
    if(sfConfig::get('sf_plugins_contact_captcha_available', false))
    {
        /*$this->widgetSchema['captcha'] = new sfWidgetFormReCaptcha(array(
          'public_key' => sfConfig::get('app_recaptcha_public_key')
        ));*/
        $this->widgetSchema['captcha'] = new sfWidgetCaptchaGD();
    }

    $error_message = array(
    'required'=>'Requerido.',
    'invalid' => 'Email invalido.'
    );

    $this->setValidators(array(
        'nombre'    => new sfValidatorString(array('required' => true),$error_message),
        'apellido'  => new sfValidatorString(array('required' => true),$error_message),
        'mail'      => new sfValidatorEmail(array('required' => true),$error_message),
        'telefono'  => new sfValidatorString(array('required' => false),$error_message),
        'pais'      => new sfValidatorString(array('required' => false), $error_message),
        'comentario'=> new sfValidatorString(array('required' => true),$error_message),
    ));

    // if you want reCaptcha configuration
    if(sfConfig::get('sf_plugins_contact_captcha_available', false))
    {
        /*$this->validatorSchema['captcha'] = new sfValidatorReCaptcha(array(
          'private_key' => sfConfig::get('app_recaptcha_private_key')
        ));*/
        $this->validatorSchema['captcha'] = new sfCaptchaGDValidator(array('length' => 5), array('invalid' => 'El codigo que has ingresado es invalido'));
    }

    $this->widgetSchema->setNameFormat('contacto[%s]');

  }
}