<?php

/**
 * billetera form base class.
 *
 * @method billetera getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasebilleteraForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'credito'  => new sfWidgetFormInputText(),
      'deuda'    => new sfWidgetFormInputText(),
      'impuesto' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'credito'  => new sfValidatorInteger(array('required' => false)),
      'deuda'    => new sfValidatorInteger(array('required' => false)),
      'impuesto' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('billetera[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'billetera';
  }

}
