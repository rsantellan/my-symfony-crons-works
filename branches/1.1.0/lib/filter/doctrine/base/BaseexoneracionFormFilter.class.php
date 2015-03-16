<?php

/**
 * exoneracion filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseexoneracionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => true)),
      'mes'        => new sfWidgetFormChoice(array('choices' => array('' => '', 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12))),
      'fecha'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'usuario_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('usuario'), 'column' => 'id')),
      'mes'        => new sfValidatorChoice(array('required' => false, 'choices' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12))),
      'fecha'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('exoneracion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'exoneracion';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'usuario_id' => 'ForeignKey',
      'mes'        => 'Enum',
      'fecha'      => 'Date',
    );
  }
}
