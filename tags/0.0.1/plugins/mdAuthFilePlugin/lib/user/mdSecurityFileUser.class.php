<?php


/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Rodrigo Santellan <rsantellan@gmail.com> 
 * @version    0.2
 */
class mdSecurityFileUser extends sfBasicSecurityUser
{
  protected $user = null;

  /**
   * Initializes the mdSecurityUser object. // This has not been tested yet
   *
   * @param sfEventDispatcher $dispatcher The event dispatcher object
   * @param sfStorage $storage The session storage object
   * @param array $options An array of options
   */
  public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
  {
    parent::initialize($dispatcher, $storage, $options);

    if (!$this->isAuthenticated())
    {
      // remove user if timeout
      //$this->getAttributeHolder()->removeNamespace('mdSecurityUser');
      //$this->user = null;
    }
  }

  /**
   * Returns the referer uri.
   *
   * @param string $default The default uri to return
   * @return string $referer The referer
   */
  public function getReferer($default)
  {
    $referer = $this->getAttribute('referer', $default);
    $this->getAttributeHolder()->remove('referer');

    return $referer;
  }

  /**
   * Sets the referer.
   *
   * @param string $referer
   */
  public function setReferer($referer)
  {
    if (!$this->hasAttribute('referer'))
    {
      $this->setAttribute('referer', $referer);
    }
  }

  /**
   * Returns whether or not the user has the given credential.
   *
   * @param string $credential The credential name
   * @param boolean $useAnd Whether or not to use an AND condition
   * @return boolean
   */
  public function hasCredential($credential, $useAnd = true)
  {
    if (empty($credential))
    {
      return true;
    }

    if (!$this->getMdPassport())
    {
      return false;
    }

    if ($this->getMdPassport()->getIsSuperAdmin())
    {
      return true;
    }

    return parent::hasCredential($credential, $useAnd);
  }

  /**
   * Returns whether or not the user is a super admin.
   *
   * @return boolean
   */
  public function isSuperAdmin()
  {
  	return $this->isAuthenticated();
  }

  /**
   * Returns whether or not the user is anonymous.
   *
   * @return boolean
   */
  public function isAnonymous()
  {
    return !$this->isAuthenticated();
  }

  /**
   * Signs in the user on the application.
   *
   * @param sfGuardUser $user The sfGuardUser id
   * @param boolean $remember Whether or not to remember the user
   * @param Doctrine_Connection $con A Doctrine_Connection object
   */
  public function signIn($user, $remember = false)
  {
    // signin
    $this->setAttribute('user_id', $user->getUsername(), 'mdSecurityUser');
    $this->user = $user;
    $this->setAttribute('user', serialize($this->user), 'mdSecurityUser');
    
    $this->setAuthenticated(true);
    $this->clearCredentials();

    // remember?
    if ($remember)
    {
      $expiration_age = sfConfig::get('app_sf_guard_plugin_remember_key_expiration_age', 15 * 24 * 3600);
      $remember_cookie = sfConfig::get('app_remember_cookie_name', 'sfRemember');

      //setcookie('mdCookie', 'mastodonte', time() + 20000,'/', 'local.institucional.com');
      //setcookie($remember_cookie,'a', time() + $expiration_age);

      sfContext::getInstance()->getResponse()->setCookie($remember_cookie, base64_encode(serialize($user)), time() + $expiration_age);
    }
    
  }

  /**
   * Signs out the user.
   *
   */
  public function signOut()
  {
    $this->getAttributeHolder()->removeNamespace('mdSecurityUser');
    $this->user = null;
    $this->clearCredentials();
    $this->setAuthenticated(false);
    $expiration_age = sfConfig::get('app_sf_guard_plugin_remember_key_expiration_age', 15 * 24 * 3600);
    $remember_cookie = sfConfig::get('app_remember_cookie_name', 'sfRemember');
    sfContext::getInstance()->getResponse()->setCookie($remember_cookie, '', time() - $expiration_age);
  }

  /**
   * Returns the related mdUserFile.
   *
   * @return sfGuardUser
   */
  public function getMdUserFile()
  {
    $this->user = unserialize($this->getAttribute('user',null,'mdSecurityUser'));

    return $this->user;
  }

  /**
   * Returns the string representation of the object.
   *
   * @return string
   */
  public function __toString()
  {
    return $this->getMdUserFile()->__toString();
  }

  /**
   * Returns the sfGuardUser object's username.
   *
   * @return string
   */
  public function getUsername()
  {
    return $this->getMdUserFile()->getUsername();
  }

  /**
   * Returns the sfGuardUser object's email.
   *
   * @return string
   */
  public function getEmail()
  {
    return $this->getMdUserFile()->getEmail();
  }

  /**
   * Returns whether or not the given password is valid.
   *
   * @return boolean
   */
  public function checkPassword($password)
  {
    return $this->getMdUserFile()->checkPassword($password);
  }

  /**
   * Returns whether or not the user belongs to the given group.
   *
   * @param string $name The group name
   * @return boolean
   */
  public function hasGroup($name)
  {
  	return $this->isAuthenticated();
  }

  /**
   * Returns whether or not the user has the given permission.
   *
   * @param string $name The permission name
   * @return string
   */
  public function hasPermission($name)
  {
  	return $this->isAuthenticated();
  }

}
