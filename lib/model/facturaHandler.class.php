<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of facturaHandler
 *
 * @author rodrigo
 */
class facturaHandler {

  public static function generateUserBill($usuario, $month, $year)
  {
    $facturaUsuario = Doctrine::getTable('facturaUsuario')->retrieveByUserMonthAndYear($usuario->getId(), $month, $year);
	$refreshAccount = false;
	$account = null;
    if(!$facturaUsuario)
    {
      $facturaUsuario = new facturaUsuario();
	  
	  //$facturaUsuario->getPago()
    }
    else
    {
	  //Ya existe una factura para este mes.
	  if($facturaUsuario->getPago() == 1)
	  {
		if (sfConfig::get('sf_logging_enabled'))
		{
		  sfContext::getInstance()->getLogger()->info('La factura se encuentra paga.');
		}
		return true;
	  }
	  if($facturaUsuario->getCancelado() == 1)
	  {
		if (sfConfig::get('sf_logging_enabled'))
		{
		  sfContext::getInstance()->getLogger()->info('La factura se encuentra cancelada.');
		}
		return true;
	  }
	  $refreshAccount = true;
	  $facturaUsuario->delete();
	  $facturaUsuario = new facturaUsuario();
	  //foreach($facturaUsuario->getFacturaUsuarioDetalle() as $detalle)
	  //{
	  //$detalle->delete();
	  //}
	  
    }
	$facturaUsuario->setYear($year);
	$facturaUsuario->setMonth($month);
	$facturaUsuario->setUsuarioId($usuario->getId());
	$facturaUsuario->setTotal(0);
	$facturaUsuario->setFechavencimiento(date('Y-m-d'));
	$facturaUsuario->save();

	$total = 0;
	$detalleMensualidad = new facturaUsuarioDetalle();
	$detalleMensualidad->setFacturaId($facturaUsuario->getId());
	$detalleMensualidad->setDescription('Mensualidad');
	$detalleMensualidad->setAmount(costos::getCosto($usuario->getHorario()));
	$detalleMensualidad->save();
	$total += $detalleMensualidad->getAmount();
	foreach($usuario->getActividades() as $actividad)
	{
	  $detalleActividad = new facturaUsuarioDetalle();
	  $detalleActividad->setFacturaId($facturaUsuario->getId());
	  $detalleActividad->setDescription($actividad->getNombre());
	  $detalleActividad->setAmount($actividad->getCosto());
	  $detalleActividad->save();
	  $total += $detalleActividad->getAmount();
	}

	$descuentoHermano = $usuario->calculateBrothersDiscount();
	if($descuentoHermano > 0)
	{
	  $detalleDescuentoHermano = new facturaUsuarioDetalle();
	  $detalleDescuentoHermano->setFacturaId($facturaUsuario->getId());
	  $detalleDescuentoHermano->setDescription('Descuento hermano');
	  if (sfConfig::get('sf_logging_enabled'))
	  {
		sfContext::getInstance()->getLogger()->info(sprintf('Descuento hermano: %s', $descuentoHermano));
		sfContext::getInstance()->getLogger()->info(sprintf('total: %s', $total));
		sfContext::getInstance()->getLogger()->info(sprintf('Total * descuento de hermano: %s', $total * $descuentoHermano));
		sfContext::getInstance()->getLogger()->info(sprintf('Total * descuento de hermano / 100: %s', ($total * $descuentoHermano) / 100));
		sfContext::getInstance()->getLogger()->info(sprintf('(Total * descuento de hermano / 100) * -1: %s', (($total * $descuentoHermano) / 100) * -1));
	  }
	  $amount = (($total * $descuentoHermano) / 100) * -1;
	  $detalleDescuentoHermano->setAmount($amount);
	  $detalleDescuentoHermano->save();
	  $total += $detalleDescuentoHermano->getAmount();
	}
	if($usuario->getDescuento() !== null && (int) $usuario->getDescuento() > 0)
	{
	  $detalleDescuentoUsuario = new facturaUsuarioDetalle();
	  $detalleDescuentoUsuario->setFacturaId($facturaUsuario->getId());
	  $detalleDescuentoUsuario->setDescription('Descuento usuario');
	  $detalleDescuentoUsuario->setAmount(-($total * $usuario->getDescuento() / 100));
	  $detalleDescuentoUsuario->save();
	  $total += $detalleDescuentoUsuario->getAmount();
	}
	$facturaUsuario->setTotal($total);
	$facturaUsuario->save();
	if($refreshAccount)
	{
	  //Revisar por el get(0)
	  $account = $usuario->getCuentausuario()->get(0)->getCuenta();
	  self::doGenerateAccountBill($month, $year, $account);
	}
  }
  
