<?php

/**
 * progenitor form base class.
 *
 * @method progenitor getObject() Returns the current form's model object
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseprogenitorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'nombre'     => new sfWidgetFormInputText(),
      'direccion'  => new sfWidgetFormInputText(),
      'telefono'   => new sfWidgetFormInputText(),
      'celular'    => new sfWidgetFormInputText(),
      'mail'       => new sfWidgetFormInputText(),
      'clave'      => new sfWidgetFormInputText(),
      'md_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdUser'), 'add_empty' => true)),
      'hijos_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'usuario')),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'     => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'direccion'  => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'telefono'   => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'celular'    => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'mail'       => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'clave'      => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'md_user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdUser'), 'required' => false)),
      'hijos_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'usuario', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'progenitor', 'column' => array('mail')))
    );

    $this->widgetSchema->setNameFormat('progenitor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'progenitor';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['hijos_list']))
    {
      $this->setDefault('hijos_list', $this->object->hijos->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savehijosList($con);

    parent::doSave($con);
  }

  public function savehijosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['hijos_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->hijos->getPrimaryKeys();
    $values = $this->getValue('hijos_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('hijos', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('hijos', array_values($link));
    }
  }

}
