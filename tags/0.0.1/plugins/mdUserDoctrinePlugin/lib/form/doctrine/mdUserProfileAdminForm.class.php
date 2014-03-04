<?php

/**
 * mdUserProfile form.
 *
 * @package    demo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdUserProfileAdminForm extends BasemdUserProfileForm {

    public function configure() {
        unset($this ['md_user_content_id']);

        if (sfContext::hasInstance ()) {
            $this->widgetSchema ['country_code'] = new sfWidgetFormI18nChoiceCountry(array('culture' => sfContext::getInstance ()->getUser()->getCulture()));
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
        if (sfConfig::get('sf_plugins_user_attributes', false)) {
            //embebo el form de los atributos de la clase
            $mdAttributesForms = $this->getObject()->retrieveAllAttributesForm();

            $myForm = new sfForm();

            foreach ($mdAttributesForms as $tmpForm) {
                $myForm->embedForm($tmpForm->getName(), $tmpForm);
            }

            $this->embedForm('mdAttributes', $myForm);
        }
    }

    public function save($con = null) {
        if (sfConfig::get('sf_plugins_user_attributes', false)) {
            $tainted = $this->getTaintedValues();

            if ($this->getObject()->getEmbedProfile()) {
                $attributesValues = $tainted ['mdAttributes'];
                unset($this ['mdAttributes'], $tainted ['mdAttributes']);
            }
        }

        $mdUserProfile = parent::save ();
        $mdUserProfile->getId();

        if (sfConfig::get('sf_plugins_user_attributes', false)) {
            if ($this->getObject()->getEmbedProfile()) {
                $mdAttributesForms = $this->getObject()->retrieveAllAttributesForm();

                foreach ($mdAttributesForms as $tmpForm) {
                    $form_values = $attributesValues[$tmpForm->getName()];
                    $form_values [$tmpForm->getCSRFFieldName()] = $tmpForm->getCSRFToken();
                    $tmpForm->bind($form_values);
                    if ($tmpForm->isValid()) {
                        //Al ser valido lo salvo
                        $mdUserProfile->saveAllAttributes($tmpForm);
                    }
                }
            }
        }

        return $mdUserProfile;
    }

}
