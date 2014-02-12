<?php

/**
 * mdMediaIssuuVideo form base class.
 *
 * @method mdMediaIssuuVideo getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdMediaIssuuVideoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'documentId' => new sfWidgetFormTextarea(),
      'embed_code' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'documentId' => new sfValidatorString(array('max_length' => 512)),
      'embed_code' => new sfValidatorPass(),
    ));

    $this->widgetSchema->setNameFormat('md_media_issuu_video[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdMediaIssuuVideo';
  }

}
