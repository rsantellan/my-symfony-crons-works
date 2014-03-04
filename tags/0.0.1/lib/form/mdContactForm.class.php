<?php
class mdContactForm extends sfForm
{

    public function configure()
    {
			sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
        $this->setWidgets(array(
            'nombre'    => new sfWidgetFormInput(array('label' => __('Contacto_Nombre'))),
            'apellido'   => new sfWidgetFormInput(array('label' => __('Contacto_Apellido'))),
            'email'     => new sfWidgetFormInput(array('label' => __('Contacto_Email'))),
            'telefono'   => new sfWidgetFormInput(array('label' => __('Contacto_Telefono'))),
            'mensaje'		=> new sfWidgetFormTextarea(array('label' => __('Contacto_Mensaje'))),
        ));

        $error_message = array(
        'required'=> __('Contacto_Error Campo requerido'),
        'invalid' => __('Contacto_Error Formato incorrecto')
        );

        $this->setValidators(array(
            'nombre'    => new sfValidatorString(array('required' => true), $error_message),
            'apellido'   => new sfValidatorString(array('required' => true), $error_message),
            'email'     => new sfValidatorEmail( array('required' => true), $error_message),
            'telefono'   => new sfValidatorString(array('required' => false), $error_message),
            'mensaje'		=> new sfValidatorString(array('required' => true), $error_message)
        ));

        $this->widgetSchema->setNameFormat('contacto[%s]');

/*
				//cargo los i18n
				foreach ($this as $field){
					if( ($this->getCSRFFieldName()  == $field->getName())) continue; 
						mdI18nTranslatorHandler::addNewWordToCatalogue('frontend', 'Contacto' , str_replace('Contacto_', '', $field->renderLabelName()));
				}
				mdI18nTranslatorHandler::addNewWordToCatalogue('frontend', 'Contacto' , 'Error Campo requerido');
				mdI18nTranslatorHandler::addNewWordToCatalogue('frontend', 'Contacto' , 'Error Formato incorrecto');
				
*/

    }
}