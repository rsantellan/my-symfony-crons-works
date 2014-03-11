<?php

class mdMailXMLHandler{

  private $xml;

  public function __construct()
  {
    
    $this->xml = simplexml_load_file ( $this->getXMLPlaceAndName() );
  }
  
  private function getXMLPlaceAndName()
  {
    $config_place = sfConfig::get ( 'sf_root_dir' ) . DIRECTORY_SEPARATOR . 'config'; 
    return $config_place. DIRECTORY_SEPARATOR . sfConfig::get('mdMailConfigurationXML', 'mdMailAddresses') . ".xml";
  }
  
  public function getContactTitle()
  {
    return (string) $this->xml->titles->contact;
  }

  public function getRecipient()
  {
    return (string) $this->xml->recipient;
  }
  
  public function getAutomaticTitle()
  {
    return (string) $this->xml->titles->automatic;
  }

  public function getFromClient()
  {
     return $this->xml->fromClient;
  }
 
  public function getFrom()
  {
     return (string) $this->xml->from;
  }
  
  public function getEmail()
  {
    return (string) $this->xml->email;
  }

  public function setContactTitle($contact)
  {
    $this->xml->titles->contact = $contact;
  }

	public function setRecipient($recipient)
  {
    $this->xml->recipient = $recipient;
  }
  
  public function setAutomaticTitle($automatic)
  {
    $this->xml->titles->automatic = $automatic;
  }

  public function setFromClient($fromClient)
  {
     $this->xml->fromClient = $fromClient;
  }

  public function setFrom($from)
  {
     $this->xml->from = $from;
  }
  
  public function setEmail($email)
  {
    $this->xml->email = $email;
  }  
  
  public function save()
  {
    file_put_contents($this->getXMLPlaceAndName(), $this->xml->asXML());
  }
}
