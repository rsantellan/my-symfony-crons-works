<?php

/**
 * cuentaTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class cuentaTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object cuentaTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('cuenta');
    }
    
    
    public function retrieveAllActive()
    {
      $q = $this->createQuery('q')
           ->select('q.*')   
           ->innerJoin('q.cuentausuario cu')
           ->innerJoin('cu.usuario u')
           ->where('u.egresado = 0');
      return $q->execute();
    }
}