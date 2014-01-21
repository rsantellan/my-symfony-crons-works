<?php

class mdSaleXMLHandler {

    private $xml;

    public function __construct() {
        $this->xml = simplexml_load_file($this->getXMLPlaceAndName());
    }

    private function getXMLPlaceAndName() {
        $config_place = sfConfig::get('sf_root_dir') . DIRECTORY_SEPARATOR . 'config';
        return $config_place . DIRECTORY_SEPARATOR . sfConfig::get('mdSalesConfiguration', 'mdSalesConfiguration') . ".xml";
    }

    public function getInformSaleEmail() {
        return $this->xml->information->inform_of_sale->email;
    }

    public function getReplyOn() {
        return $this->xml->information->inform_of_sale->reply_on;
    }

    public function getInformBuyer() {
        return $this->xml->information->inform_of_sale->inform_buyer;
    }

    public function setInformSaleEmail($email) {
        $this->xml->information->inform_of_sale->email = $email;
    }

    public function setReplyOn($boolean) {
        if ($boolean) {
            $this->xml->information->inform_of_sale->reply_on = 1;
        } else {
            $this->xml->information->inform_of_sale->reply_on = 0;
        }
    }

    public function setInformBuyer($boolean) {
        if ($boolean) {
            $this->xml->information->inform_of_sale->inform_buyer = 1;
        } else {
            $this->xml->information->inform_of_sale->inform_buyer = 0;
        }
    }

    public function save()
    {
        file_put_contents($this->getXMLPlaceAndName(), $this->xml->asXML());
    }

//  public function getContactTitle()
//  {
//    return $this->xml->titles->contact;
//  }
//
//  public function getAutomaticTitle()
//  {
//    return $this->xml->titles->automatic;
//  }
//
//  public function getFrom()
//  {
//     return $this->xml->from;
//  }
//
//  public function getEmail()
//  {
//    return $this->xml->email;
//  }
//
//  public function setContactTitle($contact)
//  {
//    $this->xml->titles->contact = $contact;
//  }
//
//  public function setAutomaticTitle($automatic)
//  {
//    $this->xml->titles->automatic = $automatic;
//  }
//
//  public function setFrom($from)
//  {
//     $this->xml->from = $from;
//  }
//
//  public function setEmail($email)
//  {
//    $this->xml->email = $email;
//  }
//

}
