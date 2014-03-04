<?php

/**
 * mdMediaAlbum filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdMediaAlbumFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'md_media_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdMedia'), 'add_empty' => true)),
      'title'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'         => new sfWidgetFormFilterInput(),
      'type'                => new sfWidgetFormChoice(array('choices' => array('' => '', 'Image' => 'Image', 'Video' => 'Video', 'File' => 'File', 'Mixed' => 'Mixed'))),
      'deleteAllowed'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'md_media_content_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdMediaContent'), 'add_empty' => true)),
      'counter_content'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'md_media_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('mdMedia'), 'column' => 'id')),
      'title'               => new sfValidatorPass(array('required' => false)),
      'description'         => new sfValidatorPass(array('required' => false)),
      'type'                => new sfValidatorChoice(array('required' => false, 'choices' => array('Image' => 'Image', 'Video' => 'Video', 'File' => 'File', 'Mixed' => 'Mixed'))),
      'deleteAllowed'       => new sfValidatorPass(array('required' => false)),
      'md_media_content_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('mdMediaContent'), 'column' => 'id')),
      'counter_content'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('md_media_album_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdMediaAlbum';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'md_media_id'         => 'ForeignKey',
      'title'               => 'Text',
      'description'         => 'Text',
      'type'                => 'Enum',
      'deleteAllowed'       => 'Text',
      'md_media_content_id' => 'ForeignKey',
      'counter_content'     => 'Number',
    );
  }
}
