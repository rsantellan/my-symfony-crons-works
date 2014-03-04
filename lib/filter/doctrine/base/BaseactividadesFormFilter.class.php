<?php

/**
 * actividades filter form base class.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseactividadesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'costo'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'horario'                 => new sfWidgetFormChoice(array('choices' => array('' => '', 'mañana' => 'mañana', 'tarde' => 'tarde', 'mañana y tarde' => 'mañana y tarde'))),
      'md_news_letter_group_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdNewsLetterGroup'), 'add_empty' => true)),
      'usuarios_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'usuario')),
    ));

    $this->setValidators(array(
      'nombre'                  => new sfValidatorPass(array('required' => false)),
      'costo'                   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'horario'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('mañana' => 'mañana', 'tarde' => 'tarde', 'mañana y tarde' => 'mañana y tarde'))),
      'md_news_letter_group_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('mdNewsLetterGroup'), 'column' => 'id')),
      'usuarios_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'usuario', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('actividades_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addUsuariosListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.usuario_actividades usuario_actividades')
      ->andWhereIn('usuario_actividades.usuario_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'actividades';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'nombre'                  => 'Text',
      'costo'                   => 'Number',
      'horario'                 => 'Enum',
      'md_news_letter_group_id' => 'ForeignKey',
      'usuarios_list'           => 'ManyKey',
    );
  }
}
