<?php

/**
 * PluginmdUserProfile form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdUserProfileForm extends BasemdUserProfileForm
{
	
	public function setup() {
		parent::setup ();
		
		if (sfContext::hasInstance ()) {
			$this->widgetSchema ['country_code'] = new sfWidgetFormI18nChoiceCountry ( array ('culture' => sfContext::getInstance ()->getUser ()->getCulture () ) );
      if( sfConfig::get( 'sf_plugins_user_manage_country_and_city_widget', false ) )
      {
        $this->widgetSchema ['country_code']->setAttribute("onchange", "changeCountry(this);");
      }
      
		} else {
			$this->widgetSchema ['country_code'] = new sfWidgetFormI18nChoiceCountry ( );
      if( sfConfig::get( 'sf_plugins_user_manage_country_and_city_widget', false ) )
      {
        $this->widgetSchema ['country_code']->setAttribute("onchange", "changeCountry(this);");
      }      
		}
    if( sfConfig::get( 'sf_plugins_user_manage_country_and_city_widget', false ) )
    {
      $this->widgetSchema ['city'] = new sfWidgetFormChoice(array(
                            'choices'  => array(),
                            'multiple' => false,
                            'expanded' => false
                          ));        
    }    
		$mdPassportForm = new mdPassportForm ( );
		if(!is_null($this->getObject()->retrieveLoadedMdPassport())){
            $mdPassportForm = new mdPassportForm ( $this->getObject()->retrieveLoadedMdPassport());
        }
		
		$this->embedForm ( 'mdPassport', $mdPassportForm );
		if( sfConfig::get( 'sf_plugins_user_attributes', false ) ){
			//embebo el form de los atributos de la clase
            $mdAttributesForms = $this->getObject ()->retrieveAllAttributesForm ();

            $myForm = new sfForm();

            foreach($mdAttributesForms as $tmpForm)
            {
                $myForm->embedForm ( $tmpForm->getName (), $tmpForm );
            }

            $this->embedForm('mdAttributes', $myForm);		
		}

	}


    
	/**
	 * Save poco prolijo, se dejan los comentarios para futuro debug
	 * (non-PHPdoc)
	 * @see addon/sfFormObject#save($con)
	 * @return mdUserProfile
	 * @author Rodrigo Santellan
	 */
	public function save($con = null) {
		$tainted = $this->getTaintedValues ();

		// Obtengo el form del mdPassport
		$mdPassportForm = $this->getEmbeddedForm ( 'mdPassport' );
		// Obtengo solo los valores del mdPassport
        $mdPassportForm_values = $tainted ['mdPassport'];

		// Obtengo el form del mdUser
		$mdUserForm = $mdPassportForm->getEmbeddedForm ( 'mdUser' );
		// Obtengo solo los valores del mdUser
        $mdUserForm_values = $this->values ['mdPassport'] ['mdUser'];

		//agrego al los valores del mdUserForm su control de CSRF
		$mdUserForm_values [$mdUserForm->getCSRFFieldName ()] = $mdUserForm->getCSRFToken ();
		$mdUserForm->bind ( $mdUserForm_values );
		
		if ($mdUserForm->isValid ()) {
            
			//salvo el mdUser
			$mdUserForm->save ( $con );
			$mdUser = $mdUserForm->getObject ();

			//quito los datos del mdUser del formulario
			unset ( $mdPassportForm ['mdUser'], $tainted ['mdPassport'] ['mdUser'] );
			//proceso mdPassport

			$mdPassportForm->getObject ()->setMdUser ( $mdUser );
			
			//Bindeo de vuelta
			$mdPassportForm_values = $tainted ['mdPassport'];
			$mdPassportForm_values [$mdPassportForm->getCSRFFieldName ()] = $mdPassportForm->getCSRFToken ();
			$mdPassportForm->bind ( $mdPassportForm_values );
            
            try {
                if ($mdPassportForm->isValid ()) 
                {

                    $mdPassport = $mdPassportForm->save ( $con );
                    unset ( $mdPassportForm ['mdPassport'], $tainted ['mdPassport'] );

                    if( sfConfig::get( 'sf_plugins_user_attributes', false ) )
                    {
                        if($this->getObject ()->getEmbedProfile())
                        {
                            $attributesValues = $tainted ['mdAttributes'];
                            unset ( $this ['mdAttributes'], $tainted ['mdAttributes'] );
                        }
                    }
                    $mdUserProfile = new mdUserProfile ( );
                    $mdUserProfile->setMdUserIdTmp ( $mdUser->getId () );
                    $mdUserProfile->setName($tainted['name']);
                    $mdUserProfile->setLastName($tainted['last_name']);
                    $mdUserProfile->setCity($tainted['city']);
                    $mdUserProfile->setCountryCode($tainted['country_code']);
                    $mdUserProfile->save ( $con );

                    if( sfConfig::get( 'sf_plugins_user_attributes', false ) )
                    {

                        if($this->getObject ()->getEmbedProfile())
                        {
                            $mdAttributesForms = $this->getObject ()->retrieveAllAttributesForm ();

                            foreach($mdAttributesForms as $tmpForm)
                            {
                                $form_values = $attributesValues[$tmpForm->getName ()];
                                $form_values [$tmpForm->getCSRFFieldName ()] = $tmpForm->getCSRFToken ();
                                $tmpForm->bind ( $form_values );
                                if ($tmpForm->isValid ())
                                {
                                    //Al ser valido lo salvo
                                    $mdUserProfile->saveAllAttributes ( $tmpForm );
                                }
                            }
                        }
                    }
                    return $mdUserProfile;
                } 
                else
                {
                    $mdUser->delete ( $con );
                    throw new Exception ( 'Error on saving user profile', 123 );
                }
            } catch ( Exception $e ) {
                $mdUser->delete ( $con );
                throw $e;
            }
		
		}
		throw new Exception ( 'Error on saving user profile totally', 124 );
	}
		
}
