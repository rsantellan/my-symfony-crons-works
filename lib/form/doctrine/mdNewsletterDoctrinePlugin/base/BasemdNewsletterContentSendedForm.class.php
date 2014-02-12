<?php

/**
 * mdNewsletterContentSended form base class.
 *
 * @method mdNewsletterContentSended getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdNewsletterContentSendedForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'subject'                  => new sfWidgetFormTextarea(),
      'body'                     => new sfWidgetFormTextarea(),
      'send_counter'             => new sfWidgetFormInputText(),
      'sending_date'             => new sfWidgetFormDateTime(),
      'sended'                   => new sfWidgetFormInputCheckbox(),
      'for_status'               => new sfWidgetFormInputText(),
      'md_newsletter_content_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdNewsletterContent'), 'add_empty' => false)),
      'created_at'               => new sfWidgetFormDateTime(),
      'updated_at'               => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'subject'                  => new sfValidatorString(array('max_length' => 256)),
      'body'                     => new sfValidatorString(),
      'send_counter'             => new sfValidatorInteger(),
      'sending_date'             => new sfValidatorDateTime(array('required' => false)),
      'sended'                   => new sfValidatorBoolean(array('required' => false)),
      'for_status'               => new sfValidatorInteger(array('required' => false)),
      'md_newsletter_content_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdNewsletterContent'))),
      'created_at'               => new sfValidatorDateTime(),
      'updated_at'               => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('md_newsletter_content_sended[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdNewsletterContentSended';
  }

}
