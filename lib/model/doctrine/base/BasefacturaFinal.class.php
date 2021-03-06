<?php

/**
 * BasefacturaFinal
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property float $total
 * @property integer $month
 * @property integer $year
 * @property integer $pago
 * @property integer $cancelado
 * @property integer $enviado
 * @property integer $cuenta_id
 * @property date $fechavencimiento
 * @property float $pagadodeltotal
 * @property cuenta $cuenta
 * @property Doctrine_Collection $facturaFinalDetalle
 * @property Doctrine_Collection $facturausuariofinal
 * 
 * @method integer             getId()                  Returns the current record's "id" value
 * @method float               getTotal()               Returns the current record's "total" value
 * @method integer             getMonth()               Returns the current record's "month" value
 * @method integer             getYear()                Returns the current record's "year" value
 * @method integer             getPago()                Returns the current record's "pago" value
 * @method integer             getCancelado()           Returns the current record's "cancelado" value
 * @method integer             getEnviado()             Returns the current record's "enviado" value
 * @method integer             getCuentaId()            Returns the current record's "cuenta_id" value
 * @method date                getFechavencimiento()    Returns the current record's "fechavencimiento" value
 * @method float               getPagadodeltotal()      Returns the current record's "pagadodeltotal" value
 * @method cuenta              getCuenta()              Returns the current record's "cuenta" value
 * @method Doctrine_Collection getFacturaFinalDetalle() Returns the current record's "facturaFinalDetalle" collection
 * @method Doctrine_Collection getFacturausuariofinal() Returns the current record's "facturausuariofinal" collection
 * @method facturaFinal        setId()                  Sets the current record's "id" value
 * @method facturaFinal        setTotal()               Sets the current record's "total" value
 * @method facturaFinal        setMonth()               Sets the current record's "month" value
 * @method facturaFinal        setYear()                Sets the current record's "year" value
 * @method facturaFinal        setPago()                Sets the current record's "pago" value
 * @method facturaFinal        setCancelado()           Sets the current record's "cancelado" value
 * @method facturaFinal        setEnviado()             Sets the current record's "enviado" value
 * @method facturaFinal        setCuentaId()            Sets the current record's "cuenta_id" value
 * @method facturaFinal        setFechavencimiento()    Sets the current record's "fechavencimiento" value
 * @method facturaFinal        setPagadodeltotal()      Sets the current record's "pagadodeltotal" value
 * @method facturaFinal        setCuenta()              Sets the current record's "cuenta" value
 * @method facturaFinal        setFacturaFinalDetalle() Sets the current record's "facturaFinalDetalle" collection
 * @method facturaFinal        setFacturausuariofinal() Sets the current record's "facturausuariofinal" collection
 * 
 * @package    jardin
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasefacturaFinal extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('facturaFinal');
        $this->hasColumn('id', 'integer', 20, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 20,
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
        $this->hasColumn('enviado', 'integer', 1, array(
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
        $this->hasColumn('fechavencimiento', 'date', 25, array(
             'type' => 'date',
             'notnull' => true,
             'length' => 25,
             ));
        $this->hasColumn('pagadodeltotal', 'float', 12, array(
             'type' => 'float',
             'default' => 0,
             'notnull' => true,
             'length' => 12,
             'scale' => '2',
             ));


        $this->index('monthly_yearly_user_index', array(
             'fields' => 
             array(
              0 => 'month',
              1 => 'year',
              2 => 'cuenta_id',
             ),
             'type' => 'unique',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('cuenta', array(
             'local' => 'cuenta_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('facturaFinalDetalle', array(
             'local' => 'id',
             'foreign' => 'factura_id'));

        $this->hasMany('facturausuariofinal', array(
             'local' => 'id',
             'foreign' => 'factura_final_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}