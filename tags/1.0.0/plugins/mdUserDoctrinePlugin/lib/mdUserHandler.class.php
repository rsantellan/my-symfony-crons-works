<?php

class mdUserHandler {

    public static function retrieveMdUser($mdUserId) {
        return Doctrine::getTable('mdUser')->find($mdUserId);
    }

    /**
     * TODO fijarse cual es el metodo mas efectivo.
     **/ 
    public static function retrieveMdUserProfileWithMdUserId($mdUserId)
    {
      return Doctrine::getTable('mdUserProfile')->findByMdUserId($mdUserId);

      /*
      $mdUser = self::retrieveMdUser($mdUserId);
      if($mdUser)
      {
        return $mdUser->getMdUserProfile();
      }
      else
      {
        return NULL;
      }
      */ 
    }
    public static function retrieveMdUserProfile($mdUserProfileId) {
        return Doctrine::getTable('mdUserProfile')->find($mdUserProfileId);
    }

    public static function retrieveMdPassportWithMdUserEmail($email) {
        return Doctrine::getTable('mdPassport')->retrieveMdPassportByMdUserEmail($email);
    }

    public static function retrieveMdPassportWithMdUserId($mdUserId) {
        return Doctrine::getTable('mdPassport')->retrieveMdPassportByUserId($mdUserId);
    }
    
    public static function checkEmailOfMdUser($mdUserEmail, $email) {
        if (strcmp($mdUserEmail, $email) == 0) {
            return true;
        } else {
            $mdUser = Doctrine::getTable('mdUser')->findOneby('email', $email);
            if ($mdUser) {
                return false;
            }
        }
        return true;
    }

    public static function sendUserMail($subject, $from, $to, $body) {

        sfContext::getInstance ()->getLogger()->info('<!! Estoy mandando el mail !!>');

        $mailer = sfContext::getInstance ()->getMailer();

        $message = Swift_Message::newInstance ()
                        ->setSubject($subject)
                        ->setFrom(array($from => $from))
                        ->setTo(array($to))
                        ->setContentType("text/html")
                        ->setBody($body);

        $mailer->send($message);
    }

    /**
     * Create a activation url base on the email of the person.
     *
     * @param email $email
     * @return the direction
     */
    public static function getActivationUrl(mdPassport $mdPassport) {
        $createdAt = $mdPassport->getCreatedAt();
        $id = $mdPassport->getId();
        $base = base64_encode($id . '*' . $createdAt);
        return 'confirmation=' . $base;
    }

    public static function validateUser($token) {
        $base = base64_decode($token);
        $parts = explode("*", $base);
        $loginWindow = sfConfig::get('app_time_of_confirmation');
        $days = $loginWindow * 24 * 60 * 60;
        $date = time ();
        $time = $date - mdBasicFunction::convert_datetime($parts[1]);
        if ($time < $days) {
            $mdUserContent = Doctrine::getTable('mdUserContent')->find($parts [0]);
            $mdUserContent->setAccountActive(true);
            $mdUserContent->save();
            return $mdUserContent;
        } else {
            return null;
        }
    }

    public static function retrieveAllEmailsInArray()
    {
        $users = Doctrine::getTable('mdUser')->findAll();
        $list = array();
        $list[''] = '';
        foreach($users as $user)
        {
            $list[$user->getEmail()] = $user->getEmail();
        }
        return $list;
    }

    public static function retrieveAllEmailsInArrayWithIdKey()
    {
        $users = Doctrine::getTable('mdUser')->findAll();
        $list = array();
        $list[''] = '';
        foreach($users as $user)
        {
            $list[$user->getId()] = $user->getEmail();
        }
        return $list;
    }
    
    public static function retrieveAllMdUserProfiles($excludeIds = array(), $onlyActive = true, $withProfile = 0, $isQuery = true)
    {
        return Doctrine::getTable("mdUserProfile")->retrieveAllMdUserProfiles($excludeIds, $onlyActive, $withProfile, $isQuery);
    }

    public static function retrieveMdUserSimpleQuery()
    {
        return Doctrine::getTable('mdUser')->retrieveSimpleQuery();
    }

    public static function checkIfEmailExists($email)
    {
        $mdUser = self::retrieveMdUserByEmail($email);
        if($mdUser)
        {
            return true;
        }
        return false;
    }

    public static function retrieveMdUserByEmail($email)
    {
      return Doctrine::getTable("mdUser")->findOneBy("email", $email);
    }

    public static function checkIfUsernameExists($username)
    {
        $mdPassport = Doctrine::getTable('mdPassport')->findOneBy('username', $username);
        if($mdPassport)
        {
            return true;
        }
        return false;
    }

    public static function retrieveAllMdUserProfilesWithNames($name, $lastname, $excludeIds = array(), $onlyActive = true, $isQuery = true)
    {
        $query = Doctrine::getTable("mdUserProfile")->retrieveAllMdUserProfilesWithNames($name, $lastname, $excludeIds, $onlyActive);
        if($isQuery) return $query;
        return $query->execute();
    }
}
