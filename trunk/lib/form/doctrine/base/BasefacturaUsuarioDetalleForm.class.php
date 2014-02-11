<?php

/**
 * facturaUsuarioDetalle form base class.
 *
 * @method facturaUsuarioDetalle getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefacturaUsuarioDetalleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'factura_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('facturaUsuario'), 'add_empty' => false)),
      'description' => new sfWidgetFormInputText(),
      'amount'      => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'factura_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('facturaUsuario'))),
      'description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'amount'      => new sfValidatorNumber(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('factura_usuario_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'facturaUsuarioDetalle';
  }

}
