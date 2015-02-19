<?php
class exportarUsuariosForm extends sfForm
{

    public function configure()
    {
        $clases = array('' => 'Todos', 'verde' => 'verde', 'amarillo' => 'amarillo', 'rojo' => 'rojo');
        $horario = array('' => 'Todos', 'matutino' => 'matutino', 'vespertino' => 'vespertino', 'doble_horario' => 'doble horario');
        $this->widgetSchema['clase'] = new sfWidgetFormChoice(array('choices' => $clases));
        $this->widgetSchema['horario'] = new sfWidgetFormChoice(array('choices' => $horario));
        $camposUsuario = array(
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'anio_ingreso' => 'Año de ingreso',
            'sociedad' => 'Sociedad',
            'referencia_bancaria' => 'Referencia',
            'emergencia_medica' => 'Emergencia Medica',
            'horario' => 'Horario',
            'futuro_colegio' => 'Futuro Colegio',
            'clase' => 'clase',
        );
        
        $camposPadres = array(
            'nombre' => 'nombre',
            'direccion' => 'Dirección',
            'telefono' => 'Teléfono',
            'celular' => 'Celular',
            'mail' => 'Correo Electronico',
        );
        
        $this->widgetSchema['alumnos'] = new sfWidgetFormChoice(array(
                  'multiple' => 'true',
                  'expanded' => true,
                  'choices' => $camposUsuario
                ));
        $this->widgetSchema['padres'] = new sfWidgetFormChoice(array(
                  'multiple' => 'true',
                  'expanded' => true,
                  'choices' => $camposPadres
                ));
                
        $this->widgetSchema['exportar'] = new sfWidgetFormChoice(array(
              'expanded' => true,
              'choices'  => array('1' => 'Si', '0' => 'No'),
            ));
        $this->widgetSchema['exportar']->setDefault('1');
        
        $this->validatorSchema['alumnos'] = new sfValidatorString(array('required' => false));
        //$this->validatorSchema['alumnos'] = new sfValidatorChoice(array('choices' => $camposUsuario, 'required' => false));            
        $this->validatorSchema['padres'] = new sfValidatorString(array('required' => false));
        //$this->validatorSchema['padres'] = new sfValidatorChoice(array('choices' => $camposPadres, 'required' => false));            
        $this->validatorSchema['exportar'] = new sfValidatorString(array('required' => false));
        $this->validatorSchema['clase'] = new sfValidatorString(array('required' => false));
        $this->validatorSchema['horario'] = new sfValidatorString(array('required' => false));
        $this->widgetSchema->setNameFormat('exportarAlumnos[%s]');
    }
    
}
