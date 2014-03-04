<?php

/**
 * mdBlockedUsers form base class.
 *
 * @method mdBlockedUsers getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdBlockedUsersForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'md_user_id' => new sfWidgetFormInputHidden(),
      'reason'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'md_user_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('md_user_id')), 'empty_value' => $this->getObject()->get('md_user_id'), 'required' => false)),
      'reason'     => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('md_blocked_users[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdBlockedUsers';
  }

}
