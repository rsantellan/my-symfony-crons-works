<?php

/**
 * Description of cronFunctions
 *
 * @author chugas
 */
class cronFunctions {

  public static function sendNewsletters($limit) {

    $record = Doctrine::getTable('emails')->findOneByType('newsletter', Doctrine_Core::HYDRATE_ARRAY);
    if ($record) {
      $emails['from_name'] = $record['from_name'];
      $emails['from_mail'] = $record['from_mail'];
    } else {
      $emails = array(
          'from_name' => 'Bunnys Kinder',
          'from_mail' => 'info@bunnyskinder.com.uy'
      );
    }

    $mdNewsletterSends = Doctrine::getTable('mdNewsletterSend')->scheduledSend($limit);

    $now = new Doctrine_Expression('NOW()');

    foreach ($mdNewsletterSends as $mdNewsletterSend) {

      $mdNewsletterContentSend = $mdNewsletterSend->getMdNewsletterContentSended();
      $email = $mdNewsletterSend->getMdNewsLetterUser()->getMdUser()->getEmail();
      if ($email != "") {
        try{
          mdMailHandler::sendSwiftMail(array('name' => $emails['from_name'], 'email' => $emails['from_mail']), $email, $mdNewsletterContentSend->getSubject(), $mdNewsletterContentSend->getBody(), false, false, array(), true);
        }catch(Exception $e){
          
        }
      }

      $total = ($mdNewsletterContentSend->getSendCounter() + 1);
      $sended = ($total >= $mdNewsletterContentSend->getMdNewsletterSend()->count());

      $mdNewsletterContentSend->setSendCounter($total);
      $mdNewsletterContentSend->setSended($sended);
      $mdNewsletterContentSend->save();

      $mdNewsletterSend->setSendingDate($now);
      $mdNewsletterSend->save();
      
      sleep(1);
      
    }
  }

}

?>
