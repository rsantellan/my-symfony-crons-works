<?php

require_once dirname(__FILE__).'/../lib/galeriaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/galeriaGeneratorHelper.class.php';

/**
 * galeria actions.
 *
 * @package    ulapsi
 * @subpackage galeria
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class galeriaActions extends autoGaleriaActions
{
	public function executePromote()
	{
	  $object=Doctrine::getTable('mdGaleria')->findOneById($this->getRequestParameter('id'));


	  $object->promote();
	  $this->redirect("@md_galeria");
	}

	public function executeDemote()
	{
	  $object=Doctrine::getTable('mdGaleria')->findOneById($this->getRequestParameter('id'));

	  $object->demote();
	  $this->redirect("@md_galeria");
	}
  protected function buildQuery()
  {
		$q = parent::buildQuery();
    $q->addOrderBy('position asc');
		return $q;
	}
}
