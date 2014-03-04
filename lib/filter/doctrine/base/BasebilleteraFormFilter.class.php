<?php

/**
 * billetera filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasebilleteraFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'credito'  => new sfWidgetFormFilterInput(),
      'deuda'    => new sfWidgetFormFilterInput(),
      'impuesto' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'credito'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'deuda'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'impuesto' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('billetera_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'billetera';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'credito'  => 'Number',
      'deuda'    => 'Number',
      'impuesto' => 'Number',
    );
  }
}
