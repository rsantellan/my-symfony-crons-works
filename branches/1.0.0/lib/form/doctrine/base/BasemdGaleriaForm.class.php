<?php

/**
 * mdGaleria form base class.
 *
 * @method mdGaleria getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdGaleriaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'curso_verde'    => new sfWidgetFormInputCheckbox(),
      'curso_rojo'     => new sfWidgetFormInputCheckbox(),
      'curso_amarillo' => new sfWidgetFormInputCheckbox(),
      'position'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'curso_verde'    => new sfValidatorBoolean(array('required' => false)),
      'curso_rojo'     => new sfValidatorBoolean(array('required' => false)),
      'curso_amarillo' => new sfValidatorBoolean(array('required' => false)),
      'position'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'mdGaleria', 'column' => array('position')))
    );

    $this->widgetSchema->setNameFormat('md_galeria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdGaleria';
  }

}
