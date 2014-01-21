<?php

/**
 * static actions.
 *
 * @package    frontend
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mdUserConfirmationActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        if ($this->getUser()->isAuthenticated()) {
            $this->getUser()->signOut();
        }
        
        if (!$request->isMethod(sfRequest::PUT)) {
            $this->confirmation = base64_decode($request->getParameter('confirmation'));

            $exp = explode("_", $this->confirmation);
            $now = time ();
            $this->error = "";
            $this->code = "";
            if ($now - $exp [1] > sfConfig::get('app_confirmation_mail_time', 60 * 60 * 24 * 5)) {
                $this->code = 1;
            }
            $this->mdPassport = Doctrine::getTable('mdPassport')->find($exp [0]);
            if ($exp [2] == $this->mdPassport->getPassword()) {
                $this->form = new mdUserContentResetPasswordForm ( );
                $this->code = 3;
            } else {
                if ($this->mdPassport->resetPassword()) {
                    //Envio el mail
                    mdMailHandler::sendConfirmationMail($this->mdPassport, true, false);
                    $this->code = 2;
                }
            }
        } else {
            
            $dataForm = $request->getPostParameter('login');
            
            $this->mdPassport = Doctrine::getTable('mdPassport')->find($dataForm ['id']);
            $this->form = new mdUserContentResetPasswordForm ( );
            $this->form->bind($this->request->getParameter($this->form->getName()), $this->request->getFiles($this->form->getName()));
            if ($this->form->isValid()) {
                $this->mdPassport->changePassword($dataForm['password']);
                $this->getUser()->signin($this->mdPassport);
                return $this->redirect('@homepage');
            }
            $this->code = 3;
        }
        //var_dump($this->code);die;
    }

    public function executeResetPassword(sfWebRequest $request) {
        //print_r($request->getPostParameters());
    }

    public function executeActivateUser(sfWebRequest $request) {

        if ($this->getUser()->isAuthenticated()) {
            $this->getUser()->signOut();
        }
                
        $this->confirmation = base64_decode($request->getParameter('confirmation'));

        $exp = explode("*", $this->confirmation);
        $now = time ();
        $this->error = "";
        $this->code = "";
        if ($now - $exp [1] > sfConfig::get('app_confirmation_mail_time', 60 * 60 * 12)) {
            $this->code = 1;
        }

        $this->mdPassport = Doctrine::getTable('mdPassport')->find($exp [0]);
        if($this->mdPassport){
          
            if(! $this->mdPassport->getAccountActive()){
                $this->mdPassport->setAccountActive(true);
                $this->mdPassport->save();
                $this->getUser()->signIn($this->mdPassport);
            }
            
        }
        $this->getUser()->setFlash('userActivated', true);
        return $this->redirect('@homepage');

    }

}
