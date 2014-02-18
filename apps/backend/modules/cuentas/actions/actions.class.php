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
    return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
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
    //$this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdMediaContentAdmin', 'clean.php').'/clean');
  }

  public function executePrintPdfAccount(sfWebRequest $request)
  {
    
    $this->forward404Unless($this->cuenta = (Doctrine::getTable('cuenta')->find($request->getParameter('id'))), sprintf('La cuenta con id (%s) no existe.', $request->getParameter('id')));
    cuenta::exportToPdf($this->cuenta);
    die(0);
//    
//    $this->facturas = Doctrine::getTable('facturaFinal')->retrieveAllUnpaidFromAccountId($this->cuenta->getId(), 'asc');
//    $alumnos = "";
//    $apellido = "";
//    foreach($this->cuenta->getCuentausuario() as $cuentaUsuario)
//    {
//      $alumnos .= $cuentaUsuario->getUsuario()->getNombre() . ",";
//      $apellido = $cuentaUsuario->getUsuario()->getApellido();
//    }
//    $alumnos =  rtrim($alumnos, ',');
//    
//    $padres = "";
//    foreach($this->cuenta->getCuentapadre() as $cuentaPadre)
//    {
//      $padres .= $cuentaPadre->getProgenitor()->getNombre() . " ".$apellido. ",";
//    }
//    $padres = rtrim($padres, ',');
//    
//    $pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
//    $cantidadFacturas = count($this->facturas);
//    $cantidadFacturasDetalles = 0;
//    $facturasDetailList = array();
//    
//    foreach($this->facturas as $factura)
//    {
//      foreach($factura->getFacturaFinalDetalle() as $facturaDetalle)
//      {
//        $facturasDetailList[$cantidadFacturasDetalles] = $facturaDetalle;
//        $cantidadFacturasDetalles++;
//      }
//      if($factura->getPagadodeltotal() > 0)
//      {
//        $facturaDetalleAux = new facturaFinalDetalle();
//        $facturaDetalleAux->setId(-1);
//        $facturaDetalleAux->setDescription('Pago sobre el total');
//        $facturaDetalleAux->setAmount($factura->getFormatedPagadoDelTotal());
//        $facturasDetailList[$cantidadFacturasDetalles] = $facturaDetalleAux;
//        $cantidadFacturasDetalles++;
//      }
//    }
//    $maxPerPage = 30;
//    $cantidadPaginas = $cantidadFacturasDetalles / $maxPerPage;
//    $cantidadFacturasDetalles = 0;
//    $pagina = 1;
//    while($cantidadPaginas >= 0 && $cantidadFacturasDetalles < count($facturasDetailList))
//    {
//      $pdf->AddPage();
//      $pdf->addPageNumber($pagina);
//      $pdf->addSociete( "", "");
//      $pdf->temporaire( "Bunny's Kinder" );
//      $pdf->addDate( date('d/m/Y'));
//      $pdf->addClient($this->cuenta->getReferenciabancaria());
//      $pdf->addAlumnos($alumnos);
//      $pdf->addPadres($padres);
//      $cols=array( 'Item'  => 30,
//                  html_entity_decode("Descripci&oacute;n")    => 130,
//                   "Precio"  => 30
//                  );
//      $pdf->addCols( $cols);
//      $cols=array( 'Item'  => 'C',
//                  html_entity_decode("Descripci&oacute;n")    => "C",
//                   "Precio"  => "C"
//                   );
//      $pdf->addLineFormat($cols);
//      $y    = 70;
//      $size = 0;
//      $counterItems = 1;
//      while($cantidadFacturasDetalles <= $maxPerPage * $pagina && $cantidadFacturasDetalles < count($facturasDetailList))
//      {
//        $facturaDetalle = $facturasDetailList[$cantidadFacturasDetalles];
//        $line = array(
//                'Item' => $counterItems,
//                html_entity_decode("Descripci&oacute;n")    => $facturaDetalle->getDescription(),
//               "Precio"  => '$'.$facturaDetalle->getFormatedAmount()
//        );
//        $size = $pdf->addLine( $y, $line );
//        $y   += $size + 2;
//        $counterItems++;
//        $cantidadFacturasDetalles++;
//      }
//      $pagina++;
//      $cantidadPaginas--;
//    }
//    $pdf->addCadreEurosFrancs('$ '.$this->cuenta->getFormatedDiferencia());
//    $outputName = sprintf('Cuenta-%s-%s.pdf',$this->cuenta->getReferenciabancaria(), date('m-Y'));
//    $pdf->Output($outputName, 'I');
//    die(0);
  }  
  
}
