<?php

/**
 * facturaUsuario filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasefacturaUsuarioFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => true)),
      'total'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'month'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'year'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'enviado'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pago'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cancelado'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fechavencimiento' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'usuario_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('usuario'), 'column' => 'id')),
      'total'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'month'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'year'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'enviado'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'pago'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cancelado'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fechavencimiento' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('factura_usuario_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'facturaUsuario';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'usuario_id'       => 'ForeignKey',
      'total'            => 'Number',
      'month'            => 'Number',
      'year'             => 'Number',
      'enviado'          => 'Number',
      'pago'             => 'Number',
      'cancelado'        => 'Number',
      'fechavencimiento' => 'Date',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
    );
  }
}
