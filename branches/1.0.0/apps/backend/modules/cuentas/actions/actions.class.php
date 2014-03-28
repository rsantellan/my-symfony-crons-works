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
    $this->cuentasActive = $cuentas['active'];
    var_dump(count($cuentas['active']));
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($this->cuenta = (Doctrine::getTable('cuenta')->find($request->getParameter('id'))), sprintf('La cuenta con id (%s) no existe.', $request->getParameter('id')));
    $this->facturas = Doctrine::getTable('facturaFinal')->retrieveAllDataFromAccountId($this->cuenta->getId(), 'desc');
    $this->cobros = Doctrine::getTable('cobro')->retrieveOfAccount($this->cuenta->getId());
  }
  
  public function executeCancelarFactura(sfWebRequest $request)
  {
    $this->forward404Unless($this->factura = (Doctrine::getTable('facturaFinal')->find($request->getParameter('id'))), sprintf('La factura con id (%s) no existe.', $request->getParameter('id')));
    $response = false;
    try{
      $response = facturaHandler::cancelFactura($this->factura);
      if($response)
      {
        $message = 'Factura cancelada';
      }
      else
      {
        $message = 'La factura se encuentra paga o ya esta cancelada';
      }
    }catch(Exception $e)
    {
      $message = $e->getMessage();
    }
    return $this->renderText(mdBasicFunction::basic_json_response($response, array('facturaId' => $this->factura->getId(), 'message' => $message)));
  }
  
  public function executeMail(sfWebRequest $request)
  {
    $this->forward404Unless($cuenta = (Doctrine::getTable('cuenta')->find($request->getParameter('id'))), sprintf('La cuenta con id (%s) no existe.', $request->getParameter('id')));
    $usuario = $cuenta->getCuentausuario()->get(0)->getUsuario();
    usuario::sendCuentaEmail($cuenta, $usuario);
    return $this->renderText(mdBasicFunction::basic_json_response(true, array('message'=> 'El mail a sido enviado con exito.')));
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
    $response = false;
    $message = '';
    $accountId = '';
    $monto = 0;
    $removePanel = false;
    if ($this->form->isValid())
    {
      $cobro = $this->form->save();
      usuario::sendCobroEmail($cobro);
      $accountId = $cobro->getCuentaId();
      $monto = $cobro->getCuenta()->getFormatedDiferencia();
      $message = 'Cobro ingresado con exito.';
      if($cobro->getCuenta()->getDiferencia() <= 0)
      {
        $removePanel = true;
        $message .= ' La cuenta no tiene mas deudas';
      }
      $response = true;
    }
    $partial = $this->getPartial('cuentas/cobroform', array('form' => $this->form));
    return $this->renderText(mdBasicFunction::basic_json_response($response, array('removePanel' => $removePanel, 'accountId' => $accountId, 'monto'=>$monto, 'partial' => $partial, 'message' => $message)));
  }
  
  public function executeTestEmail(sfWebRequest $request)
  {
    $this->forward404Unless($this->cuenta = (Doctrine::getTable('cuenta')->find($request->getParameter('id'))), sprintf('La cuenta con id (%s) no existe.', $request->getParameter('id')));
    $this->facturas = Doctrine::getTable('facturaFinal')->retrieveAllUnpaidFromAccountId($this->cuenta->getId(), 'asc');
//  $html = $this->getPartial('cuentas/cuentaMail', array('cuenta' => $this->cuenta, 'facturas' => $this->facturas));
//	$dom_pdf = new sfDomPDFPlugin($html);
//	$dom_pdf->setBasePath(sfConfig::get('sf_web_dir'));
//	$dom_pdf->getPDF()->render();
//	$dom_pdf->getPDF()->stream("jardin-" . date('d-m-Y') . ".pdf");
//	die(0);
    $this->setLayout('clean');
  }

  public function executePrintPdfAccount(sfWebRequest $request)
  {
    
    $this->forward404Unless($this->cuenta = (Doctrine::getTable('cuenta')->find($request->getParameter('id'))), sprintf('La cuenta con id (%s) no existe.', $request->getParameter('id')));
    cuenta::exportToPdf($this->cuenta);
    die(0);
  }
  
  public function executePrintPdfCobro(sfWebRequest $request)
  {
    $this->forward404Unless($cobro = (Doctrine::getTable('cobro')->find($request->getParameter('id'))), sprintf('El cobro con id (%s) no existe.', $request->getParameter('id')));
    cuenta::exportCobroToPdf($cobro);
  }
  
  public function executeTestPrintCobro(sfWebRequest $request)
  {
    throw new Exception("No deberia de estar aca");
    $cobro = Doctrine::getTable('cobro')->find(3);
    $cuenta = $cobro->getCuenta();
    $usuario = $cuenta->getCuentausuario()->getFirst()->getUsuario();
    //$usuario = $usuarioCuenta->getUsuario();
    //var_dump(get_class($usuario));
    //var_dump('aaaca');die;
    usuario::sendCobroEmail($cobro);
    cuenta::exportCobroToPdf($cobro, $cuenta);
  }
  
}
