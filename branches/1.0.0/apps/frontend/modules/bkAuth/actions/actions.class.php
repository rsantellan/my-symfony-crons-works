<?php

/**
 * bkAuth actions.
 *
 * @package    bkAuth
 * @subpackage bkAuth
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bkAuthActions extends sfActions {

  public function executeIndex(sfWebRequest $request) {
    if($request->isMethod('POST')){

      try{

				$this->form = new mdLoginForm();

				$postParameters = $request->getPostParameter($this->form->getName());

				$this->form->bind($postParameters);

				if ($this->form->isValid()) {

				  $user = $this->getUser()->validateLogin($postParameters['username'], $postParameters['password']);
	  
				  $this->getUser()->signIn($user);
	  
				  $this->getUser()->setFlash('notice', 'login success');
	  
				  $this->redirect($request->getReferer());
	  
				}else{

				  //$this->getUser()->setFlash('error', 'activation fail');

				}

      }catch(Exception $e){

				$this->getUser()->setFlash('error', $e->getMessage());

      }
      
    }    
  }
  
  public function executeActivation(sfWebRequest $request) {
    
    if($request->isMethod('POST'))
    {
      
      sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');

      try{

	$this->form = new resetPasswordForm();

	$postParameters = $request->getPostParameter($this->form->getName());

	$this->form->bind($postParameters);

	if ($this->form->isValid()) {

	  progenitor::resetPassword($postParameters['email'], $postParameters['password']);
	  
	  $this->getUser()->setFlash('notice', 'activation success');
	  
	  $this->redirect('@homepage');
	  
	}else{

	  $this->getUser()->setFlash('error', 'activation fail');

	}

      }catch(Exception $e){

	$this->getUser()->setFlash('error', $e->getMessage());

      }
      
    }
    else
    {
      
      try{

	$progenitor = progenitor::checkActiveParameters($request->getParameter('code'));

	$this->form = new resetPasswordForm();

	$this->form->setDefault('email', $progenitor->getMail());

      }catch(Exception $e){

	$this->getUser()->setFlash('error', $e->getMessage());

      }

    }
    
  }

  public function executeLogout(sfWebRequest $request) {
    if ($this->getUser()->isAuthenticated()) {
      $this->getUser()->signOut();
    }
    return $this->redirect('@homepage');
  }
  
  /*public function executeForgotPassword(sfWebRequest $request) {
    sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
    
    try {
      $form = new mdForgotPassForm();
      
      $postParameters = $request->getPostParameter($form->getName());

      $form->bind($postParameters);

      if ($form->isValid()) {

        zazUser::forgotPassword($postParameters['email']);
        
        return $this->renderText(mdBasicFunction::basic_json_response(true, array('message' => __('Login_Se ha enviado un mail a su casilla para resetear su password'))));
        
      } else {
        
        return $this->renderText(mdBasicFunction::basic_json_response(false, array('message' => __('Login_El email ingresado es invalido'))));
        
      }
      
    } catch(Exception $e){
      
      return $this->renderText(mdBasicFunction::basic_json_response(false, array('message' => $e->getMessage())));
      
    }
  }
  
  public function executeResetPassword(sfWebRequest $request) {
    
    $code = $request->getParameter('code');

    try{
      
      $email = zazUser::checkResetParameters($code);
      
      $this->form = new resetPasswordForm();
      $this->form->setDefault('email', $email);
      
    }catch(Exception $e){
      
      $this->getUser()->setFlash('error', $e->getMessage());
      
    }
    
  }
  
  public function executeDoResetPassword(sfWebRequest $request) {
    sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');

    try{
      
      $form = new resetPasswordForm();
      
      $postParameters = $request->getPostParameter($form->getName());

      $form->bind($postParameters);

      if ($form->isValid()) {

        zazUser::resetPassword($postParameters['email'], $postParameters['password']);
        return $this->renderText(mdBasicFunction::basic_json_response(true, array('message' => __('Login_Contrasenia cambiada'))));

      }else{

        return $this->renderText(mdBasicFunction::basic_json_response(false, array( 'message' => $this->getPartial('zazAuth/resetForm', array('form' => $form)) )));

      }

    }catch(Exception $e){

      return $this->renderText(mdBasicFunction::basic_json_response(false, array( 'message' => $this->getPartial('zazAuth/resetForm', array('form' => $form, 'error_message' => $e->getMessage())) )));

    }
    
  }*/

}
