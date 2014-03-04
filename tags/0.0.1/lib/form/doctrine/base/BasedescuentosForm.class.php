<?php

/**
 * descuentos form base class.
 *
 * @method descuentos getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasedescuentosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'cantidad_de_hermanos' => new sfWidgetFormInputText(),
      'porcentaje'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'cantidad_de_hermanos' => new sfValidatorInteger(),
      'porcentaje'           => new sfValidatorInteger(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'descuentos', 'column' => array('cantidad_de_hermanos')))
    );

    $this->widgetSchema->setNameFormat('descuentos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'descuentos';
  }

}
