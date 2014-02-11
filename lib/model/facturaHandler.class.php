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


