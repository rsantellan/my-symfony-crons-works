<?php

/**
 * usuario form.
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usuarioForm extends BaseusuarioForm
{
  private $dates = array();
  
  private $sociedades = array(
    ''            => '',    
    'Británico' => 'Británico',
    'Blue Cross'=> 'Blue Cross',
    'Summum'    => 'Summum',
    'OTRO'      => 'Otro'
  );

  private $emergencias = array(
    ''            => '',
    'Seem' => 'Seem',
    'Suat' => 'Suat',
    'UCM'  => 'UCM',
    'OTRO' => 'Otro'
  );

  private $colegios = array(
    ''            => '',
    'British'     => 'British',
    'Christian'   => 'Christian',
    'St. Patricks'=> 'St. Patricks',
    'Woodlands'   => 'Woodlands',
    'Otro'        => 'Otro'    
  );

  public function setup()
  {
    parent::setup();

    $this->dates[''] = '';
    for($i = 2005; $i <= (date('Y') + 5); $i++){
      $this->dates[$i] = $i;
    }
  }
  
  public function configure()
  {
    parent::configure();
    unset($this['billetera_id'], $this['progenitores_list']);
    
    $this->widgetSchema['fecha_nacimiento']  = new sfWidgetFormDateTime(array('date' => array('can_be_empty' => true, 'years' => $this->dates, 'format' => '%day%/%month%/%year%'), 'format' => '%date%', 'label' => 'Fecha de nacimiento'));
    $this->widgetSchema['anio_ingreso']  = new sfWidgetFormChoice(array('choices' => $this->dates,'label' => 'Año de ingreso'));

    $this->widgetSchema['sociedad']  = new sfWidgetFormChoice(array('choices' => $this->sociedades), array('label' => 'Sociedad'));    
    $this->widgetSchema['emergencia_medica']  = new sfWidgetFormChoice(array('choices' => $this->emergencias, 'label' => 'Emergencia'));
    $this->widgetSchema['futuro_colegio']  = new sfWidgetFormChoice(array('choices' => $this->colegios, 'label' => 'Futuro colegio'));

    $this->widgetSchema['actividades_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'expanded' => true, 'model' => 'actividades', 'label' => 'Actividades'));
    $this->widgetSchema['clase'] = new sfWidgetFormChoice(array('choices' => array('' => '', 'verde' => 'verde', 'amarillo' => 'amarillo', 'rojo' => 'rojo')));
    $this->widgetSchema['horario'] = new sfWidgetFormChoice(array('choices' => array('' => '', 'matutino' => 'matutino', 'vespertino' => 'vespertino', 'doble_horario' => 'doble horario')));
    
    $this->validatorSchema['referencia_bancaria'] = new sfValidatorString(
            array(
                'required' => true, 
                'min_length' => 2, 
                'max_length' => 64
            ), 
            array(
                'max_length' => '"%value%" es muy largo (Debe de tener como meximo: %max_length% caracteres).', 
                'min_length' => '"%value%" es muy corto (Debe de tener al minimo: %min_length% caracteres).'
             ));
    $this->validatorSchema['horario'] = new sfValidatorChoice(array('choices' => array(0 => '', 1 => 'matutino', 2 => 'vespertino', 3 => 'doble_horario'), 'required' => false));            
    $this->validatorSchema['clase'] = new sfValidatorChoice(array('choices' => array(0 => '', 1 => 'verde', 2 => 'amarillo', 3 => 'rojo'), 'required' => false));    
    $this->validatorSchema['sociedad'] = new sfValidatorString(array('required' => false));
    $this->validatorSchema['emergencia_medica'] = new sfValidatorString(array('required' => false));
    $this->validatorSchema['futuro_colegio'] = new sfValidatorString(array('required' => false));

    
    $this->validatorSchema['fecha_nacimiento'] = new sfValidatorDateTime(array('required' => false));
    $this->validatorSchema['anio_ingreso'] = new sfValidatorChoice(array('choices' => $this->dates, 'required' => false));
    $this->validatorSchema['actividades_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'actividades', 'required' => false));
  }
}
