<?php

/**
 * mdPassport form base class.
 *
 * @method mdPassport getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdPassportForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'md_user_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdUser'), 'add_empty' => false)),
      'username'        => new sfWidgetFormInputText(),
      'password'        => new sfWidgetFormInputText(),
      'account_active'  => new sfWidgetFormInputText(),
      'account_blocked' => new sfWidgetFormInputText(),
      'last_login'      => new sfWidgetFormDateTime(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'md_user_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdUser'))),
      'username'        => new sfValidatorString(array('max_length' => 128)),
      'password'        => new sfValidatorString(array('max_length' => 128)),
      'account_active'  => new sfValidatorInteger(array('required' => false)),
      'account_blocked' => new sfValidatorInteger(array('required' => false)),
      'last_login'      => new sfValidatorDateTime(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('md_passport[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdPassport';
  }

}
