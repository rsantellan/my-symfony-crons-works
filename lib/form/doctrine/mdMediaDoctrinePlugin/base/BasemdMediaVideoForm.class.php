<?php

/**
 * mdMediaVideo form base class.
 *
 * @method mdMediaVideo getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdMediaVideoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInputText(),
      'filename'    => new sfWidgetFormInputText(),
      'duration'    => new sfWidgetFormInputText(),
      'type'        => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'path'        => new sfWidgetFormInputText(),
      'avatar'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 64)),
      'filename'    => new sfValidatorString(array('max_length' => 64)),
      'duration'    => new sfValidatorString(array('max_length' => 64)),
      'type'        => new sfValidatorString(array('max_length' => 64)),
      'description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'path'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'avatar'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_media_video[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdMediaVideo';
  }

}
