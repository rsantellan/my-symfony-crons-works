<?php

/**
 * mdGaleria filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdGaleriaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'curso_verde'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'curso_rojo'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'curso_amarillo' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'position'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'curso_verde'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'curso_rojo'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'curso_amarillo' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'position'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('md_galeria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdGaleria';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'curso_verde'    => 'Boolean',
      'curso_rojo'     => 'Boolean',
      'curso_amarillo' => 'Boolean',
      'position'       => 'Number',
    );
  }
}
