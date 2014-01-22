<?php

/**
 * factura form base class.
 *
 * @method factura getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefacturaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'usuario_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => false)),
      'costo_turno'       => new sfWidgetFormInputText(),
      'costo_actividad'   => new sfWidgetFormInputText(),
      'costo_matricula'   => new sfWidgetFormInputText(),
      'descuento_hermano' => new sfWidgetFormInputText(),
      'descuento_alumno'  => new sfWidgetFormInputText(),
      'total'             => new sfWidgetFormInputText(),
      'month'             => new sfWidgetFormInputText(),
      'year'              => new sfWidgetFormInputText(),
      'recargo_atraso'    => new sfWidgetFormInputText(),
      'porcentaje_atraso' => new sfWidgetFormInputText(),
      'pago'              => new sfWidgetFormInputText(),
      'cancelado'         => new sfWidgetFormInputText(),
      'cuenta_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('cuenta'), 'add_empty' => false)),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'usuario_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'))),
      'costo_turno'       => new sfValidatorNumber(array('required' => false)),
      'costo_actividad'   => new sfValidatorNumber(array('required' => false)),
      'costo_matricula'   => new sfValidatorNumber(array('required' => false)),
      'descuento_hermano' => new sfValidatorNumber(array('required' => false)),
      'descuento_alumno'  => new sfValidatorNumber(array('required' => false)),
      'total'             => new sfValidatorNumber(array('required' => false)),
      'month'             => new sfValidatorInteger(),
      'year'              => new sfValidatorInteger(),
      'recargo_atraso'    => new sfValidatorNumber(array('required' => false)),
      'porcentaje_atraso' => new sfValidatorNumber(array('required' => false)),
      'pago'              => new sfValidatorInteger(array('required' => false)),
      'cancelado'         => new sfValidatorInteger(array('required' => false)),
      'cuenta_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('cuenta'))),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('factura[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'factura';
  }

}
