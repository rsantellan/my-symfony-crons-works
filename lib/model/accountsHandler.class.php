<?php

/**
 * Description of accountsHandler
 *
 * @author rodrigo
 */
class accountsHandler {

    const SQL_USUARIO = "SELECT id, nombre, apellido from usuario";
    const SQL_USUARIO_CUENTA = "select cuenta_id from cuentausuario where usuario_id = ?";
    const SQL_USUARIO_HERMANO = "select usuario_from, usuario_to from hermanos where usuario_from = ? or usuario_to = ?";

    const SQL_PARENTS = "select id, nombre from progenitor";
    const SQL_PARENTS_ACCOUNTS = "select cuenta_id from cuentapadre where progenitor_id = ?";
    const SQL_PARENT_CHILD = "select usuario_id from usuario_progenitor where progenitor_id = ?";
    const SQL_CHILD_PARENT = "select progenitor_id from usuario_progenitor where usuario_id = ?";
    
    const SQL_CUENTA_TIENE_COBRO = "select count(*) as cantidad from cobro where cuenta_id = ?";
    const SQL_UPDATE_CUENTA_USUARIO = "update cuentausuario set cuenta_id = ? where usuario_id = ?";
    const SQL_UPDATE_FACTURA_CUENTA_USUARIO = "update factura set cuenta_id = ? where usuario_id = ?";
    const SQL_UPDATE_CUENTA_PADRE = "update cuentapadre set cuenta_id = ? where progenitor_id = ?";
    
    const SQL_DELETE_UNUSED_ACCOUNTS = "delete from cuenta where id not in (select cuenta_id from cuentapadre union select cuenta_id from cuentausuario union select cuenta_id from cobro union select cuenta_id from factura)";
    
    /*
     * 
     * $sql_parents = "select id, nombre from progenitor";
        $sql_parent_account = "select cuenta_id from cuentapadre where progenitor_id = ?";
        $sql_parent_child = "select usuario_id from usuario_progenitor where progenitor_id = ?";
     */
    
    public static function populateUsersAccounts()
    {
        
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
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
                    $cuenta = new cuenta();
                    $cuenta->setNombre($usuario["apellido"]);
                    $cuenta->save();
                    $cuenta_id = $cuenta->getId();
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
    
	public static function createUsuarioAccount($userId, $lastname)
	{
	  $cuenta = new cuenta();
	  $cuenta->setNombre($lastname);
	  $cuenta->save();
	  $cuentaUsuario = new cuentausuario();
	  $cuentaUsuario->setUsuarioId($userId);
	  $cuentaUsuario->setCuentaId($cuenta->getId());
	  $cuentaUsuario->save();
	}
	
	public static function createParentAccount($parent_id, $name)
	{
	  $cuenta = new cuenta();
	  $cuenta->setNombre($name);
	  $cuenta->save();
	  $cuentapadre = new cuentapadre();
	  $cuentapadre->setProgenitorId($parent_id);
	  $cuentapadre->setCuentaId($cuenta->getId());
	  $cuentapadre->save();
	}
	
	public static function removeParentAccountOfChilds($parent_id, $name)
	{
	  //tengo que verificar que no tiene ningun cobro ni factura
	  $cuentapadre = Doctrine::getTable('cuentapadre')->findOneByProgenitorId($parent_id);
      $cuenta = new cuenta();
	  $cuenta->setNombre($name);
	  $cuenta->save();
	  $cuentapadre->setCuentaId($cuenta->getId());
	  $cuentapadre->save();
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
                    $cuenta = new cuenta();
                    $cuenta->setNombre($parent["nombre"]);
                    $cuenta->save();
                    $cuenta_id = $cuenta->getId();
                }
                else
                {
                    $cuenta_id = $cuenta["cuenta_id"];
                }
                $cuentapadre = new cuentapadre();
                $cuentapadre->setProgenitorId($parent_id);
                $cuentapadre->setCuentaId($cuenta_id);
                $cuentapadre->save();

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
                                $q->execute(self::SQL_UPDATE_FACTURA_CUENTA_USUARIO, array($cuenta_id, $hermano_id));
                            }
                            else
                            {
                                $q->execute(self::SQL_UPDATE_CUENTA_USUARIO, array($cuenta_hermano_id, $usuarioId));
                                $q->execute(self::SQL_UPDATE_FACTURA_CUENTA_USUARIO, array($cuenta_hermano_id, $usuarioId));
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
                            $q->execute(self::SQL_UPDATE_FACTURA_CUENTA_USUARIO, array($cuenta_padre_id, $usuarioId));
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
    
    public static function generateMonthBilling($month, $year)
    {
        $usuarios = Doctrine::getTable('usuario')->retrieveAllActiveStudents();
        foreach($usuarios as $usuario)
        {
            try{
                factura::generateUserBill($usuario, $month, $year);
            }catch(Exception $e)
            {
                if($e->getCode() == 23000)
                {
                    factura::updateUserBill($usuario, $month, $year);
                }
            }
            
            
            
        }
    }
}

