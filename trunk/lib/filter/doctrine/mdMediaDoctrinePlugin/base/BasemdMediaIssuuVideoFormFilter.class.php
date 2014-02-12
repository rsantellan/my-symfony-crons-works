<?php

/**
 * mdMediaIssuuVideo filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdMediaIssuuVideoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'documentId' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'embed_code' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'documentId' => new sfValidatorPass(array('required' => false)),
      'embed_code' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_media_issuu_video_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdMediaIssuuVideo';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'documentId' => 'Text',
      'embed_code' => 'Text',
    );
  }
}
