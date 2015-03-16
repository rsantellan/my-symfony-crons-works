<?php

/**
 * mdUser form base class.
 *
 * @method mdUser getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'email'       => new sfWidgetFormInputText(),
      'super_admin' => new sfWidgetFormInputText(),
      'culture'     => new sfWidgetFormInputText(),
      'deleted_at'  => new sfWidgetFormDateTime(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'email'       => new sfValidatorString(array('max_length' => 128)),
      'super_admin' => new sfValidatorInteger(array('required' => false)),
      'culture'     => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'deleted_at'  => new sfValidatorDateTime(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'mdUser', 'column' => array('email')))
    );

    $this->widgetSchema->setNameFormat('md_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdUser';
  }

}
