<?php

/**
 * Description of accountsHandler
 *
 * @author rodrigo
 */
class accountsHandler {

    const SQL_USUARIO = "SELECT id, nombre, apellido, referencia_bancaria from usuario";
    const SQL_USUARIO_CUENTA = "select cuenta_id from cuentausuario where usuario_id = ?";
    const SQL_USUARIO_HERMANO = "select usuario_from, usuario_to from hermanos where usuario_from = ? or usuario_to = ?";
    const SQL_USUARIO_REFERENCIA = 'select referencia_bancaria from usuario where id = ?';
    const SQL_USUARIO_REFERENCIA_CUENTA = 'select id, referenciabancaria from cuenta where referenciabancaria = ?';
    
    const SQL_UPDATE_USUARIO_REFERENCIA_CUENTA = "update usuario set referencia_bancaria = concat('F', id) where referencia_bancaria = ''";
    
    const SQL_PARENTS = "select id, nombre from progenitor";
    const SQL_PARENTS_ACCOUNTS = "select cuenta_id from cuentapadre where progenitor_id = ?";
    const SQL_PARENT_CHILD = "select usuario_id from usuario_progenitor where progenitor_id = ?";
    const SQL_CHILD_PARENT = "select progenitor_id from usuario_progenitor where usuario_id = ?";
    
    const SQL_CUENTA_TIENE_COBRO = "select count(*) as cantidad from cobro where cuenta_id = ?";
    const SQL_UPDATE_CUENTA_USUARIO = "update cuentausuario set cuenta_id = ? where usuario_id = ?";
    const SQL_UPDATE_FACTURA_CUENTA_USUARIO = "update factura set cuenta_id = ? where usuario_id = ?";
    const SQL_UPDATE_CUENTA_PADRE = "update cuentapadre set cuenta_id = ? where progenitor_id = ?";
    const SQL_CUENTA_BY_REFERENCE = 'select id, referenciabancaria from cuenta where referenciabancaria = ?';
    
    const SQL_DELETE_UNUSED_ACCOUNTS = "delete from cuenta where id not in (select cuenta_id from cuentapadre union select cuenta_id from cuentausuario union select cuenta_id from cobro union select cuenta_id from factura)";

    const SQL_RETRIEVE_ACCOUNT_REFERENCE_PARENT = 'select cuenta.referenciabancaria from cuenta, cuentapadre where cuenta.id = cuentapadre.cuenta_id and cuentapadre.progenitor_id = ?';
    const SQL_RETRIEVE_ACCOUNT_REFERENCE_USER = 'select cuenta.referenciabancaria from cuenta, cuentausuario where cuenta.id = cuentausuario.cuenta_id and cuentausuario.usuario_id = ?';
    
    /*
     * 
     * $sql_parents = "select id, nombre from progenitor";
        $sql_parent_account = "select cuenta_id from cuentapadre where progenitor_id = ?";
        $sql_parent_child = "select usuario_id from usuario_progenitor where progenitor_id = ?";
     */
    
