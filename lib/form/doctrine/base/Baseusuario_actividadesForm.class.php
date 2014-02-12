<?php

/**
 * usuario_actividades form base class.
 *
 * @method usuario_actividades getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class Baseusuario_actividadesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id'   => new sfWidgetFormInputHidden(),
      'actividad_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'usuario_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('usuario_id')), 'empty_value' => $this->getObject()->get('usuario_id'), 'required' => false)),
      'actividad_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('actividad_id')), 'empty_value' => $this->getObject()->get('actividad_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_actividades[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'usuario_actividades';
  }

}
