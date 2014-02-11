<?php

/**
 * cuenta form base class.
 *
 * @method cuenta getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecuentaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'referenciabancaria' => new sfWidgetFormInputText(),
      'debe'               => new sfWidgetFormInputText(),
      'pago'               => new sfWidgetFormInputText(),
      'diferencia'         => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'referenciabancaria' => new sfValidatorString(array('max_length' => 64)),
      'debe'               => new sfValidatorNumber(array('required' => false)),
      'pago'               => new sfValidatorNumber(array('required' => false)),
      'diferencia'         => new sfValidatorNumber(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cuenta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'cuenta';
  }

}
