<?php

/**
 * Basefactura
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $usuario_id
 * @property float $costo_turno
 * @property float $costo_actividad
 * @property float $costo_matricula
 * @property float $descuento_hermano
 * @property float $descuento_alumno
 * @property float $total
 * @property integer $month
 * @property integer $year
 * @property float $recargo_atraso
 * @property float $porcentaje_atraso
 * @property integer $pago
 * @property integer $cancelado
 * @property integer $cuenta_id
 * @property cuenta $cuenta
 * @property usuario $usuario
 * 
 * @method integer getId()                Returns the current record's "id" value
 * @method integer getUsuarioId()         Returns the current record's "usuario_id" value
 * @method float   getCostoTurno()        Returns the current record's "costo_turno" value
 * @method float   getCostoActividad()    Returns the current record's "costo_actividad" value
 * @method float   getCostoMatricula()    Returns the current record's "costo_matricula" value
 * @method float   getDescuentoHermano()  Returns the current record's "descuento_hermano" value
 * @method float   getDescuentoAlumno()   Returns the current record's "descuento_alumno" value
 * @method float   getTotal()             Returns the current record's "total" value
 * @method integer getMonth()             Returns the current record's "month" value
 * @method integer getYear()              Returns the current record's "year" value
 * @method float   getRecargoAtraso()     Returns the current record's "recargo_atraso" value
 * @method float   getPorcentajeAtraso()  Returns the current record's "porcentaje_atraso" value
 * @method integer getPago()              Returns the current record's "pago" value
 * @method integer getCancelado()         Returns the current record's "cancelado" value
 * @method integer getCuentaId()          Returns the current record's "cuenta_id" value
 * @method cuenta  getCuenta()            Returns the current record's "cuenta" value
 * @method usuario getUsuario()           Returns the current record's "usuario" value
 * @method factura setId()                Sets the current record's "id" value
 * @method factura setUsuarioId()         Sets the current record's "usuario_id" value
 * @method factura setCostoTurno()        Sets the current record's "costo_turno" value
 * @method factura setCostoActividad()    Sets the current record's "costo_actividad" value
 * @method factura setCostoMatricula()    Sets the current record's "costo_matricula" value
 * @method factura setDescuentoHermano()  Sets the current record's "descuento_hermano" value
 * @method factura setDescuentoAlumno()   Sets the current record's "descuento_alumno" value
 * @method factura setTotal()             Sets the current record's "total" value
 * @method factura setMonth()             Sets the current record's "month" value
 * @method factura setYear()              Sets the current record's "year" value
 * @method factura setRecargoAtraso()     Sets the current record's "recargo_atraso" value
 * @method factura setPorcentajeAtraso()  Sets the current record's "porcentaje_atraso" value
 * @method factura setPago()              Sets the current record's "pago" value
 * @method factura setCancelado()         Sets the current record's "cancelado" value
 * @method factura setCuentaId()          Sets the current record's "cuenta_id" value
 * @method factura setCuenta()            Sets the current record's "cuenta" value
 * @method factura setUsuario()           Sets the current record's "usuario" value
 * 
 * @package    jardin
 * @subpackage model
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basefactura extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('factura');
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
        $this->hasColumn('costo_turno', 'float', 12, array(
             'type' => 'float',
             'default' => 0,
             'notnull' => true,
             'length' => 12,
             'scale' => '2',
             ));
        $this->hasColumn('costo_actividad', 'float', 12, array(
             'type' => 'float',
             'default' => 0,
             'notnull' => true,
             'length' => 12,
             'scale' => '2',
             ));
        $this->hasColumn('costo_matricula', 'float', 12, array(
             'type' => 'float',
             'default' => 0,
             'notnull' => true,
             'length' => 12,
             'scale' => '2',
             ));
        $this->hasColumn('descuento_hermano', 'float', 12, array(
             'type' => 'float',
             'default' => 0,
             'notnull' => true,
             'length' => 12,
             'scale' => '2',
             ));
        $this->hasColumn('descuento_alumno', 'float', 12, array(
             'type' => 'float',
             'default' => 0,
             'notnull' => true,
             'length' => 12,
             'scale' => '2',
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
        $this->hasColumn('recargo_atraso', 'float', 12, array(
             'type' => 'float',
             'default' => 0,
             'notnull' => true,
             'length' => 12,
             'scale' => '2',
             ));
        $this->hasColumn('porcentaje_atraso', 'float', 6, array(
             'type' => 'float',
             'default' => 0,
             'notnull' => true,
             'length' => 6,
             'scale' => '2',
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
        $this->hasColumn('cuenta_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('cuenta', array(
             'local' => 'cuenta_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('usuario', array(
             'local' => 'usuario_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}