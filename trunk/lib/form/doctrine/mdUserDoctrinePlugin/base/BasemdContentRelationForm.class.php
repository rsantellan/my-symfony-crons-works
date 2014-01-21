<?php

/**
 * mdContentRelation form base class.
 *
 * @method mdContentRelation getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdContentRelationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'md_content_id_first'  => new sfWidgetFormInputHidden(),
      'md_content_id_second' => new sfWidgetFormInputHidden(),
      'object_class_name'    => new sfWidgetFormInputText(),
      'profile_name'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'md_content_id_first'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('md_content_id_first')), 'empty_value' => $this->getObject()->get('md_content_id_first'), 'required' => false)),
      'md_content_id_second' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('md_content_id_second')), 'empty_value' => $this->getObject()->get('md_content_id_second'), 'required' => false)),
      'object_class_name'    => new sfValidatorString(array('max_length' => 128)),
      'profile_name'         => new sfValidatorString(array('max_length' => 128, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_content_relation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdContentRelation';
  }

}
