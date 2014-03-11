<?php

/**
 * mdMediaVimeoVideo form base class.
 *
 * @method mdMediaVimeoVideo getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdMediaVimeoVideoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'vimeo_url'     => new sfWidgetFormInputText(),
      'title'         => new sfWidgetFormInputText(),
      'src'           => new sfWidgetFormInputText(),
      'duration'      => new sfWidgetFormInputText(),
      'description'   => new sfWidgetFormTextarea(),
      'avatar'        => new sfWidgetFormInputText(),
      'avatar_width'  => new sfWidgetFormInputText(),
      'avatar_height' => new sfWidgetFormInputText(),
      'author_name'   => new sfWidgetFormInputText(),
      'author_url'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'vimeo_url'     => new sfValidatorString(array('max_length' => 64)),
      'title'         => new sfValidatorString(array('max_length' => 255)),
      'src'           => new sfValidatorString(array('max_length' => 255)),
      'duration'      => new sfValidatorString(array('max_length' => 64)),
      'description'   => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'avatar'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'avatar_width'  => new sfValidatorInteger(array('required' => false)),
      'avatar_height' => new sfValidatorInteger(array('required' => false)),
      'author_name'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'author_url'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_media_vimeo_video[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdMediaVimeoVideo';
  }

}
