<?php

/**
 * cuenta filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecuentaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'referenciabancaria' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'debe'               => new sfWidgetFormFilterInput(),
      'pago'               => new sfWidgetFormFilterInput(),
      'diferencia'         => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'referenciabancaria' => new sfValidatorPass(array('required' => false)),
      'debe'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'pago'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'diferencia'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('cuenta_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'cuenta';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'referenciabancaria' => 'Text',
      'debe'               => 'Number',
      'pago'               => 'Number',
      'diferencia'         => 'Number',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
