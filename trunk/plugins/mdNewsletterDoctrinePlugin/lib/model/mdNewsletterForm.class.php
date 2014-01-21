<?php
class mdNewsletterForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
        'mail'      => new sfWidgetFormInput(array(), array('label' => 'E-mail'))
        ));

		$error_message = array(
			'required'=>'Requerido.',
			'invalid' => 'Email invalido.'
			);

    $this->setValidators(array(
        'mail'      => new sfValidatorEmail(array('required' => true),$error_message),
    ));

    $this->widgetSchema->setNameFormat('newsLetter[%s]');

  }
}