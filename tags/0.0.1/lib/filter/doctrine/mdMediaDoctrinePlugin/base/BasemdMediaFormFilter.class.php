<?php

/**
 * mdMedia filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdMediaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'object_class_name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'object_id'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'object_class_name' => new sfValidatorPass(array('required' => false)),
      'object_id'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('md_media_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdMedia';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'object_class_name' => 'Text',
      'object_id'         => 'Number',
    );
  }
}
