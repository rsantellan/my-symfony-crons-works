<?php

/**
 * progenitor
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jardin
 * @subpackage model
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class progenitor extends Baseprogenitor {
  
    const BUNNYS_KEY = '3st43sl4cl4v3d3bunny3';
  
    public function preDelete($event) {
        if ($this->getMdUserId() != NULL) {
            $this->getMdUser()->delete();
        }
    }
    
    public function preSave($event) {

        if ($this->getMail() == "")
            return $this;

        if ($this->getMdUserId() == NULL) {
            
            try {
                // Creo un mdUser
                $mdUser = new mdUser();
                $mdUser->setEmail($this->getMail());
                $mdUser->save();
                
                $this->setMdUserId($mdUser->getId());
            } catch (Exception $e) {

            }

        } else {
            // Obtengo el mdUser
            $mdUser = $this->getMdUser();
            $mdUser->setEmail($this->getMail());
            $mdUser->save();
        }

        return $this;
    }
    
    public function enviarActivacion($link = null) {
        $mdMailXMLHandler = new mdMailXMLHandler();
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N', 'Partial', 'crossAppLink'));

	if(is_null($link)){
	  $link = cross_app_url_for('frontend', '@activation?code=' . $this->doCode(), true);	  
	}

        $title = __('Mail_Activacion de cuenta');

        $email = $this->getMail();
        
        $body = get_partial('progenitores/active_account', array('progenitor' => $this, 'link' => $link));
            
        /*
          recipients	Destinatarios	Requerido Puede ser un string de emails separados por coma o un array de emails.
          sender	Emisor		Requerido (array) con 'name' y 'email'
          subject	Asunto		Requerido (string)
          body 		Cuerpo 		REQUERIDO (string)
          replyTo	Setea el replyTo(string) email . Default
          attachments	Archivos adjuntos(array) de archivos
          usePhpMail	Especifica si usa php mail para este envio (bool)
         */
        if ($email != '')
            mdMailHandler::sendMail(array('recipients' => $email, 'sender' => array('name' => $mdMailXMLHandler->getFrom(), 'email' => $mdMailXMLHandler->getEmail()), 'subject' => $title, 'body' => $body));
    }
    
    public function doCode(){
        $time = time();
        $key = self::encrypt($this->getMail() . $time);

        // clave | id | email | timestamp
        $params = base64_encode($key . '|' . $this->getId() . '|' . $this->getMail() . '|' . $time);
	
	return $params;
    }
    
    public static function checkActiveParameters($code) {
        $params = base64_decode($code);
        $info = explode('|', $params);

        list($key, $id, $email, $timestamp) = $info;

        $date = strtotime(date('Y-m-d H:i:s', $timestamp) . " +1 week");
        $now = time();

        // Validamos que no haya caducado el link
        //if ($date < $now) {
            //throw new Exception('Out of date');
        //}

        // Validamos la key
        if ($key != self::encrypt($email . $timestamp)) {
            throw new Exception('Verification fail');
        }
	
	$progenitor = Doctrine::getTable('progenitor')->find($id);
	if($progenitor && $progenitor->getMail() == $email)
	  return $progenitor;
	else
	  throw new Exception('Verification fail');
    }
    
    public static function encrypt($string) {
        return sha1(self::BUNNYS_KEY . $string);
    }
    
    public function resetPassword($email, $password){
      $progenitor = Doctrine::getTable('progenitor')->findOneByMail($email);
      if($progenitor){
	$progenitor->setClave($password);
	$progenitor->save();
      }
    }

}