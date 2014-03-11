<?php

/**
 * mdUserContent actions.
 *
 * @package    combaGol
 * @subpackage mdAuth
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdFileAuthActions extends sfActions {
	
  public function executeSignin(sfWebRequest $request) 
  {
    //print_r($request->getUri()); die();
    $automaticUriToGo = '';
    if (! $this->getUser ()->hasFlash ( 'uriToGo' )) {
      $automaticUriToGo = $this->getUser ()->setFlash ( 'uriToGo', $request->getUri () );
    } else {
      $automaticUriToGo = $this->getUser ()->getFlash ( 'uriToGo' );
    }

    $this->form = new mdPassportLoginForm ( );

    if ($request->isMethod ( 'post' )) {
      $this->form->bind ( $request->getParameter ( $this->form->getName () ) );
      if ($this->form->isValid ()) {

        $values = $this->form->getValues ();
        $user = mdUserFile::checkUserAndPassword($values ['username'], $values ['password']);
        if ($user) {
          $this->getUser ()->signin ( $user, $values ['remember'] );
          // authenticate user and redirect them
          $this->getUser ()->setAuthenticated ( true );
          $this->getUser ()->addCredential ( 'user' );
          $uri = "";
          try {
            if ($automaticUriToGo) {
              $uri = $automaticUriToGo;
            } else {
              $uri = $request->getPostParameter ( 'uriToGo', '@homepage' );
            }
          } catch ( Exception $e ) {
            $uri = $request->getPostParameter ( 'uriToGo', '@homepage' );
          }
          $uri = $request->getPostParameter ( 'uriToGo', '@homepage' );
          $this->redirect ( $uri );
          return true;
        }else{
          $this->exception = 'Usuario y/o clave incorrecta';
        }
      }
    }
    $this->setLayout('layout_logout');
  }

  public function executeSecure($request) {
    $this->getResponse ()->setStatusCode ( 403 );
  }

  public function executeLogout() {
    $this->getUser ()->signOut ();
    return $this->redirect ( '@homepage' );
  }

}
