<?php

/**
 * costos filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecostosFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'matricula'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'matutino'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'vespertino'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'doble_horario' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'matricula'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'matutino'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'vespertino'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'doble_horario' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('costos_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'costos';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'matricula'     => 'Number',
      'matutino'      => 'Number',
      'vespertino'    => 'Number',
      'doble_horario' => 'Number',
    );
  }
}
