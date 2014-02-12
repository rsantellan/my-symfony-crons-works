<?php

/**
 * mdMediaYoutubeVideo form base class.
 *
 * @method mdMediaYoutubeVideo getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdMediaYoutubeVideoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInputText(),
      'src'         => new sfWidgetFormInputText(),
      'code'        => new sfWidgetFormInputText(),
      'duration'    => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'path'        => new sfWidgetFormInputText(),
      'avatar'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 64)),
      'src'         => new sfValidatorString(array('max_length' => 255)),
      'code'        => new sfValidatorString(array('max_length' => 64)),
      'duration'    => new sfValidatorString(array('max_length' => 64)),
      'description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'path'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'avatar'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_media_youtube_video[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdMediaYoutubeVideo';
  }

}
