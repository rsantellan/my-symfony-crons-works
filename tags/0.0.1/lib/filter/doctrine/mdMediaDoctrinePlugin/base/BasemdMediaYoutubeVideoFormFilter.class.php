<?php

/**
 * mdMediaYoutubeVideo filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdMediaYoutubeVideoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'src'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'code'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'duration'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description' => new sfWidgetFormFilterInput(),
      'path'        => new sfWidgetFormFilterInput(),
      'avatar'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'src'         => new sfValidatorPass(array('required' => false)),
      'code'        => new sfValidatorPass(array('required' => false)),
      'duration'    => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'path'        => new sfValidatorPass(array('required' => false)),
      'avatar'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_media_youtube_video_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdMediaYoutubeVideo';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'name'        => 'Text',
      'src'         => 'Text',
      'code'        => 'Text',
      'duration'    => 'Text',
      'description' => 'Text',
      'path'        => 'Text',
      'avatar'      => 'Text',
    );
  }
}
