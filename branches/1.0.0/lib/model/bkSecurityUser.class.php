<?php

class bkSecurityUser extends sfBasicSecurityUser {

  protected $user = null;

  /**
   * Initializes the mdSecurityUser object. // This has not been tested yet
   *
   * @param sfEventDispatcher $dispatcher The event dispatcher object
   * @param sfStorage $storage The session storage object
   * @param array $options An array of options
   */
  public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array()) {
    parent::initialize($dispatcher, $storage, $options);

    if ($this->isAuthenticated()) {
      // Cargo el usuario de sesion si existe, sino existe deslogueo al usuario
      if ($this->hasAttribute('user', 'mdSecurityUser')) {
	$this->user = unserialize($this->getAttribute('user', null, 'mdSecurityUser'));
      } else {
	$this->signOut();
      }
    }
  }

  /**
   * Returns the referer uri.
   *
   * @param string $default The default uri to return
   * @return string $referer The referer
   */
  public function getReferer($default) {
    $referer = $this->getAttribute('referer', $default);
    $this->getAttributeHolder()->remove('referer');

    return $referer;
  }

  /**
   * Sets the referer.
   *
   * @param string $referer
   */
  public function setReferer($referer) {
    if (!$this->hasAttribute('referer')) {
      $this->setAttribute('referer', $referer);
    }
  }

  /**
   * Signs in the user on the application.
   *
   * @param sfGuardUser $user The sfGuardUser id
   * @param boolean $remember Whether or not to remember the user
   * @param Doctrine_Connection $con A Doctrine_Connection object
   */
  public function signIn($user, $remember = false, $con = null) {
    // signin
    $this->setAttribute('user_id', $user->getId(), 'mdSecurityUser');
    $this->user = $user;
    $this->setAttribute('user', serialize($this->user), 'mdSecurityUser');
    $this->setAuthenticated(true);
    $this->clearCredentials();
    $this->addCredential('user');

    // remember?
    if ($remember) {
      $expiration_age = 15 * 24 * 3600;
      $data = array($user->getMail(), $user->getClave());
      sfContext::getInstance()->getResponse()->setCookie('__MD_RMU', base64_encode(serialize($data)), time() + $expiration_age);
    }
  }

  /**
   * Signs out the user.
   *
   */
  public function signOut() {
    $this->getAttributeHolder()->removeNamespace('mdSecurityUser');
    $this->user = null;
    $this->clearCredentials();
    $this->setAuthenticated(false);

    // Borro la cookie del remember me
    $expiration_age = 15 * 24 * 3600;
    sfContext::getInstance()->getResponse()->setCookie('__MD_RMU', '', time() - $expiration_age);
  }

  public function getUsuario() {
    return $this->user;
  }

  public function validateLogin($mail, $password) {

    $user = Doctrine::getTable('progenitor')->findOneByMailAndClave($mail, $password);
    if (!$user) {
      throw new Exception('authentication fail', -1);
    }
    return $user;
    
  }

}
