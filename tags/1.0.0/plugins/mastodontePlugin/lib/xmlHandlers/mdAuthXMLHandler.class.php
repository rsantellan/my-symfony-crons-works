<?php

class mdAuthXMLHandler
{
  private $xml = null;
  private $user_list = null;

  public function __construct()
  {
    $this->load();
  }
  
  private function load()
  {
    try
    {
      $this->xml = simplexml_load_file ( $this->getXMLPlaceAndName() );
      foreach($this->xml->user as $users){
        $mdUserFile = new mdUserFile();
        $mdUserFile->setName((string)$users->name);
        $mdUserFile->setUsername((string)$users->user);
        $mdUserFile->setPassword((string)$users->password);
        $mdUserFile->setEmail((string)$users->email);
        $this->user_list[(string)$users->user] = $mdUserFile;
      }      
    }
    catch(Exception $e)
    {
      sfContext::getInstance()->getLogger()->err($e->getMessage());
      throw new Exception("No xml file in the path", 160);
    }  

  }
  
  private function getXMLPlaceAndName()
  {
		$config_dir = sfConfig::get ( 'sf_app_config_dir' );
		return $config_dir. DIRECTORY_SEPARATOR . 'mdFileAuthUsers.xml';

  }
  
  public function retrieveUserList()
  {
    return $this->user_list;
  }
  
  public function retrieveUserFormList()
  {
    $list = array();
    foreach($this->user_list as $user)
    {
      $form = new mdAuthXMLForm(array('object'=>$user));
      array_push($list, $form);
    }
    return $list;
  }
  
  public function save()
  {
    if(!is_null($this->xml))
    {
      file_put_contents($this->getXMLPlaceAndName(), $this->xml->asXML());
    }
  }
  
  public function retrieveUser($username)
  {
    return $this->user_list[$username];
  }    
  
  public function saveMdUserFile($username, $mdUserFile)
  {
    foreach($this->xml->user as $users)
    {
      if((string)$users->user == $username)
      {
        $users->name = $mdUserFile->getName();
        $users->user = $mdUserFile->getUsername();
        $users->password = $mdUserFile->getPassword();
        $users->email = $mdUserFile->getEmail();
      }
    }
    
    $this->save();
  }
    
}
