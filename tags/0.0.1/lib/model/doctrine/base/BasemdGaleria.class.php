<?php

/**
 * BasemdGaleria
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $titulo
 * @property string $descripcion
 * @property boolean $curso_verde
 * @property boolean $curso_rojo
 * @property boolean $curso_amarillo
 * 
 * @method integer   getId()             Returns the current record's "id" value
 * @method string    getTitulo()         Returns the current record's "titulo" value
 * @method string    getDescripcion()    Returns the current record's "descripcion" value
 * @method boolean   getCursoVerde()     Returns the current record's "curso_verde" value
 * @method boolean   getCursoRojo()      Returns the current record's "curso_rojo" value
 * @method boolean   getCursoAmarillo()  Returns the current record's "curso_amarillo" value
 * @method mdGaleria setId()             Sets the current record's "id" value
 * @method mdGaleria setTitulo()         Sets the current record's "titulo" value
 * @method mdGaleria setDescripcion()    Sets the current record's "descripcion" value
 * @method mdGaleria setCursoVerde()     Sets the current record's "curso_verde" value
 * @method mdGaleria setCursoRojo()      Sets the current record's "curso_rojo" value
 * @method mdGaleria setCursoAmarillo()  Sets the current record's "curso_amarillo" value
 * 
 * @package    jardin
 * @subpackage model
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdGaleria extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_galeria');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('titulo', 'string', 128, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 128,
             ));
        $this->hasColumn('descripcion', 'string', 500, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 500,
             ));
        $this->hasColumn('curso_verde', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('curso_rojo', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('curso_amarillo', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $mdmediabehavior0 = new mdMediaBehavior();
        $sortable0 = new Doctrine_Template_Sortable();
        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'titulo',
              1 => 'descripcion',
             ),
             ));
        $this->actAs($mdmediabehavior0);
        $this->actAs($sortable0);
        $this->actAs($i18n0);
    }
}