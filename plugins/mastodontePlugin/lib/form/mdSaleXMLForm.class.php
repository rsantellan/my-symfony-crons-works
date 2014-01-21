<?php
class mdSaleXMLForm extends sfForm
{
  public function configure()
  {
    $xmlSaleHandler = new mdSaleXMLHandler();
    $this->setWidgets(array(
        'information_sale_email'    => new sfWidgetFormInputConfigurable(array('value'=>$xmlSaleHandler->getInformSaleEmail())),
        'information_reply_on'    => new sfWidgetFormInputCheckbox(),
        'information_inform_buyer'    => new sfWidgetFormInputCheckbox(),
    ));

		$error_message = array(
			'required'=>'Requerido.',
			'invalid' => 'Email invalido.'
			);

    $this->setValidators(array(
        'information_sale_email'    => new sfValidatorEmail(array('required' => true),$error_message),
        'information_reply_on'    => new sfValidatorBoolean(array('required' => false),$error_message),
        'information_inform_buyer'    => new sfValidatorBoolean(array('required' => false),$error_message),
    ));

    $this->widgetSchema->setNameFormat('sale_manager[%s]');

  }
  
  public function save($conn = null)
  {
    $tainted = $this->getTaintedValues ();
    $reply_on = false;
    if(isset($tainted['information_reply_on']))
    {
        $reply_on = true;
    }
    $inform = false;
    if(isset($tainted['information_inform_buyer']))
    {
        $inform = true;
    }
    $xmlSaleHandler = new mdSaleXMLHandler();
    $xmlSaleHandler->setInformSaleEmail($tainted['information_sale_email']);
    $xmlSaleHandler->setInformBuyer($inform);
    $xmlSaleHandler->setReplyOn($reply_on);
    $xmlSaleHandler->save();
  }
}
