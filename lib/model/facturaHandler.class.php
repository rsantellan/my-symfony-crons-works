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
    $debug = false;
    $facturaUsuario = Doctrine::getTable('facturaUsuario')->retrieveByUserMonthAndYear($usuario->getId(), $month, $year);
    if(!$facturaUsuario)
    {
      $facturaUsuario = new facturaUsuario();
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
        if($debug)
        {
            var_dump($descuentoHermano);
            var_dump($total);
            var_dump($descuentoHermano);
            var_dump($total * $descuentoHermano);
            var_dump(($total * $descuentoHermano) / 100);
            var_dump((($total * $descuentoHermano) / 100) * -1);
            var_dump('--------');
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
    }
    else
    {
      //Ya existe una factura para este mes.
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
      $facturaFinal->setCuenta($account);
      $facturaFinal->setMonth($month);
      $facturaFinal->setYear($year);
      $facturaFinal->setFechavencimiento(date('Y-m-d'));
      $facturaFinal->setTotal(0);
      $facturaFinal->save();
      $total = 0;
      foreach($account->getCuentausuario() as $cuentaUsuario)
      {
        $facturaUsuario = Doctrine::getTable('facturaUsuario')->retrieveByUserMonthAndYear($cuentaUsuario->getUsuarioId(), $month, $year);
        if($facturaUsuario)
        {
          foreach($facturaUsuario->getFacturaUsuarioDetalle() as $facturaUsuarioDetalle)
          {
            $detalle = new facturaFinalDetalle();
            $detalle->setFacturaId($facturaFinal->getId());
            $detalle->setDescription($facturaUsuarioDetalle->getDescription());
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
    else
    {
      //Ya existe una factura para ese mes.
    }
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


