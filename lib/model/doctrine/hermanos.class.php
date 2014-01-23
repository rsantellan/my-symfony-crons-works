<?php

/**
 * hermanos
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jardin
 * @subpackage model
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class hermanos extends Basehermanos
{
  public static function addHermano($usuario_from, $usuario_to)
  {
    $conn = Doctrine_Manager::connection();
    
    try
    {      
      $conn->beginTransaction();

      $register_one = new hermanos();
      $register_one->setUsuarioFrom($usuario_from);
      $register_one->setUsuarioTo($usuario_to);
      $register_one->save();
      
      $register_two = new hermanos();
      $register_two->setUsuarioFrom($usuario_to);
      $register_two->setUsuarioTo($usuario_from);
      $register_two->save();
      
      $conn->commit();
    
    }catch (Exception $e){

      $conn->rollBack();

      return false;
      
    }
    
    // Actualizamos grupos newsletter
    $register_one->getUserFrom()->updateNewsletter();    
    
    return true;
  }
  
  public static function removeHermano($usuario_from, $usuario_to)
  {
    $rel_1 = Doctrine::getTable('hermanos')->find(array($usuario_from, $usuario_to));
    $rel_2 = Doctrine::getTable('hermanos')->find(array($usuario_to, $usuario_from));
    $rel_1->delete();
    $rel_2->delete();
    
    $usuario = Doctrine::getTable('usuario')->find($usuario_from);
    $usuario->updateNewsletter();
  }
  
  public function postInsert($event) {
	  parent::postInsert($event);
	  accountsHandler::syncParentChildsBrothersAccounts($this->getUsuarioFrom());
	  accountsHandler::syncParentChildsBrothersAccounts($this->getUsuarioTo());
	}
}
