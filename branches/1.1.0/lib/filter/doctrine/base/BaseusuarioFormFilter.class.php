<?php

/**
 * usuario filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseusuarioFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'apellido'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fecha_nacimiento'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'anio_ingreso'        => new sfWidgetFormFilterInput(),
      'sociedad'            => new sfWidgetFormFilterInput(),
      'referencia_bancaria' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'emergencia_medica'   => new sfWidgetFormFilterInput(),
      'horario'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'matutino' => 'matutino', 'vespertino' => 'vespertino', 'doble_horario' => 'doble_horario'))),
      'futuro_colegio'      => new sfWidgetFormFilterInput(),
      'descuento'           => new sfWidgetFormFilterInput(),
      'clase'               => new sfWidgetFormChoice(array('choices' => array('' => '', 'verde' => 'verde', 'amarillo' => 'amarillo', 'rojo' => 'rojo'))),
      'egresado'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'billetera_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('billetera'), 'add_empty' => true)),
      'actividades_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'actividades')),
      'progenitores_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'progenitor')),
    ));

    $this->setValidators(array(
      'nombre'              => new sfValidatorPass(array('required' => false)),
      'apellido'            => new sfValidatorPass(array('required' => false)),
      'fecha_nacimiento'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'anio_ingreso'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sociedad'            => new sfValidatorPass(array('required' => false)),
      'referencia_bancaria' => new sfValidatorPass(array('required' => false)),
      'emergencia_medica'   => new sfValidatorPass(array('required' => false)),
      'horario'             => new sfValidatorChoice(array('required' => false, 'choices' => array('matutino' => 'matutino', 'vespertino' => 'vespertino', 'doble_horario' => 'doble_horario'))),
      'futuro_colegio'      => new sfValidatorPass(array('required' => false)),
      'descuento'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'clase'               => new sfValidatorChoice(array('required' => false, 'choices' => array('verde' => 'verde', 'amarillo' => 'amarillo', 'rojo' => 'rojo'))),
      'egresado'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'billetera_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('billetera'), 'column' => 'id')),
      'actividades_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'actividades', 'required' => false)),
      'progenitores_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'progenitor', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addActividadesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.usuario_actividades usuario_actividades')
      ->andWhereIn('usuario_actividades.actividad_id', $values)
    ;
  }

  public function addProgenitoresListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.usuario_progenitor usuario_progenitor')
      ->andWhereIn('usuario_progenitor.progenitor_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'usuario';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'nombre'              => 'Text',
      'apellido'            => 'Text',
      'fecha_nacimiento'    => 'Date',
      'anio_ingreso'        => 'Number',
      'sociedad'            => 'Text',
      'referencia_bancaria' => 'Text',
      'emergencia_medica'   => 'Text',
      'horario'             => 'Enum',
      'futuro_colegio'      => 'Text',
      'descuento'           => 'Number',
      'clase'               => 'Enum',
      'egresado'            => 'Boolean',
      'billetera_id'        => 'ForeignKey',
      'actividades_list'    => 'ManyKey',
      'progenitores_list'   => 'ManyKey',
    );
  }
}