  public static function generateAccountBill($month, $year, $accountId = null)
  {
    if($accountId !== null)
    {
      $account = Doctrine::getTable('cuenta')->find($accountId);
      self::doGenerateAccountBill($month, $year, $account);
    }
    else
    {
      $accounts = Doctrine::getTable('cuenta')->retrieveAllActive();
      foreach($accounts as $account)
      {
        self::doGenerateAccountBill($month, $year, $account);
      }
    }
  }
  
  private static function doGenerateAccountBill($month, $year, $account)
  {
    $facturaFinal = Doctrine::getTable('facturaFinal')->retrieveByAccountMonthAndYear($account->getId(), $month, $year);
    if(!$facturaFinal)
    {
      $facturaFinal = new facturaFinal();
    }
    else
    {
      //Ya existe una factura para ese mes.
	  if($facturaFinal->getPago() == 1)
	  {
		if (sfConfig::get('sf_logging_enabled'))
		{
		  sfContext::getInstance()->getLogger()->info('La factura se encuentra paga.');
		}
		return true;
	  }
	  if($facturaFinal->getCancelado() == 1)
	  {
		if (sfConfig::get('sf_logging_enabled'))
		{
		  sfContext::getInstance()->getLogger()->info('La factura se encuentra cancelada.');
		}
		return true;
	  }

	  $facturaFinal->delete();
	  $facturaFinal = new facturaFinal();
    }
	
	
	$facturaFinal->setCuenta($account);
	$facturaFinal->setMonth($month);
	$facturaFinal->setYear($year);
	$facturaFinal->setFechavencimiento(date('Y-m-d'));
	$facturaFinal->setTotal(0);
	$facturaFinal->save();
	$total = 0;
	$brothersActive = $account->getCuentausuario()->count();
	foreach($account->getCuentausuario() as $cuentaUsuario)
	{
	  $facturaUsuario = Doctrine::getTable('facturaUsuario')->retrieveByUserMonthAndYear($cuentaUsuario->getUsuarioId(), $month, $year);
	  if($facturaUsuario)
	  {
		foreach($facturaUsuario->getFacturaUsuarioDetalle() as $facturaUsuarioDetalle)
		{
		  $detalle = new facturaFinalDetalle();
		  $detalle->setFacturaId($facturaFinal->getId());
		  $detalleDescription = "";
		  if($brothersActive > 1)
		  {
			$detalleDescription = sprintf('[%s] %s', $cuentaUsuario->getUsuario()->getNombre() , $facturaUsuarioDetalle->getDescription());
		  }
		  else
		  {
			$detalleDescription = $facturaUsuarioDetalle->getDescription();
		  }
		  $detalle->setDescription($detalleDescription);
		  $detalle->setAmount($facturaUsuarioDetalle->getAmount());
		  $detalle->save();
		  $total += $detalle->getAmount();
		}

		$facturaFinalUsuario = new facturausuariofinal();
		$facturaFinalUsuario->setFacturaFinalId($facturaFinal->getId());
		$facturaFinalUsuario->setFacturaUsuarioId($facturaUsuario->getId());
		$facturaFinalUsuario->save();
	  }
	  else
	  {
		// No tiene factura para ese mes?? raro...
	  }

	}
	$facturaFinal->setTotal($total);
	$facturaFinal->save();
	$account->setDebe($account->getDebe() + $total);
	$account->save();
  }
  
  public static function getRandomColor() 
  { 
     $c = "";
     for ($i = 0; $i<6; $i++) 
     { 
         $c .=  dechex(rand(0,15)); 
     } 
     return "#".$c; 
  }
  
  public static function payFacturasOfAccount($accountId, $amount)
  {
    $facturas = Doctrine::getTable('facturaFinal')->retrieveAllUnpaidFromAccountId($accountId);
    foreach($facturas as $factura)
    {
      if($amount > 0)
      {
        $amountFinal = $amount - ($factura->getTotal() - $factura->getPagadodeltotal());
        if (sfConfig::get('sf_logging_enabled'))
        {
          sfContext::getInstance()->getLogger()->info(sprintf('factura id: %s', $factura->getId()));
          sfContext::getInstance()->getLogger()->info(sprintf('monto: %s', $amount));
          sfContext::getInstance()->getLogger()->info(sprintf('factura total: %s', $factura->getTotal()));
          sfContext::getInstance()->getLogger()->info(sprintf('factura pago: %s', $factura->getPagadodeltotal()));
          sfContext::getInstance()->getLogger()->info(sprintf('factura total - pago: %s', $factura->getTotal() - $factura->getPagadodeltotal()));
          sfContext::getInstance()->getLogger()->info(sprintf('monto final: %s', $amountFinal));
        }
        if(($factura->getTotal() - $factura->getPagadodeltotal()) > $amount)
        {
          $factura->setPagadodeltotal($factura->getPagadodeltotal() + $amount);
        }
        else
        {
          $factura->setPagadodeltotal($factura->getTotal());
          $factura->setPago(1);
		  foreach($factura->getFacturausuariofinal() as $facturaUsuarioFinal)
		  {
			$facturaUsuario = $facturaUsuarioFinal->getFacturaUsuario();
			$facturaUsuario->setPago(1);
			$facturaUsuario->save();
		  }
        }
        $amount = $amountFinal;
        $factura->save();
      }
    }
  }
  
