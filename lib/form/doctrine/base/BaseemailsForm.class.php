<?php

/**
 * emails form base class.
 *
 * @method emails getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseemailsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'type'      => new sfWidgetFormInputText(),
      'from_name' => new sfWidgetFormInputText(),
      'from_mail' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'type'      => new sfValidatorString(array('max_length' => 32)),
      'from_name' => new sfValidatorString(array('max_length' => 64)),
      'from_mail' => new sfValidatorString(array('max_length' => 64)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'emails', 'column' => array('type')))
    );

    $this->widgetSchema->setNameFormat('emails[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'emails';
  }

}
