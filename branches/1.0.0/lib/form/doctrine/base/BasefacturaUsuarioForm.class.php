<?php

/**
 * facturaUsuario form base class.
 *
 * @method facturaUsuario getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefacturaUsuarioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'usuario_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => false)),
      'total'            => new sfWidgetFormInputText(),
      'month'            => new sfWidgetFormInputText(),
      'year'             => new sfWidgetFormInputText(),
      'enviado'          => new sfWidgetFormInputText(),
      'pago'             => new sfWidgetFormInputText(),
      'cancelado'        => new sfWidgetFormInputText(),
      'fechavencimiento' => new sfWidgetFormDate(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'usuario_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'))),
      'total'            => new sfValidatorNumber(array('required' => false)),
      'month'            => new sfValidatorInteger(),
      'year'             => new sfValidatorInteger(),
      'enviado'          => new sfValidatorInteger(array('required' => false)),
      'pago'             => new sfValidatorInteger(array('required' => false)),
      'cancelado'        => new sfValidatorInteger(array('required' => false)),
      'fechavencimiento' => new sfValidatorDate(),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'facturaUsuario', 'column' => array('month', 'year', 'usuario_id')))
    );

    $this->widgetSchema->setNameFormat('factura_usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'facturaUsuario';
  }

}
