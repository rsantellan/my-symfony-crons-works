<?php

/**
 * pagos form.
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pagosForm extends BasepagosForm
{
  public function configure()
  {
    parent::configure();
    //unset($this ['fecha']);
    $this->widgetSchema['fecha']  = new sfWidgetFormDateTime(array('date' => array('can_be_empty' => false, 'format' => '%day%/%month%/%year%'), 'format' => '%date%'));
    $this->validatorSchema['fecha'] = new sfValidatorDateTime();
    
    $this->widgetSchema['price']  = new sfWidgetFormInputText(array('label' => 'Precio'));
    $this->validatorSchema['price'] = new sfValidatorInteger();
  }

  public function doSave($con = null) 
  {
    $data = $this->getTaintedValues();
    $usuario = Doctrine::getTable('usuario')->find($data['usuario_id']);
    $value = $usuario->calcularDescuento();
    $this->getObject()->setDescuento($value);
    $data['descuento'] = $value;
    $this->bind($data);
    
    return parent::doSave($con);
  }
}
