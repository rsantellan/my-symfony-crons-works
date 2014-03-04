<?php

/**
 * progenitor filter form.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class progenitorFormFilter extends BaseprogenitorFormFilter
{
  public function configure()
  {
    unset($this['md_user_id'], $this['clave'], $this['direccion'], $this['telefono'], $this['celular'], $this['hijos_list']);
    $this->setWidget('nombre', new sfWidgetFormFilterInput(array('empty_label' => 'Vacio ?')));
    $this->setWidget('mail', new sfWidgetFormFilterInput(array('empty_label' => 'Vacio ?')));    
  }
}
