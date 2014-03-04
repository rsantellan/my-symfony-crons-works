<?php

/**
 * usuario form base class.
 *
 * @method usuario getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseusuarioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'nombre'              => new sfWidgetFormInputText(),
      'apellido'            => new sfWidgetFormInputText(),
      'fecha_nacimiento'    => new sfWidgetFormDateTime(),
      'anio_ingreso'        => new sfWidgetFormInputText(),
      'sociedad'            => new sfWidgetFormInputText(),
      'referencia_bancaria' => new sfWidgetFormInputText(),
      'emergencia_medica'   => new sfWidgetFormInputText(),
      'horario'             => new sfWidgetFormChoice(array('choices' => array('matutino' => 'matutino', 'vespertino' => 'vespertino', 'doble_horario' => 'doble_horario'))),
      'futuro_colegio'      => new sfWidgetFormInputText(),
      'descuento'           => new sfWidgetFormInputText(),
      'clase'               => new sfWidgetFormChoice(array('choices' => array('verde' => 'verde', 'amarillo' => 'amarillo', 'rojo' => 'rojo'))),
      'egresado'            => new sfWidgetFormInputCheckbox(),
      'billetera_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('billetera'), 'add_empty' => true)),
      'actividades_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'actividades')),
      'progenitores_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'progenitor')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'              => new sfValidatorString(array('max_length' => 64)),
      'apellido'            => new sfValidatorString(array('max_length' => 64)),
      'fecha_nacimiento'    => new sfValidatorDateTime(array('required' => false)),
      'anio_ingreso'        => new sfValidatorInteger(array('required' => false)),
      'sociedad'            => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'referencia_bancaria' => new sfValidatorString(array('max_length' => 64)),
      'emergencia_medica'   => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'horario'             => new sfValidatorChoice(array('choices' => array(0 => 'matutino', 1 => 'vespertino', 2 => 'doble_horario'), 'required' => false)),
      'futuro_colegio'      => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'descuento'           => new sfValidatorInteger(array('required' => false)),
      'clase'               => new sfValidatorChoice(array('choices' => array(0 => 'verde', 1 => 'amarillo', 2 => 'rojo'), 'required' => false)),
      'egresado'            => new sfValidatorBoolean(array('required' => false)),
      'billetera_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('billetera'), 'required' => false)),
      'actividades_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'actividades', 'required' => false)),
      'progenitores_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'progenitor', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'usuario';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['actividades_list']))
    {
      $this->setDefault('actividades_list', $this->object->actividades->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['progenitores_list']))
    {
      $this->setDefault('progenitores_list', $this->object->progenitores->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveactividadesList($con);
    $this->saveprogenitoresList($con);

    parent::doSave($con);
  }

  public function saveactividadesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['actividades_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->actividades->getPrimaryKeys();
    $values = $this->getValue('actividades_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('actividades', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('actividades', array_values($link));
    }
  }

  public function saveprogenitoresList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['progenitores_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->progenitores->getPrimaryKeys();
    $values = $this->getValue('progenitores_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('progenitores', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('progenitores', array_values($link));
    }
  }

}
