<?php

/**
 * facturaFinal filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasefacturaFinalFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'total'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'month'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'year'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pago'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cancelado'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'enviado'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cuenta_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('cuenta'), 'add_empty' => true)),
      'fechavencimiento' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'total'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'month'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'year'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'pago'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cancelado'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'enviado'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cuenta_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('cuenta'), 'column' => 'id')),
      'fechavencimiento' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('factura_final_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'facturaFinal';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'total'            => 'Number',
      'month'            => 'Number',
      'year'             => 'Number',
      'pago'             => 'Number',
      'cancelado'        => 'Number',
      'enviado'          => 'Number',
      'cuenta_id'        => 'ForeignKey',
      'fechavencimiento' => 'Date',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
    );
  }
}
