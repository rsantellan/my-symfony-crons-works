<?php

/**
 * costos form base class.
 *
 * @method costos getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecostosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'matricula'     => new sfWidgetFormInputText(),
      'matutino'      => new sfWidgetFormInputText(),
      'vespertino'    => new sfWidgetFormInputText(),
      'doble_horario' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'matricula'     => new sfValidatorNumber(),
      'matutino'      => new sfValidatorNumber(),
      'vespertino'    => new sfValidatorNumber(),
      'doble_horario' => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('costos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'costos';
  }

}
