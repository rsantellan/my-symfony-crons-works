<?php

/**
 * contacto actions.
 *
 * @package    institucional
 * @subpackage contacto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdContactActions extends sfActions
{
    /**
    * Executes index action
    *
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request)
    {
        $this->form = new mdContactForm();

        if($request->isMethod('post'))
        {
            $params = $request->getParameter('contacto');

            $this->form->bind($params);
            
            if ($this->form->isValid()){
            	if($this->sendMail()){
								$this->form = new mdContactForm();
							}
            }
        }

				mdMetaTagsHandler::addMetas($this,sfConfig::get('app_mdContactPlugin_meta', 'contacto'));
    }

  public function executeOptions(sfWebRequest $request)
  {
        $this->form = new mdContactForm();

        if($request->isMethod('post'))
        {
            $area = $request->getParameter("area");
            $this->forward404Unless($area);
            $params = $request->getParameter('contacto');
            $this->form->bind($params);
            if ($this->form->isValid()){
                $mdMailXMLHandler = new mdMailXMLHandler();
                $subject = (string) $mdMailXMLHandler->getContactTitle();
                //$subject = sfConfig::get('app_title_contact');
                $body = $this->getPartial('mail', array('form' => $this->form));
                $this->getUser()->setFlash('mdContactSend','Send');
                mdMailHandler::sendSwiftMail($this->form->getValue('mail'), $area, $subject, $body, true, $this->form->getValue('mail'));
                //mdMailHandler::sendMdContactMail($body, $subject, $this->form->getValue('mail'));
            }
        }    
  }

  public function executeMdContactViaAjax(sfWebRequest $request)
  {
    $this->form = new mdContactForm();
    
    $params = $request->getParameter('contacto');

    $this->form->bind($params);

    $salida = array();
    if ($this->form->isValid()){
			$salida['result'] = (integer) $this->sendMail();	
    }else{
      $salida['result'] = 0;
    }
    
    $salida['body'] = $this->getPartial('mdContactForm', array('form'=>$this->form));
    return $this->renderText(json_encode($salida));
  }


	/**
	 * Envia el correo del contacto
	 *
	 * @return void
	 * @author maui .-
	 */

		private function sendMail(){

	    $mdMailXMLHandler = new mdMailXMLHandler();

			$form = $this->form;
			$form->offsetUnset($form->getCSRFFieldName());
			$param['body'] = $this->getPartial('mail', array('form' => $form));
			
			$param['subject'] = $mdMailXMLHandler->getContactTitle();

	    $recipientString = (string) $mdMailXMLHandler->getRecipient();
	    $param['recipients'] = explode(",", $recipientString);

			if($mdMailXMLHandler->getFromClient() == 0){
				$param['sender'] = array('name' => $mdMailXMLHandler->getFrom(),'email' => $mdMailXMLHandler->getEmail());
			}else{
				$param['sender'] = array('name' => $this->form->getValue('nombre'),'email'=>$this->form->getValue('mail'));
			}

			if(mdMailHandler::sendMail($param)){
	    	$this->getUser()->setFlash('mdContactSend',true);
				return true;
			}else{
				$this->getUser()->setFlash('mdContactSend','Error de envío');
				return false;
			}
		}

}
