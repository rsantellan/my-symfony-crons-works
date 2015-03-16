<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mdXmlSale
 *
 * @author rodrigo
 */
class mdXmlSale {

    private $inform_email = null;

    private $inform_reply = false;

    private $inform_buyer = false;

    public function getInformEmail() {
        return $this->inform_email;
    }

    public function setInformEmail($inform_email) {
        $this->inform_email = $inform_email;
    }

    public function getInformReply() {
        if( (int) $this->inform_reply == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function setInformReply($inform_reply) {
        $this->inform_reply = $inform_reply;
    }

    public function getInformBuyer() {
        if( (int) $this->inform_buyer == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function setInformBuyer($inform_buyer) {
        $this->inform_buyer = $inform_buyer;
    }


}

