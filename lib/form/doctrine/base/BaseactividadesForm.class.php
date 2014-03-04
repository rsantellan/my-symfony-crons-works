<?php

/**
 * actividades form base class.
 *
 * @method actividades getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseactividadesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'nombre'                  => new sfWidgetFormInputText(),
      'costo'                   => new sfWidgetFormInputText(),
      'horario'                 => new sfWidgetFormChoice(array('choices' => array('mañana' => 'mañana', 'tarde' => 'tarde', 'mañana y tarde' => 'mañana y tarde'))),
      'md_news_letter_group_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdNewsLetterGroup'), 'add_empty' => true)),
      'usuarios_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'usuario')),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'                  => new sfValidatorString(array('max_length' => 64)),
      'costo'                   => new sfValidatorNumber(),
      'horario'                 => new sfValidatorChoice(array('choices' => array(0 => 'mañana', 1 => 'tarde', 2 => 'mañana y tarde'), 'required' => false)),
      'md_news_letter_group_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdNewsLetterGroup'), 'required' => false)),
      'usuarios_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'usuario', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('actividades[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'actividades';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['usuarios_list']))
    {
      $this->setDefault('usuarios_list', $this->object->usuarios->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveusuariosList($con);

    parent::doSave($con);
  }

  public function saveusuariosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['usuarios_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->usuarios->getPrimaryKeys();
    $values = $this->getValue('usuarios_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('usuarios', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('usuarios', array_values($link));
    }
  }

}
