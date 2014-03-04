<?php

class mdMailHandler {

  static public function sendConfirmationMail(mdPassport $mdPassport, $realtime = true) {
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N', 'Url'));

    $subject = __('mdUserDoctrine_text_ResetMailSubject');
    $params = base64_encode($mdPassport->getId() . '_' . time() . '_' . $mdPassport->getPassword());
    $request = sfContext::getInstance()->getRequest();
    $link = url_for('@confirm_user_password?confirmation=' . $params, true);

    if (!$mdPassport->isUserOfBackend()) {
      $link = self::removeBackendControler($link);
    }


    sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
    $body = get_partial('mdUserManagement/resetPasswordMailBody', array('link' => $link));
    $mdMailXMLHandler = new mdMailXMLHandler();
    $usePhpMailer = sfConfig::get('app_php_mailer_enabled', false);
    if ($usePhpMailer) {
      self::sendPhpMail($mdPassport->retrieveMdUser()->getEmail(), $mdMailXMLHandler->getEmail(), $subject, $body);
    } else {
      $from = (string) $mdMailXMLHandler->getFrom();
      $email = (string) $mdMailXMLHandler->getEmail();
      $message = Swift_Message::newInstance()
        ->setSubject($subject)
        ->setFrom(array($email => $from))
        ->setTo(array($mdPassport->retrieveMdUser()->getEmail()))
        ->setContentType("text/html")
        ->setBody($body);

      $mailer = sfContext::getInstance()->getMailer();
      if ($realtime) {
        $mailer->sendNextImmediately()->send($message);
      } else {
        $mailer->send($message);
      }
    }
  }

  static public function sendActivationMail(mdPassport $mdPassport, $realtime = true) {
    $link = mdUserHandler::getActivationUrl($mdPassport);
    $instanse = sfContext::getInstance();
    $instanse->getConfiguration()->loadHelpers('I18N');
    $mailer = sfContext::getInstance()->getMailer();
    $subject = __('mdUserDoctrine_text_ActivationMailSubject');
    $params = base64_encode($mdPassport->getId() . '_' . time() . '_' . $mdPassport->getPassword());
    $request = $instanse->getRequest();
    $instanse->getConfiguration()->loadHelpers('Url');
    $link = url_for('@activate_user', true) . '?' . $link;
    $link = self::removeBackendControler($link);
    $instanse->getConfiguration()->loadHelpers('Partial');
    $body = get_partial('mdUserManagementBasic/activeAccountEmail', array('link' => $link, 'username' => $mdPassport->getUsername()));

    sfContext::getInstance()->getLogger()->err('<<<!!!!!' . $mdPassport->retrieveMdUser()->getEmail());
    $mdMailXMLHandler = new mdMailXMLHandler();
    $usePhpMailer = sfConfig::get('app_php_mailer_enabled', false);
    if ($usePhpMailer) {
      self::sendPhpMail($mdPassport->retrieveMdUser()->getEmail(), $mdMailXMLHandler->getEmail(), $subject, $body);
    } else {
      $from = (string) $mdMailXMLHandler->getFrom();
      $email = (string) $mdMailXMLHandler->getEmail();
      $message = Swift_Message::newInstance()
        ->setSubject($subject)
        ->setFrom(array($email => $from))
        ->setTo(array($mdPassport->retrieveMdUser()->getEmail()))
        ->setContentType("text/html")
        ->setBody($body);
      if ($realtime) {
        $mailer->sendNextImmediately()->send($message);
      } else {
        $mailer->send($message);
      }
    }
  }

  public static function removeBackendControler($url) {
    $list = explode("/", $url);
    $new_url = "";
    $index = 0;
    foreach ($list as $key => $val) {
      $new_val = "";
      if ($val === "backend_dev.php") {
        $new_val = "frontend_dev.php";
      } else {
        if ($val === "backend.php") {
          $new_val = "index.php";
        } else {
          $new_val = $val;
        }
      }

      $new_url .= $new_val;
      if ($index < count($list) - 1) {
        $new_url .= "/";
      }
    }
    $new_url = substr_replace($new_url, "", -1);
    return $new_url;
  }

  // saco la funcion sendMdContactMail porque queda obsoleto desde la version 1.0.2 del mdContactPlugin
  //static public function sendMdContactMail($body, $subject, $from, $sendMe = false)
  //@autor maui