    public static function populateUsersAccounts()
    {
        
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute(self::SQL_UPDATE_USUARIO_REFERENCIA_CUENTA);
        $usuarios = $q->fetchAssoc(self::SQL_USUARIO);
        foreach($usuarios as $usuario)
        {
            $usuario_id = $usuario["id"];
            //var_dump($usuario_id);
            $cuenta = $q->fetchRow(self::SQL_USUARIO_CUENTA, array($usuario_id));
            if(!$cuenta)
            {
                //Busco a los hermanos a ver si tienen cuenta
                $hermanos = $q->fetchAssoc(self::SQL_USUARIO_HERMANO, array($usuario_id, $usuario_id));
                if(count($hermanos) > 0)
                {
                    //var_dump($hermanos);
                    foreach($hermanos as $hermano)
                    {
                        if(!$cuenta)
                        {
                            $hermano_id = null;
                            if($hermano["usuario_from"] == $usuario_id)
                            {
                                $hermano_id = $hermano["usuario_to"];
                            }
                            else 
                            {
                                $hermano_id = $hermano["usuario_from"];
                            }
                            //var_dump($hermano_id);
                            $cuenta = $q->fetchRow(self::SQL_USUARIO_CUENTA, array($hermano_id));
                        }
                    }
                }
                $cuenta_id = null;
                if(!$cuenta)
                {
                    $cuentaReferencia = $q->fetchRow(self::SQL_USUARIO_REFERENCIA_CUENTA, array($usuario["referencia_bancaria"]));
                    if($cuentaReferencia && $cuentaReferencia['referenciabancaria'] !== "")
                    {
                      $cuenta_id = $cuentaReferencia['id'];
                    }
                    else
                    {
                      $cuenta = new cuenta();
                      $cuenta->setReferenciabancaria($usuario["referencia_bancaria"]);
                      $cuenta->save();
                      $cuenta_id = $cuenta->getId();
                    }
                    
                }
                else
                {
                    $cuenta_id = $cuenta["cuenta_id"];

                }
                $cuentaUsuario = new cuentausuario();
                $cuentaUsuario->setUsuarioId($usuario_id);
                $cuentaUsuario->setCuentaId($cuenta_id);
                $cuentaUsuario->save();
                unset($cuenta);
                unset($cuentaUsuario);
            }
        }
    }
    
	public static function createUsuarioAccount($userId, $referencia)
	{
    $hasCuenta = true;
    $cuenta = Doctrine::getTable('cuenta')->findOneByReferenciaBancaria($referencia);
    if(!$cuenta)
    {
      $cuenta = new cuenta();
      $cuenta->setReferenciabancaria($referencia);
      $cuenta->save();
      $hasCuenta = false;
    }
    $cuentaUsuario = new cuentausuario();
	  $cuentaUsuario->setUsuarioId($userId);
	  $cuentaUsuario->setCuentaId($cuenta->getId());
	  $cuentaUsuario->save();
    if($hasCuenta)
    {
      return $cuenta->getId();
    }
    return null;
	}
	
	public static function createParentAccount($parent_id, $cuentaId = null, $referencia = null)
	{
    if($cuentaId === null)
    {
      $cuenta = new cuenta();
      $cuenta->setReferenciabancaria($referencia);
      $cuenta->save();
      $cuentaId = $cuenta->getId();
    }
	  $cuentapadre = new cuentapadre();
	  $cuentapadre->setProgenitorId($parent_id);
	  $cuentapadre->setCuentaId($cuentaId);
	  $cuentapadre->save();
	}
	
	public static function removeParentAccountOfChilds($parent_id)
	{
	  //tengo que verificar que no tiene ningun cobro ni factura
	  $cuentapadre = Doctrine::getTable('cuentapadre')->findOneByProgenitorId($parent_id);
    if($cuentapadre)
      $cuentapadre->delete();
    return true;
//    $cuenta = new cuenta();
//	  $cuenta->setNombre($name);
//	  $cuenta->save();
//	  $cuentapadre->setCuentaId($cuenta->getId());
//	  $cuentapadre->save();
	}
	
	public static function acommodateLossedAccounts()
	{
	  //tengo que verificar que no tiene ningun cobro ni factura
	  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
	  $q->execute(self::SQL_DELETE_UNUSED_ACCOUNTS);
	}
	
