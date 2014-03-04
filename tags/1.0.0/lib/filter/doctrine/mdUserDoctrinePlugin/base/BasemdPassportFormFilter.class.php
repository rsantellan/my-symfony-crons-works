<?php

/**
 * mdPassport filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdPassportFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'md_user_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdUser'), 'add_empty' => true)),
      'username'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'password'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'account_active'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'account_blocked' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'last_login'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'md_user_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('mdUser'), 'column' => 'id')),
      'username'        => new sfValidatorPass(array('required' => false)),
      'password'        => new sfValidatorPass(array('required' => false)),
      'account_active'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'account_blocked' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'last_login'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('md_passport_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdPassport';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'md_user_id'      => 'ForeignKey',
      'username'        => 'Text',
      'password'        => 'Text',
      'account_active'  => 'Number',
      'account_blocked' => 'Number',
      'last_login'      => 'Date',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
    );
  }
}
