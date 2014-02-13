<?php

/**
 * cobro form.
 *
 * @package    jardin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cobroForm extends BasecobroForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at']);
    $this->widgetSchema['cuenta_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['fecha'] = new sfWidgetFormInputDatepicker(array('value' => time()));
  }
}
