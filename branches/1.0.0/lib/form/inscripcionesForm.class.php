<?php
/**
* formulario para envio de inscripciones
*/
class inscripcionesForm extends sfForm
{
	/**
	 * configuracion del formulario
	 *
	 * @return void
	 * @author maui .-
	 **/
		public function configure()
    {
			sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
        $this->setWidgets(array(
            'nombre'    => new sfWidgetFormInput(array('label' => __('Inscripciones_Nombre')), array('tabindex' => '1')),
            'apellido'   => new sfWidgetFormInput(array('label' => __('Inscripciones_Apellido')), array('tabindex' => '2')),
            'ano'     => new sfWidgetFormInput(array('label' => __('Inscripciones_Año')), array('tabindex' => '3')),
            'horario'     => new sfWidgetFormInput(array('label' => __('Inscripciones_Horario')), array('tabindex' => '4')),
            'nacimiento'     => new sfWidgetFormInput(array('label' => __('Inscripciones_Fecha nacimiento')), array('tabindex' => '5')),
            'colegio'     => new sfWidgetFormInput(array('label' => __('Inscripciones_Futuro Colegio')), array('tabindex' => '6')),
            'direccion'     => new sfWidgetFormInput(array('label' => __('Inscripciones_Direccion')), array('tabindex' => '7')),
            'telefono'     => new sfWidgetFormInput(array('label' => __('Inscripciones_Telefono')), array('tabindex' => '8')),
            'mensaje'		=> new sfWidgetFormTextarea(array('label' => __('Inscripciones_Mensaje')), array('tabindex' => '9')),
        ));


        $error_message = array(
        'required'=> __('Inscripciones_Error Campo requerido'),
        'invalid' => __('Inscripciones_Error Formato incorrecto')
        );

        $this->setValidators(array(
            'nombre'    => new sfValidatorString(array('required' => true), $error_message),
            'apellido'   => new sfValidatorString(array('required' => true), $error_message),
            'ano'     => new sfValidatorString( array('required' => false), $error_message),
            'horario'     => new sfValidatorString( array('required' => false), $error_message),
            'nacimiento'     => new sfValidatorString( array('required' => false), $error_message),
            'colegio'     => new sfValidatorString( array('required' => false), $error_message),
            'direccion'     => new sfValidatorString( array('required' => false), $error_message),
            'telefono'     => new sfValidatorString( array('required' => true), $error_message),
            'mensaje'		=> new sfValidatorString(array('required' => true), $error_message)
        ));

        $this->widgetSchema->setNameFormat('inscripcion[%s]');


    }
}
