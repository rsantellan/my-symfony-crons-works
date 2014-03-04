<?php

/**
 * usuario filter form.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usuarioFormFilter extends BaseusuarioFormFilter
{
  public function configure()
  {
    parent::configure();
    unset($this['egresado']);
    $this->setWidget('anio_ingreso', new sfWidgetFormFilterInput(array('label' => 'Año de ingreso', 'empty_label' => 'Vacio ?')));
    $this->setWidget('futuro_colegio', new sfWidgetFormFilterInput(array('empty_label' => 'Vacio ?')));
    $this->setWidget('egresado', new sfWidgetFormChoice(array('choices' => array('' => 'si o no', 1 => 'si', 0 => 'no'))));
    
    //'clase'               => new sfWidgetFormChoice(array('choices' => array('' => '', 'verde' => 'verde', 'amarillo' => 'amarillo', 'rojo' => 'rojo'))),
  }
}
