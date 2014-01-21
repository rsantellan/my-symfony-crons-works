<?php

/**
 * emails filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseemailsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'type'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'from_name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'from_mail' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'type'      => new sfValidatorPass(array('required' => false)),
      'from_name' => new sfValidatorPass(array('required' => false)),
      'from_mail' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('emails_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'emails';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'type'      => 'Text',
      'from_name' => 'Text',
      'from_mail' => 'Text',
    );
  }
}
