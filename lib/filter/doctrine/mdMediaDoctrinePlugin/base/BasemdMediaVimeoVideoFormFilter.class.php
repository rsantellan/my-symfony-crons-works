<?php

/**
 * mdMediaVimeoVideo filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdMediaVimeoVideoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'vimeo_url'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'title'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'src'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'duration'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'   => new sfWidgetFormFilterInput(),
      'avatar'        => new sfWidgetFormFilterInput(),
      'avatar_width'  => new sfWidgetFormFilterInput(),
      'avatar_height' => new sfWidgetFormFilterInput(),
      'author_name'   => new sfWidgetFormFilterInput(),
      'author_url'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'vimeo_url'     => new sfValidatorPass(array('required' => false)),
      'title'         => new sfValidatorPass(array('required' => false)),
      'src'           => new sfValidatorPass(array('required' => false)),
      'duration'      => new sfValidatorPass(array('required' => false)),
      'description'   => new sfValidatorPass(array('required' => false)),
      'avatar'        => new sfValidatorPass(array('required' => false)),
      'avatar_width'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'avatar_height' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'author_name'   => new sfValidatorPass(array('required' => false)),
      'author_url'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_media_vimeo_video_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdMediaVimeoVideo';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'vimeo_url'     => 'Text',
      'title'         => 'Text',
      'src'           => 'Text',
      'duration'      => 'Text',
      'description'   => 'Text',
      'avatar'        => 'Text',
      'avatar_width'  => 'Number',
      'avatar_height' => 'Number',
      'author_name'   => 'Text',
      'author_url'    => 'Text',
    );
  }
}