  public static function cancelFactura($factura)
  {
    if($factura->getPago() == 0 && $factura->getCancelado() == 0)
    {
      $conn = Doctrine_Manager::connection();
      try
      {
        $conn->beginTransaction();
        $factura->setCancelado(1);
        $factura->save();
        foreach($factura->getFacturausuariofinal() as $facturaUsuarioFinal)
		{
		  $facturaUsuario = $facturaUsuarioFinal->getFacturaUsuario();
		  $facturaUsuario->setCancelado(1);
		  $facturaUsuario->save();
		}
		$cuenta = $factura->getCuenta();
        $cuenta->setDebe($cuenta->getDebe() - $factura->getTotal());
        $cuenta->save();
		$conn->commit();
      }catch (Exception $e){
        $conn->rollBack();
        throw $e;
      }
      return true;
    }
    return false;
    //$factura->getCuenta()->setDebe($factura->getCuenta()->getDebe() - $factura->getTotal());
  }
  /*
   * 
public function retrieveByUserMonthAndYear($userId, $month, $year)
    {
        $query = $this->createQuery('f')
                ->addWhere('f.usuario_id = ?', $userId)
                ->addWhere('f.month = ?', $month)
                ->addWhere('f.year = ?', $year);
        return $query->fetchOne();
    }
    
    public function retrieveAllActive($withUser = true)
    {
        $query = $this->createQuery('f')
                    ->addWhere('f.pago = 0')
                    ->addWhere('f.cancelado = 0')
                    ->innerJoin("f.usuario u")
                    ->orderBy('f.cuenta_id asc, f.updated_at desc');
        return $query->execute();
    }
const IMPUESTORETRASO = 10;
    
    public function calculateTotal()
    {
        $total = $this->getCostoTurno() + $this->getCostoMatricula() + $this->getCostoMatricula();
        $descuentos = $this->getDescuentoAlumno() + $this->getDescuentoHermano();
        if($descuentos >= 100)
        {
            $total = 0;
        }
        else
        {
            $total = $total - ($total * $descuentos / 100);
        }
        return $total;
    }

    public static function generateUserBill($usuario, $month, $year)
    {
        $factura = new factura();
        self::doPopulateUserBill($factura, $usuario, $month, $year);
    }
    
    public static function updateUserBill($usuario, $month, $year)
    {
        $factura = Doctrine::getTable('factura')->retrieveByUserMonthAndYear($usuario->getId(), $month, $year);
        if(!$factura)
        {
            $factura = new factura();
        }
        self::doPopulateUserBill($factura, $usuario, $month, $year);
    }
    
    private static function doPopulateUserBill($factura, $usuario, $month, $year)
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $factura->setCostoTurno(costos::getCosto($usuario->getHorario()));
        $factura->setCostoMatricula($usuario->calculateMatricula($month));
        $factura->setCostoActividad($usuario->calculateActividades());
        $factura->setDescuentoHermano($usuario->calculateBrothersDiscount());
        $factura->setDescuentoAlumno($usuario->getDescuento());
        $cuenta = $q->fetchRow(accountsHandler::SQL_USUARIO_CUENTA, array($usuario->getId()));
        $factura->setCuentaId($cuenta["cuenta_id"]);
        $factura->setMonth($month);
        $factura->setYear($year);
        $factura->setDescription($usuario->retrieveBillingDescription());
        $factura->setUsuarioId($usuario->getId());
        $factura->setTotal($factura->calculateTotal());
        $fecha = date('Y-m-d', mktime(0, 0, 0, $month + 1, 1, $year));
        $factura->setFechavencimiento($fecha);
        $factura->setRecargoAtraso(self::IMPUESTORETRASO);
        $factura->save();
        unset($factura);
    }
    
    function getRandomColor() 
    { 
       $c = "";
       for ($i = 0; $i<6; $i++) 
       { 
           $c .=  dechex(rand(0,15)); 
       } 
       return "#".$c; 
    }
   */
}


