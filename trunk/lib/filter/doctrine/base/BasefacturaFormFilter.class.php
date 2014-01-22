<?php

/**
 * factura filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasefacturaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => true)),
      'costo_turno'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'costo_actividad'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'costo_matricula'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descuento_hermano' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descuento_alumno'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'total'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'month'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'year'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'recargo_atraso'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'porcentaje_atraso' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pago'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cancelado'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cuenta_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('cuenta'), 'add_empty' => true)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'usuario_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('usuario'), 'column' => 'id')),
      'costo_turno'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_actividad'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_matricula'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'descuento_hermano' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'descuento_alumno'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'month'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'year'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'recargo_atraso'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'porcentaje_atraso' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'pago'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cancelado'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cuenta_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('cuenta'), 'column' => 'id')),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('factura_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'factura';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'usuario_id'        => 'ForeignKey',
      'costo_turno'       => 'Number',
      'costo_actividad'   => 'Number',
      'costo_matricula'   => 'Number',
      'descuento_hermano' => 'Number',
      'descuento_alumno'  => 'Number',
      'total'             => 'Number',
      'month'             => 'Number',
      'year'              => 'Number',
      'recargo_atraso'    => 'Number',
      'porcentaje_atraso' => 'Number',
      'pago'              => 'Number',
      'cancelado'         => 'Number',
      'cuenta_id'         => 'ForeignKey',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
    );
  }
}
