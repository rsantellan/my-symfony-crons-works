<?php

/**
 * mdGaleria form.
 *
 * @package    ulapsi
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdGaleriaForm extends BasemdGaleriaForm
{
  public function configure()
  {
		unset($this['position']);
	  // Un solo idioma a la vez
    $this->embedI18n(array(sfContext::getInstance()->getUser()->getCulture()));
		$this->getWidgetSchema()->moveField(sfContext::getInstance()->getUser()->getCulture(), sfWidgetFormSchema::FIRST);
  
  
  }
}