  /**
   * Envia mail usando swift
   * Tanto $from como $to reciben string
   * $recipients acepta tanto string de mails separados por como como array de emails
   * $form es array con claves 'name' y 'email'
   *
   * @param string $from 
   * @param string $to 
   * @param string $subject 
   * @param string $body 
   * @param bool $needReply 
   * @param string $replyTo 
   * @param string $attachMents 
   * @param bool $realtime
   * @return bool
   * @author maui .-
   */
  public static function sendSwiftMail($from, $to, $subject, $body, $needReply = false, $replyTo = false, $attachMents = array(), $realtime = false) {

    if (!is_array($to)) {
      $to = array($to);
    }
    if (!is_array($from)) {
      $from = array('name' => $from, 'email' => $from);
    }

    $mailer = sfContext::getInstance()->getMailer();

    $message = Swift_Message::newInstance()
      ->setSubject($subject)
      ->setSender($from['email'], $from['name'])
      ->setFrom($from['email'], $from['name'])
      ->setTo($to)
      ->setContentType("text/html")
      ->setBody($body);

		if($replyTo !== false)
			$message->setReplyTo($from['email']);

    /* 			if(!$needReply){
      var_dump('estoy aca');
      var_dump($needReply);
      foreach($to as $mail_text){
      $message->setBcc( $mail_text );
      }
      }
     */
    if (count($attachMents) > 0) {
      foreach ($attachMents as $file) {
        $message->attach(Swift_Attachment::fromPath($file));
      }
    }
    if ($realtime) {
      $sendMessage = $mailer->sendNextImmediately()->send($message);
    } else {
      $sendMessage = $mailer->send($message);
    }

    return $sendMessage;
  }

  /**
   * Envia mail usando la funcion mail de php
   * $recipients acepta tanto string de mails separados por como como array de emails
   * $form es array con claves 'name' y 'email'
   *
   * @param array/string $recipients 
   * @param array $from 
   * @param string $subject 
   * @param string $body 
   * @return bool
   * @author maui .-
   */
  static public function sendPhpMail($recipients, $from, $subject, $body) {

    if (!is_array($recipients))
      $recipients = explode(',', $recipients);

    foreach ($recipients as $recipient) {

      $mdMailXMLHandler = new mdMailXMLHandler();
      $headers = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $headers .= 'From: ' . $from['name'] . '<' . $from['email'] . '>';
      $headers .= "\r\n";
      // Mail it
      if (!mail($recipient, $subject, $body, $headers))
        return false;
    }
    return true;
  }

  /**
   * Envia mail usando el metodo configurado para la aplicación. app_php_mailer_enabled = false
   * Opciones soporta:
   * 	recipients	Destinatarios	Requerido Puede ser un string de emails separados por coma o un array de emails.
   * 	sender		Emisor		Requerido (array) con 'name' y 'email'
   * 	subject		Asunto		Requerido (string)
   * 	body 		Cuerpo 		REQUERIDO (string)
   * 	replyTo		Setea el replyTo (string) email . Default 
   * 	attachments	Archivos adjuntos (array) de archivos
   * 	usePhpMail	Especifica si usa php mail para este envio (bool)
   *
   * @return bool
   * @author maui .-
   * */
  static public function sendMail($options) {

    if (!isset($options['recipients']))
      throw new Exception('Envio de mail sin destinatario');
    else {
      if (!is_array($options['recipients']))
        $recipients = explode(',', $options['recipients']);
      else
        $recipients = $options['recipients'];
    }

    if (!isset($options['sender']))
      throw new Exception('Envio de mail sin datos de envío');
    else
      $sender = $options['sender'];


    if (!isset($options['subject']))
      throw new Exception('Envio de mail sin asunto');
    else
      $subject = $options['subject'];

    if (!isset($options['body']))
      throw new Exception('Envio de mail sin cuerpo');
    else
      $body = $options['body'];

    $replyTo = null;
    if (isset($options['replyTo']))
      $replyTo = $options['replyTo'];

    $attachments = null;
    if (isset($options['attachments']))
      $attachments = $options['attachments'];

    if (isset($options['usePhpMail']))
      $sendUsingPhpMail = $options['usePhpMail'];
    else
      $sendUsingPhpMail = sfConfig::get('app_php_mailer_enabled', false);

    if ($sendUsingPhpMail)
      return self::sendPhpMail($recipients, $sender, $subject, $body);
    else
      return self::sendSwiftMail($sender, $recipients, $subject, $body, true, $replyTo, $attachments);
  }

}

?>
