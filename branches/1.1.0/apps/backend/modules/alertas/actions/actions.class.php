<?php
/**
 * alertas actions.
 *
 * @package    jardin
 * @subpackage costos
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class alertasActions extends sfActions
{
  public function executeIndex(sfWebRequest $request){
    $this->facturas = array();//Doctrine::getTable('factura')->retrieveAllActive();
    //usuario::getAllUsersWithoutParents(true);
    //Doctrine::getTable('cuenta')->retrieveAllActive();
    //Doctrine::getTable('cuenta')->retrieveAllWithDebts();
    $this->cuentas = accountsHandler::retrieveAllDebtsAccountsWithUsers();
  }
  
  public function executePay(sfWebRequest $request){
    $usuario = Doctrine::getTable('usuario')->find($request->getParameter('id'));
    $price = $request->getParameter('price');
    $price_to_pay = $request->getParameter('price-to-pay');
    $out_of_date = ($request->hasParameter('out-of-date') && $request->getParameter('out-of-date') == 'on');  
    
    if($usuario && is_numeric($price) && $price >= 0)
    {
      $usuario->pagar($price, $price_to_pay, $request->getParameter('mes'), $out_of_date);
      return $this->renderText(mdBasicFunction::basic_json_response(true, array()));      
    }
    else
    {
      return $this->renderText(mdBasicFunction::basic_json_response(false, array()));      
    }

  }
  
  public function executeExonerar(sfWebRequest $request){
    $usuario = Doctrine::getTable('usuario')->find($request->getParameter('id'));
    $mes = $request->getParameter('mes');
    if($usuario && $mes > 0 && $mes <= 12)
    {
      $exonerar = new exoneracion();
      $exonerar->setUsuarioId($usuario->getId());
      $exonerar->setMes($mes);
      $exonerar->setFecha(date('Y-m-d H:i:s',time()));
      $exonerar->save();
      return $this->renderText(mdBasicFunction::basic_json_response(true, array()));      
    }
    else
    {
      return $this->renderText(mdBasicFunction::basic_json_response(false, array()));      
    }
  }  
}
