<?php

class mdUserFile {

  var $name;
  var $username;
  var $password;
  var $email;

  /**
   * @return the $name
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return the $username
   */
  public function getUsername() {
    return $this->username;
  }

  /**
   * @return the $password
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * @return the $email
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * @param $name the $name to set
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * @param $username the $username to set
   */
  public function setUsername($username) {
    $this->username = $username;
  }

  /**
   * @param $password the $password to set
   */
  public function setPassword($password) {
    $this->password = $password;
  }

  /**
   * @param $email the $email to set
   */
  public function setEmail($email) {
    $this->email = $email;
  }

  public static function checkUserAndPassword($user, $password) {
    $app = sfContext::getInstance()->getConfiguration()->getApplication();
    $config_dir = sfConfig::get('sf_app_config_dir');
    $xml = simplexml_load_file($config_dir . DIRECTORY_SEPARATOR . sfConfig::get('mdFileAuthXMLFileName', 'mdFileAuthUsers') . ".xml");
    $userList = array();
    foreach ($xml->user as $users) {
      $mdUserFile = new mdUserFile();
      $mdUserFile->setName((string) $users->name);
      $mdUserFile->setUsername((string) $users->user);
      $mdUserFile->setPassword((string) $users->password);
      $mdUserFile->setEmail((string) $users->email);
      $userList[(string) $users->user] = $mdUserFile;
    }
    if (isset($userList[$user])) {
      $fileUser = $userList[$user];
      if ($fileUser->getPassword() == $password) {
        return $fileUser;
      } else {
        return null;
      }
    } else {
      return null;
    }
  }

}
