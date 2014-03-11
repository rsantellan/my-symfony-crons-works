<?php

/**
 * cuenta
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jardin
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class cuenta extends Basecuenta
{
  public function preSave($event) {
    $this->setDiferencia($this->getDebe() - $this->getPago());
    parent::preSave($event);
  }
  
  public function getFormatedDiferencia()
  {
    if($this->getDiferencia() < 0)
    {
      return number_format(- $this->getDiferencia(), 0, ',', '.');
    }
    return number_format($this->getDiferencia(), 0, ',', '.');
  }

  public static function exportCobroToPdf($cobro, $cuenta = NULL, $location = NULL)
  {
    if($cuenta === NULL){
      $cuenta = $cobro->getCuenta();
    }
    $alumnos = "";
    $apellido = "";
    foreach($cuenta->getCuentausuario() as $cuentaUsuario)
    {
      $alumnos .= $cuentaUsuario->getUsuario()->getNombre() . ",";
      $apellido = $cuentaUsuario->getUsuario()->getApellido();
    }
    $alumnos =  rtrim($alumnos, ',');
    
    $padres = "";
    foreach($cuenta->getCuentapadre() as $cuentaPadre)
    {
      $padres .= $cuentaPadre->getProgenitor()->getNombre() . " ". ",";
    }
    $padres = rtrim($padres, ',');
    $pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
    
    $pdf->AddPage();
    $pdf->addSociete( "", "");
    $pdf->temporaire( "Bunny's Kinder" );
    $pdf->addDate( date('d/m/Y'));
    $pdf->addClient($cuenta->getReferenciabancaria());
    $pdf->addAlumnos($alumnos);
    $pdf->addPadres($padres);
    $cols=array( 'Item'  => 30,
                html_entity_decode("Descripci&oacute;n")    => 130,
                 "Precio"  => 30
                );
    $pdf->addCols( $cols);
    $cols=array( 'Item'  => 'C',
                html_entity_decode("Descripci&oacute;n")    => "C",
                 "Precio"  => "C"
                 );
    $pdf->addLineFormat($cols);
    $y    = 70;
    $size = 0;
    $counterItems = 1;
    $line = array(
            'Item' => $counterItems,
            html_entity_decode("Descripci&oacute;n")    => sprintf('Pago en la fecha: %s', $cobro->getFecha()),
           "Precio"  => '$'.$cobro->getFormatedMonto()
    );
    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;
    
    $pdf->addCadreEurosFrancs('$ '.$cobro->getFormatedMonto());
    $outputOption = 'I';
    if($location !== null)
    {
      if(!is_dir($location))
      {
        $location = sys_get_temp_dir();
      }
      $outputOption = 'F';
      $location .= DIRECTORY_SEPARATOR;
    }
    else 
    {
      $location = '';
    }
    $outputName = sprintf('Pago-cuenta-%s-%s.pdf',$cuenta->getReferenciabancaria(), date('m-Y'));
    $pdf->Output($location.$outputName, $outputOption);
    if($outputOption == 'F')
    {
      return $location.$outputName;
    }
    die(0);
  }
  
  // sys_get_temp_dir()
  public static function exportToPdf($cuenta, $location = NULL)
  {
    //$cuenta = Doctrine::getTable('cuenta')->find($accountId);
    $facturas = Doctrine::getTable('facturaFinal')->retrieveAllUnpaidFromAccountId($cuenta->getId(), 'asc');
    $alumnos = "";
    $apellido = "";
    foreach($cuenta->getCuentausuario() as $cuentaUsuario)
    {
      $alumnos .= $cuentaUsuario->getUsuario()->getNombre() . ",";
      $apellido = $cuentaUsuario->getUsuario()->getApellido();
    }
    $alumnos =  rtrim($alumnos, ',');
    
    $padres = "";
    foreach($cuenta->getCuentapadre() as $cuentaPadre)
    {
      $padres .= $cuentaPadre->getProgenitor()->getNombre() . " ". ",";
    }
    $padres = rtrim($padres, ',');
    
    $pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
    $cantidadFacturas = count($facturas);
    $cantidadFacturasDetalles = 0;
    $facturasDetailList = array();
    
    foreach($facturas as $factura)
    {
      foreach($factura->getFacturaFinalDetalle() as $facturaDetalle)
      {
        $facturasDetailList[$cantidadFacturasDetalles] = $facturaDetalle;
        $cantidadFacturasDetalles++;
      }
      if($factura->getPagadodeltotal() > 0)
      {
        $facturaDetalleAux = new facturaFinalDetalle();
        $facturaDetalleAux->setId(-1);
        $facturaDetalleAux->setDescription('Pago sobre el total');
        $facturaDetalleAux->setAmount($factura->getFormatedPagadoDelTotal());
        $facturasDetailList[$cantidadFacturasDetalles] = $facturaDetalleAux;
        $cantidadFacturasDetalles++;
      }
    }
    $maxPerPage = 30;
    $cantidadPaginas = $cantidadFacturasDetalles / $maxPerPage;
    $showPages = true;
    if($cantidadPaginas < 1)
    {
      $showPages = false;
    }
    $cantidadFacturasDetalles = 0;
    $pagina = 1;
    while($cantidadPaginas >= 0 && $cantidadFacturasDetalles < count($facturasDetailList))
    {
      $pdf->AddPage();
      if($showPages)
      {
        $pdf->addPageNumber($pagina);
      }
      
      $pdf->addSociete( "", "");
      $pdf->temporaire( "Bunny's Kinder" );
      $pdf->addDate( date('d/m/Y'));
      $pdf->addClient($cuenta->getReferenciabancaria());
      $pdf->addAlumnos($alumnos);
      $pdf->addPadres($padres);
      $cols=array( 'Item'  => 30,
                  html_entity_decode("Descripci&oacute;n")    => 130,
                   "Precio"  => 30
                  );
      $pdf->addCols( $cols);
      $cols=array( 'Item'  => 'C',
                  html_entity_decode("Descripci&oacute;n")    => "C",
                   "Precio"  => "C"
                   );
      $pdf->addLineFormat($cols);
      $y    = 70;
      $size = 0;
      $counterItems = 1;
      while($cantidadFacturasDetalles <= $maxPerPage * $pagina && $cantidadFacturasDetalles < count($facturasDetailList))
      {
        $facturaDetalle = $facturasDetailList[$cantidadFacturasDetalles];
        $line = array(
                'Item' => $counterItems,
                html_entity_decode("Descripci&oacute;n")    => $facturaDetalle->getDescription(),
               "Precio"  => '$'.$facturaDetalle->getFormatedAmount()
        );
        $size = $pdf->addLine( $y, $line );
        $y   += $size + 2;
        $counterItems++;
        $cantidadFacturasDetalles++;
      }
      $pagina++;
      $cantidadPaginas--;
    }
    $pdf->addCadreEurosFrancs('$ '.$cuenta->getFormatedDiferencia());
    $outputOption = 'I';
    if($location !== null)
    {
      if(!is_dir($location))
      {
        $location = sys_get_temp_dir();
      }
      $outputOption = 'F';
      $location .= DIRECTORY_SEPARATOR;
    }
    else 
    {
      $location = '';
    }
    $outputName = sprintf('Cuenta-%s-%s.pdf',$cuenta->getReferenciabancaria(), date('m-Y'));
    $pdf->Output($location.$outputName, $outputOption);
    if($outputOption == 'F')
    {
      return $location.$outputName;
    }
    die(0);
  }
}
