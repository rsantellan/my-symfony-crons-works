<?php
class mdMailXMLForm extends sfForm
{
  public function configure()
  {
		
		$lang = sfContext::getInstance()->getI18N();

    $xmlMailHandler = new mdMailXMLHandler();
    $this->setWidgets(array(
        'contact'    => new sfWidgetFormInputConfigurable(array('value'=>$xmlMailHandler->getContactTitle(),'label' => $lang->__('Configuracion_Mail Titulo'))),
        'recipient'  => new sfWidgetFormInputConfigurable(array('value'=>$xmlMailHandler->getRecipient(),'label' => $lang->__('Configuracion_Mail Recipient'))),
        'automatic'  => new sfWidgetFormInputConfigurable(array('value'=>$xmlMailHandler->getAutomaticTitle(),'label' => $lang->__('Configuracion_Mail Automatico'))),
        'from_client'  => new sfWidgetFormInputCheckbox(array('value_attribute_value'=>($xmlMailHandler->getFromClient()==0?null:1),'label' => $lang->__('Configuracion_Mail Desde cliente'))),
        'mail'      => new sfWidgetFormInputConfigurable(array('value'=>$xmlMailHandler->getEmail(),'label' => $lang->__('Configuracion_Mail From Email'))),
        'from'  => new sfWidgetFormInputConfigurable(array('value'=>$xmlMailHandler->getFrom(),'label' => $lang->__('Configuracion_Mail From Name'))),
    ));

		$error_message = array(
			'required'=>$lang->__('mastodonte_Errores Requerido'),
			'invalid' => $lang->__('mastodonte_Errores Invalido')
			);

    $this->setValidators(array(
        'contact'    => new sfValidatorString(array('required' => true),$error_message),
        'recipient'  => new sfValidatorString(array('required' => true),$error_message),
        'automatic'  => new sfValidatorString(array('required' => false),$error_message),
        'from_client'  => new sfValidatorString(array('required' => false),$error_message),
        'mail'      => new sfValidatorEmail(array('required' => true),$error_message),
        'from'  => new sfValidatorString(array('required' => false),$error_message),
    ));

    $this->widgetSchema->setNameFormat('mail_manager[%s]');

  }
  
  public function save($conn = null)
  {
    $tainted = $this->getTaintedValues ();
    $xmlMailHandler = new mdMailXMLHandler();
    $xmlMailHandler->setRecipient($tainted['recipient']);
    $xmlMailHandler->setAutomaticTitle($tainted['automatic']);
    $xmlMailHandler->setContactTitle($tainted['contact']);
    $xmlMailHandler->setFromClient((isset($tainted['from_client'])?1:0));
    $xmlMailHandler->setEmail($tainted['mail']);
    $xmlMailHandler->setFrom($tainted['from']);
    $xmlMailHandler->save();
    
  }
}
