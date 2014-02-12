<?php

/**
 * usuario_progenitor form base class.
 *
 * @method usuario_progenitor getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class Baseusuario_progenitorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id'    => new sfWidgetFormInputHidden(),
      'progenitor_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'usuario_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('usuario_id')), 'empty_value' => $this->getObject()->get('usuario_id'), 'required' => false)),
      'progenitor_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('progenitor_id')), 'empty_value' => $this->getObject()->get('progenitor_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_progenitor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'usuario_progenitor';
  }

}
