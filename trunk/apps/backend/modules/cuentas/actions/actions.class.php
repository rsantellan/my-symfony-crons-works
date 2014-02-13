<?php

/**
 * cuentas actions.
 *
 * @package    jardin
 * @subpackage cuentas
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cuentasActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $cuentas = accountsHandler::retrieveAllSeparatedAccountsWithUsersAndParentsByDifference();
    $this->cuentasPositive = $cuentas['positive'];
    $this->cuentasNegative = $cuentas['negative'];
    $this->cuentasZero = $cuentas['zero'];
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($this->cuenta = (Doctrine::getTable('cuenta')->find($request->getParameter('id'))), sprintf('La cuenta con id (%s) no existe.', $request->getParameter('id')));
    
    $this->facturas = Doctrine::getTable('facturaFinal')->retrieveAllDataFromAccountId($this->cuenta->getId());
    
    $this->cobros = Doctrine::getTable('cobro')->retrieveOfAccount($this->cuenta->getId());
  }
  
  public function executeCobroForm(sfWebRequest $request)
  {
    $accountId = $request->getParameter('id');
    $cobro = new cobro();
    $cobro->setCuentaId($accountId);
    $this->form = new cobroForm($cobro);
  }
  
  public function executeDoCobroForm(sfWebRequest $request)
  {
    $this->form = new cobroForm();
    $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid())
    {
      $this->form->save();
    }
    $response = true;
    $message = 'nanana';
    return $this->renderText(mdBasicFunction::basic_json_response($response, array('message' => $message)));
  }
}
