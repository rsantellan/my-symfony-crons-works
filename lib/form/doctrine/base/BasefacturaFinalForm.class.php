<?php

/**
 * facturaFinal form base class.
 *
 * @method facturaFinal getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefacturaFinalForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'total'            => new sfWidgetFormInputText(),
      'month'            => new sfWidgetFormInputText(),
      'year'             => new sfWidgetFormInputText(),
      'pago'             => new sfWidgetFormInputText(),
      'cancelado'        => new sfWidgetFormInputText(),
      'enviado'          => new sfWidgetFormInputText(),
      'cuenta_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('cuenta'), 'add_empty' => false)),
      'fechavencimiento' => new sfWidgetFormDate(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'total'            => new sfValidatorNumber(array('required' => false)),
      'month'            => new sfValidatorInteger(),
      'year'             => new sfValidatorInteger(),
      'pago'             => new sfValidatorInteger(array('required' => false)),
      'cancelado'        => new sfValidatorInteger(array('required' => false)),
      'enviado'          => new sfValidatorInteger(array('required' => false)),
      'cuenta_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('cuenta'))),
      'fechavencimiento' => new sfValidatorDate(),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'facturaFinal', 'column' => array('month', 'year', 'cuenta_id')))
    );

    $this->widgetSchema->setNameFormat('factura_final[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'facturaFinal';
  }

}
