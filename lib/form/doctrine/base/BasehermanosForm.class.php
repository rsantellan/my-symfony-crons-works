<?php

/**
 * hermanos form base class.
 *
 * @method hermanos getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasehermanosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_from' => new sfWidgetFormInputHidden(),
      'usuario_to'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'usuario_from' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('usuario_from')), 'empty_value' => $this->getObject()->get('usuario_from'), 'required' => false)),
      'usuario_to'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('usuario_to')), 'empty_value' => $this->getObject()->get('usuario_to'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hermanos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'hermanos';
  }

}
