<?php

/**
 * mdMediaAlbumContent form base class.
 *
 * @method mdMediaAlbumContent getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdMediaAlbumContentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'md_media_album_id'   => new sfWidgetFormInputHidden(),
      'md_media_content_id' => new sfWidgetFormInputHidden(),
      'object_class_name'   => new sfWidgetFormInputText(),
      'priority'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'md_media_album_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('md_media_album_id')), 'empty_value' => $this->getObject()->get('md_media_album_id'), 'required' => false)),
      'md_media_content_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('md_media_content_id')), 'empty_value' => $this->getObject()->get('md_media_content_id'), 'required' => false)),
      'object_class_name'   => new sfValidatorString(array('max_length' => 128)),
      'priority'            => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('md_media_album_content[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdMediaAlbumContent';
  }

}