    public static function populateParentsAccounts()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $parents = $q->fetchAssoc(self::SQL_PARENTS);
        foreach($parents as $parent)
        {
            //var_dump($parent);
            $parent_id = $parent["id"];
            $cuenta = $q->fetchRow(self::SQL_PARENTS_ACCOUNTS, array($parent_id));
            if(!$cuenta)
            {
                $cuenta_id = null;
                $child = $q->fetchRow(self::SQL_PARENT_CHILD, array($parent_id));
                if(!$child)
                {
                    var_dump(sprintf("El id: %s que corresponde a %s no tiene hijo", $parent["id"], $parent["nombre"]));
                }
                else
                {
                    $cuenta = $q->fetchRow(self::SQL_USUARIO_CUENTA, array($child["usuario_id"]));
                    $cuenta_id = $cuenta["cuenta_id"];
                }

                if($cuenta_id === null)
                {
                    var_dump(sprintf("El id: %s que corresponde a %s no tiene cuenta relacionada", $parent["id"], $parent["nombre"]));
                    /*
                    $cuenta = new cuenta();
                    $cuenta->setNombre($parent["nombre"]);
                    $cuenta->save();
                    $cuenta_id = $cuenta->getId();
                    */
                }
                else
                {
                    $cuentapadre = new cuentapadre();
                    $cuentapadre->setProgenitorId($parent_id);
                    $cuentapadre->setCuentaId($cuenta["cuenta_id"]);
                    $cuentapadre->save();
                }
                

            }

        }
    }
    
    public static function syncParentChildsBrothersAccounts($usuarioId = null, $progenitorId = null)
    {
        if($usuarioId === null && $progenitorId === null)
        {
            return false;
        }
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        if($usuarioId !== null)
        {
            $cuenta = $q->fetchRow(self::SQL_USUARIO_CUENTA, array($usuarioId));
            $cuenta_id = $cuenta["cuenta_id"];
            $consulta_cobros = $q->fetchRow(self::SQL_CUENTA_TIENE_COBRO, array($cuenta_id));
            $cantidad_cobros_cuenta = $consulta_cobros["cantidad"];
            
            //Busco a los hermanos.
            $hermanos = $q->fetchAssoc(self::SQL_USUARIO_HERMANO, array($usuarioId, $usuarioId));
            if(count($hermanos) > 0)
            {
                foreach($hermanos as $hermano)
                {
                    $hermano_id = null;
                    if($hermano["usuario_from"] == $usuarioId)
                    {
                        $hermano_id = $hermano["usuario_to"];
                    }
                    else 
                    {
                        $hermano_id = $hermano["usuario_from"];
                    }
                    //var_dump($hermano_id);
                    $cuenta_hermano = $q->fetchRow(self::SQL_USUARIO_CUENTA, array($hermano_id));
                    $cuenta_hermano_id = $cuenta_hermano["cuenta_id"];
                    if($cuenta_hermano_id != $cuenta_id)
                    {
                        $consulta_cobros_hermano = $q->fetchRow(self::SQL_CUENTA_TIENE_COBRO, array($cuenta_hermano_id));
                        $cantidad_cobros_cuenta_hermano = $consulta_cobros_hermano["cantidad"];
                        if($cantidad_cobros_cuenta_hermano > 0 && $cantidad_cobros_cuenta > 0)
                        {
                            //problemas! mandar mail
                        }
                        else
                        {
                            if($cantidad_cobros_cuenta_hermano == 0)
                            {
                                $q->execute(self::SQL_UPDATE_CUENTA_USUARIO, array($cuenta_id, $hermano_id));
                                //$q->execute(self::SQL_UPDATE_FACTURA_CUENTA_USUARIO, array($cuenta_id, $hermano_id));
                            }
                            else
                            {
                                $q->execute(self::SQL_UPDATE_CUENTA_USUARIO, array($cuenta_hermano_id, $usuarioId));
                                //$q->execute(self::SQL_UPDATE_FACTURA_CUENTA_USUARIO, array($cuenta_hermano_id, $usuarioId));
                            }
                        }
                    }
                }
            }
            
            //Busco los padres
            $parents = $q->fetchAssoc(self::SQL_CHILD_PARENT, array($usuarioId));
            foreach($parents as $parent)
            {
                $parent_id = $parent["progenitor_id"];
                $cuenta_padre = $q->fetchRow(self::SQL_PARENTS_ACCOUNTS, array($parent_id));
                $cuenta_padre_id = $cuenta_padre["cuenta_id"];
                if($cuenta_padre_id === null)
                {
                  self::createParentAccount($parent_id, $cuenta_id);
                  $cuenta_padre_id = $cuenta_id;
                }
                if($cuenta_id != $cuenta_padre_id)
                {
                    $consulta_cobros_padre = $q->fetchRow(self::SQL_CUENTA_TIENE_COBRO, array($cuenta_padre_id));
                    $cantidad_cobros_cuenta_padre = $consulta_cobros_padre["cantidad"];
                    if($cantidad_cobros_cuenta_padre > 0 && $cantidad_cobros_cuenta > 0)
                    {
                        //problemas! mandar mail
                    }
                    else
                    {
                        if($cantidad_cobros_cuenta_padre == 0)
                        {
                            $q->execute(self::SQL_UPDATE_CUENTA_PADRE, array($cuenta_id, $parent_id));
                        }
                        else
                        {
                            $q->execute(self::SQL_UPDATE_CUENTA_USUARIO, array($cuenta_padre_id, $usuarioId));
                            //$q->execute(self::SQL_UPDATE_FACTURA_CUENTA_USUARIO, array($cuenta_padre_id, $usuarioId));
                        }
                    }
                }
                
            }
        }
        if($progenitorId !== null)
        {
            $hijos = $q->fetchAssoc(self::SQL_PARENT_CHILD, array($progenitorId));
            foreach($hijos as $hijo)
            {
                self::syncParentChildsBrothersAccounts($hijo["usuario_id"]);
            }
        }
        return true;
    }
    
    public static function checkThatParentAndSonHasSameAccount($parent_id, $user_id)
    {
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      $referenceParent = $q->fetchRow(self::SQL_RETRIEVE_ACCOUNT_REFERENCE_PARENT, array($parent_id));
      $referenceUser = $q->fetchRow(self::SQL_RETRIEVE_ACCOUNT_REFERENCE_USER, array($user_id));
      if($referenceParent && ($referenceParent != $referenceUser))
      {
        return false;
      }
      return true;
    }
    
    public static function checkThatBrothersHasSameReference($user_id, $brother_id)
    {
      // SQL_USUARIO_REFERENCIA
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      $referenceUser = $q->fetchRow(self::SQL_USUARIO_REFERENCIA, array($user_id));
      $referenceBrother = $q->fetchRow(self::SQL_USUARIO_REFERENCIA, array($brother_id));
      if($referenceBrother != $referenceUser)
      {
        return false;
      }
      return true;
    }
    
    
    
    
    
    public static function generateMonthBilling($month, $year)
    {
        $usuarios = Doctrine::getTable('usuario')->retrieveAllActiveStudents();
        foreach($usuarios as $usuario)
        {
          facturaHandler::generateUserBill($usuario, $month, $year);
        }
    }
    
    public static function retrieveAllDebtsAccountsWithUsers()
    {
      $cuentasUsuarios = Doctrine::getTable('cuenta')->retrieveAllWithDebtsAndUsers();
      $data = array();
      foreach($cuentasUsuarios as $cuenta)
      {
        if(!isset($data[$cuenta->getId()]))
        {
          $data[$cuenta->getId()] = array('cuenta' => $cuenta, 'usuarios' => array(), 'apellido' => '');
        }
        foreach($cuenta->getCuentausuario() as $cuentaUsuario)
        {
          $data[$cuenta->getId()]['usuarios'][] = $cuentaUsuario->getUsuario();
          $data[$cuenta->getId()]['apellido'] = $cuentaUsuario->getUsuario()->getApellido();
        }
      }
      return $data;
    }
    
    public static function retrieveAllAccountsWithUsersAndParents()
    {
      $cuentasUsuarios = Doctrine::getTable('cuenta')->retrieveAllWithUsersAndParents();
      $data = array();
      foreach($cuentasUsuarios as $cuenta)
      {
        if(!isset($data[$cuenta->getId()]))
        {
          $data[$cuenta->getId()] = array('cuenta' => $cuenta, 'usuarios' => array(), 'apellido' => '', 'parents' => array());
        }
        foreach($cuenta->getCuentausuario() as $cuentaUsuario)
        {
          $data[$cuenta->getId()]['usuarios'][] = $cuentaUsuario->getUsuario();
          $data[$cuenta->getId()]['apellido'] = $cuentaUsuario->getUsuario()->getApellido();
        }
        foreach($cuenta->getCuentapadre() as $cuentapadre)
        {
          $data[$cuenta->getId()]['parents'][] = $cuentapadre->getProgenitor();
        }
      }
      return $data;
    }
    
    public static function retrieveAllSeparatedAccountsWithUsersAndParentsByDifference()
    {
      $cuentasUsuarios = Doctrine::getTable('cuenta')->retrieveAllWithUsersAndParents();
      $dataZero = array();
      $dataPositive = array();
      $dataNegative = array();
      $dataActive = array();
      foreach($cuentasUsuarios as $cuenta)
      {
        $isActive = false;
        if($cuenta->getDiferencia() > 0)
        {
          if(!isset($dataPositive[$cuenta->getId()]))
          {
            $dataPositive[$cuenta->getId()] = array('cuenta' => $cuenta, 'usuarios' => array(), 'apellido' => '', 'parents' => array());
          }
          foreach($cuenta->getCuentausuario() as $cuentaUsuario)
          {
            $dataPositive[$cuenta->getId()]['usuarios'][] = $cuentaUsuario->getUsuario();
            $dataPositive[$cuenta->getId()]['apellido'] = $cuentaUsuario->getUsuario()->getApellido();
            if(!$cuentaUsuario->getUsuario()->getEgresado()){
              $isActive = true;
            }
          }
          foreach($cuenta->getCuentapadre() as $cuentapadre)
          {
            $dataPositive[$cuenta->getId()]['parents'][] = $cuentapadre->getProgenitor();
          }
          if($isActive){
              $dataActive[$cuenta->getId()] = $dataPositive[$cuenta->getId()];
          }
        }
        else
        {
          if($cuenta->getDiferencia() == 0)
          {
            if(!isset($dataZero[$cuenta->getId()]))
            {
              $dataZero[$cuenta->getId()] = array('cuenta' => $cuenta, 'usuarios' => array(), 'apellido' => '', 'parents' => array());
            }
            foreach($cuenta->getCuentausuario() as $cuentaUsuario)
            {
              $dataZero[$cuenta->getId()]['usuarios'][] = $cuentaUsuario->getUsuario();
              $dataZero[$cuenta->getId()]['apellido'] = $cuentaUsuario->getUsuario()->getApellido();
              if(!$cuentaUsuario->getUsuario()->getEgresado()){
                $isActive = true;
              }
            }
            foreach($cuenta->getCuentapadre() as $cuentapadre)
            {
              $dataZero[$cuenta->getId()]['parents'][] = $cuentapadre->getProgenitor();
            }
            if($isActive){
              $dataActive[$cuenta->getId()] = $dataZero[$cuenta->getId()];
            }
          }
          else
          {
            if(!isset($dataNegative[$cuenta->getId()]))
            {
              $dataNegative[$cuenta->getId()] = array('cuenta' => $cuenta, 'usuarios' => array(), 'apellido' => '', 'parents' => array());
            }
            foreach($cuenta->getCuentausuario() as $cuentaUsuario)
            {
              $dataNegative[$cuenta->getId()]['usuarios'][] = $cuentaUsuario->getUsuario();
              $dataNegative[$cuenta->getId()]['apellido'] = $cuentaUsuario->getUsuario()->getApellido();
              if(!$cuentaUsuario->getUsuario()->getEgresado()){
                $isActive = true;
              }
            }
            foreach($cuenta->getCuentapadre() as $cuentapadre)
            {
              $dataNegative[$cuenta->getId()]['parents'][] = $cuentapadre->getProgenitor();
            }
            if($isActive){
              $dataActive[$cuenta->getId()] = $dataNegative[$cuenta->getId()];
            }
              
          }
        }
      }
      
      return array('positive' => $dataPositive, 'negative' => $dataNegative, 'zero' => $dataZero, 'active' => $dataActive);
    }
}

