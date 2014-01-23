<?php

/**
 * usuario_progenitor
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jardin
 * @subpackage model
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class usuario_progenitor extends Baseusuario_progenitor
{
    public static function addPadre($usuario_id, $progenitor_id) {
        $register_one = new usuario_progenitor();
        $register_one->setUsuarioId($usuario_id);
        $register_one->setProgenitorId($progenitor_id);
        $register_one->save();
        
        $register_one->getUsuario()->updateNewsletter();
        return true;
    }
    
    public static function removePadre($usuario_id, $progenitor_id) {
        $padre = Doctrine::getTable('progenitor')->find($progenitor_id);
        if ($padre->getMdUserId() != NULL) {
            // Obtengo el mdUser
            $mdUser = $padre->getMdUser();
            if ($mdUser->getMdNewsLetterUser()->count() > 0) {
                $mdNewsletterUser = $mdUser->getMdNewsLetterUser()->getFirst();

                $grupos = $mdNewsletterUser->getMdNewsLetterGroupUser();

                //lo elimino de todos los grupos
                foreach ($grupos as $grupoRelation) {
                    $grupoRelation->delete();
                }
            }            
        }
        
        $register_one = Doctrine::getTable('usuario_progenitor')->find(array($usuario_id, $progenitor_id));
        $register_one->delete();
    }
	
	public function postInsert($event) {
	  parent::postInsert($event);
	  accountsHandler::syncParentChildsBrothersAccounts($this->getUsuarioId(), $this->getProgenitorId());
	}
	
	public function postDelete($event) {
	  parent::postDelete($event);
	  accountsHandler::removeParentAccountOfChilds($this->getProgenitorId(), $this->getProgenitor()->getNombre());
	}
}
