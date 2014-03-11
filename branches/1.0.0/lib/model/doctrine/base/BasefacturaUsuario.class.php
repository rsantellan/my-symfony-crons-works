<?php

/**
 * BasefacturaUsuario
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $usuario_id
 * @property float $total
 * @property integer $month
 * @property integer $year
 * @property integer $enviado
 * @property integer $pago
 * @property integer $cancelado
 * @property date $fechavencimiento
 * @property usuario $usuario
 * @property Doctrine_Collection $facturaUsuarioDetalle
 * @property Doctrine_Collection $facturausuariofinal
 * 
 * @method integer             getId()                    Returns the current record's "id" value
 * @method integer             getUsuarioId()             Returns the current record's "usuario_id" value
 * @method float               getTotal()                 Returns the current record's "total" value
 * @method integer             getMonth()                 Returns the current record's "month" value
 * @method integer             getYear()                  Returns the current record's "year" value
 * @method integer             getEnviado()               Returns the current record's "enviado" value
 * @method integer             getPago()                  Returns the current record's "pago" value
 * @method integer             getCancelado()             Returns the current record's "cancelado" value
 * @method date                getFechavencimiento()      Returns the current record's "fechavencimiento" value
 * @method usuario             getUsuario()               Returns the current record's "usuario" value
 * @method Doctrine_Collection getFacturaUsuarioDetalle() Returns the current record's "facturaUsuarioDetalle" collection
 * @method Doctrine_Collection getFacturausuariofinal()   Returns the current record's "facturausuariofinal" collection
 * @method facturaUsuario      setId()                    Sets the current record's "id" value
 * @method facturaUsuario      setUsuarioId()             Sets the current record's "usuario_id" value
 * @method facturaUsuario      setTotal()                 Sets the current record's "total" value
 * @method facturaUsuario      setMonth()                 Sets the current record's "month" value
 * @method facturaUsuario      setYear()                  Sets the current record's "year" value
 * @method facturaUsuario      setEnviado()               Sets the current record's "enviado" value
 * @method facturaUsuario      setPago()                  Sets the current record's "pago" value
 * @method facturaUsuario      setCancelado()             Sets the current record's "cancelado" value
 * @method facturaUsuario      setFechavencimiento()      Sets the current record's "fechavencimiento" value
 * @method facturaUsuario      setUsuario()               Sets the current record's "usuario" value
 * @method facturaUsuario      setFacturaUsuarioDetalle() Sets the current record's "facturaUsuarioDetalle" collection
 * @method facturaUsuario      setFacturausuariofinal()   Sets the current record's "facturausuariofinal" collection
 * 
 * @package    jardin
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasefacturaUsuario extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('facturaUsuario');
        $this->hasColumn('id', 'integer', 20, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 20,
             ));
        $this->hasColumn('usuario_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('total', 'float', 12, array(
             'type' => 'float',
             'default' => 0,
             'notnull' => true,
             'length' => 12,
             'scale' => '2',
             ));
        $this->hasColumn('month', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('year', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('enviado', 'integer', 1, array(
             'type' => 'integer',
             'default' => '0',
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('pago', 'integer', 1, array(
             'type' => 'integer',
             'default' => '0',
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('cancelado', 'integer', 1, array(
             'type' => 'integer',
             'default' => '0',
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('fechavencimiento', 'date', 25, array(
             'type' => 'date',
             'notnull' => true,
             'length' => 25,
             ));


        $this->index('monthly_yearly_user_index', array(
             'fields' => 
             array(
              0 => 'month',
              1 => 'year',
              2 => 'usuario_id',
             ),
             'type' => 'unique',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('usuario', array(
             'local' => 'usuario_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('facturaUsuarioDetalle', array(
             'local' => 'id',
             'foreign' => 'factura_id'));

        $this->hasMany('facturausuariofinal', array(
             'local' => 'id',
             'foreign' => 'factura_usuario_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}