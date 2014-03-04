<?php

/**
 * default actions.
 *
 * @package    jardin
 * @subpackage default
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }

	/**
	 * Executes Filosofia action
	 *
	 */
	public function executeFilosofia(sfWebRequest $request)
	{
	  
	}
	
	/**
	 * Executes Historia action
	 *
	 */
	public function executeHistoria(sfWebRequest $request)
	{
	  
	}
	
	/**
	 * Executes Actividades action
	 *
	 */
	public function executeActividades(sfWebRequest $request)
	{


		$this->actividades = array('Ingles','Plastica','Musica', 'Gym', 'Psico', 'Natacion','Paseos');
		//agrego actividades al i18n
/*		foreach($this->actividades as $act):
			mdI18nTranslatorHandler::addNewWordToCatalogue('frontend', 'Actividades', $act . ' Titulo');
			mdI18nTranslatorHandler::addNewWordToCatalogue('frontend', 'Actividades', $act . ' Texto');
		endforeach;
*/	  
	}
	
	/**
	 * Executes Inscripciones action
	 *
	 */
	public function executeInscripciones(sfWebRequest $request)
	{
		
		$this->form = new inscripcionesForm();

		if ($request->isMethod('post')) {
      $params = $request->getParameter($this->form->getName());

      $this->form->bind($params);

      if ($this->form->isValid()) {
				$param['body'] = $this->getPartial('mail_inscripciones', array('values'=>$this->form->getValues()));

			  $mdMailXMLHandler = new mdMailXMLHandler();

		    $recipientString = (string) $mdMailXMLHandler->getRecipient();
		    $param['recipients'] = explode(",", $recipientString);

			  $param['sender'] = array('name' => $mdMailXMLHandler->getFrom(), 'email' => $mdMailXMLHandler->getEmail());
				$param['subject'] = "Nueva inscripción desde el sitio web";

				if (mdMailHandler::sendMail($param)) {
					$this->message_send = true;
					$this->form = new inscripcionesForm();
				}else{
					$this->message_send = false;
				}
			  
      }
    }

	}
	
}
