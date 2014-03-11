<?php

/**
 * mdUserProfile form.
 *
 * @package    demo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdUserProfileWithPassportAdminForm extends BasemdUserProfileForm {
	public function configure() {
		unset ( $this ['md_user_content_id'] );
		
		if (sfContext::hasInstance ()) {
			$this->widgetSchema ['country_code'] = new sfWidgetFormI18nChoiceCountry ( array ('culture' => sfContext::getInstance ()->getUser ()->getCulture () ) );
		} else {
			$this->widgetSchema ['country_code'] = new sfWidgetFormI18nChoiceCountry ( );
		}
		$mdPassportAdminForm = new mdPassportAdminForm();
        $this->embedForm ( 'mdPassport', $mdPassportAdminForm );
        $this->validatorSchema->setOption('allow_extra_fields', true);
	}
	
	public function save($con = null) {
        $tainted = $this->getTaintedValues ();
        
        $mdUserId = $this->getObject()->getMdUserIdTmp ();
        $mdPassport = new mdPassport();
        $mdPassport->setMdUserId($mdUserId);
		$mdPassportAdminForm = new mdPassportAdminForm($mdPassport);
        
        $mdPassportForm_values = $tainted ['mdPassport'];
        $mdPassportForm_values [$mdPassportAdminForm->getCSRFFieldName ()] = $mdPassportAdminForm->getCSRFToken ();
        $mdPassportAdminForm->bind ( $mdPassportForm_values );

        if ($mdPassportAdminForm->isValid ())
        {
            $mdPassport = $mdPassportAdminForm->save ( $con );
            try
            {
                $mdUserProfile = new mdUserProfile ( );
                $mdUserProfile->setMdUserIdTmp ( $mdUserId );
                $mdUserProfile->setName($tainted['name']);
                $mdUserProfile->setLastName($tainted['last_name']);
                $mdUserProfile->setCity($tainted['city']);
                $mdUserProfile->setCountryCode($tainted['country_code']);
                $mdUserProfile->save ( $con );
            }
            catch(Exception $e)
            {
                $mdPassport->delete($con);
            }  
        } 
  
        
		return $mdUserProfile;
	}
}
