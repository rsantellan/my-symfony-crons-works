<?php
class mdGroupXMLForm extends sfForm
{
  private $username = null;
  
  public function configure()
  {
    $defaults = $this->getDefaults();
    if(!isset($defaults['object']))
    {
      throw new Exception("Siempre es necesario pasarle como parametro un mdXmlGroup a la clase mdGroupXMLForm", 192);
    }
    else
    {
      $object = $defaults['object'];
    }
    $this->username = $object->getUsername();
    $this->setWidgets(array(
        'user_old'    => new sfWidgetFormInputConfigurable(array('value'=>$object->getUsername())),
        'user'    => new sfWidgetFormInputConfigurable(array('value'=>$object->getUsername())),
        'pass'  => new sfWidgetFormInputConfigurable(array('value'=>$object->getPassword())),
        'name'      => new sfWidgetFormInputConfigurable(array('value'=>$object->getName())),
        'email'  => new sfWidgetFormInputConfigurable(array('value'=>$object->getEmail())),
    ));

		$error_message = array(
			'required'=>'Requerido.',
			'invalid' => 'Email invalido.'
			);

    $this->setValidators(array(
        'user_old'    => new sfValidatorString(array('required' => true),$error_message),
        'user'    => new sfValidatorString(array('required' => true),$error_message),
        'pass'  => new sfValidatorString(array('required' => true),$error_message),
        'name'      => new sfValidatorString(array('required' => true),$error_message),
        'email'  => new sfValidatorEmail(array('required' => false),$error_message),
    ));

    $this->widgetSchema->setNameFormat('md_auth_manager[%s]');

  }
  
  public function retrieveUserName()
  {
    return $this->username;
  }
  
  public function save($conn = null)
  {
    $tainted = $this->getTaintedValues ();
    $mdUserFile = new mdUserFile();
    $mdUserFile->setName((string)$tainted['name']);
    $mdUserFile->setUsername((string)$tainted['user']);
    $mdUserFile->setPassword((string)$tainted['pass']);
    $mdUserFile->setEmail((string)$tainted['email']);
    $mdAuthXMLHandler = new mdAuthXMLHandler();
    $mdAuthXMLHandler->saveMdUserFile($tainted['user_old'], $mdUserFile);
    return $mdUserFile;
  }
}
