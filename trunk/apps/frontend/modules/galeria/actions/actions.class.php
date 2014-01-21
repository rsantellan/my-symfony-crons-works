<?php

/**
 * galeria actions.
 *
 * @package    jardin
 * @subpackage galeria
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class galeriaActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
	
		$padre = $this->getUser()->getUsuario();
		$hijos = $padre->getHijos();
		$this->galerias = array();
		$grupos = array();
		foreach($hijos as $hijo){
			if(!in_array($hijo->getClase(), $grupos)){
				$this->galerias[$hijo->getClase()] = Doctrine::getTable('mdGaleria')->findByGroup($hijo->getClase());
				$grupos[] = $hijo->getClase();
			}
		}
		$this->grupos = $grupos;

  }
	/**
	 * Executes Show gallery action
	 *
	 */
	public function executeShow(sfWebRequest $request)
	{
	  $this->galeria = $this->getRoute()->getObject();
	
	}
}
