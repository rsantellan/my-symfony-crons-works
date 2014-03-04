<?php

require_once dirname(__FILE__).'/../lib/pagosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/pagosGeneratorHelper.class.php';

/**
 * pagos actions.
 *
 * @package    jardin
 * @subpackage pagos
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pagosActions extends autoPagosActions
{
  public function executePrint(sfWebRequest $request)
  {
    $pager = $this->configuration->getPager('pagos');
    $pager->setQuery($this->buildQuery());
    $pager->setMaxPerPage(10000);
    $pager->init();    
    $this->pager = $pager;
    $this->setLayout(false);
  }  
}
