<?php

/**
 * mdMediaAlbum form base class.
 *
 * @method mdMediaAlbum getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdMediaAlbumForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'md_media_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdMedia'), 'add_empty' => true)),
      'title'               => new sfWidgetFormInputText(),
      'description'         => new sfWidgetFormInputText(),
      'type'                => new sfWidgetFormChoice(array('choices' => array('Image' => 'Image', 'Video' => 'Video', 'File' => 'File', 'Mixed' => 'Mixed'))),
      'deleteAllowed'       => new sfWidgetFormInputText(),
      'md_media_content_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdMediaContent'), 'add_empty' => true)),
      'counter_content'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'md_media_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdMedia'), 'required' => false)),
      'title'               => new sfValidatorString(array('max_length' => 64)),
      'description'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'type'                => new sfValidatorChoice(array('choices' => array(0 => 'Image', 1 => 'Video', 2 => 'File', 3 => 'Mixed'), 'required' => false)),
      'deleteAllowed'       => new sfValidatorPass(),
      'md_media_content_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdMediaContent'), 'required' => false)),
      'counter_content'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'mdMediaAlbum', 'column' => array('md_media_id', 'title')))
    );

    $this->widgetSchema->setNameFormat('md_media_album[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdMediaAlbum';
  }

}
