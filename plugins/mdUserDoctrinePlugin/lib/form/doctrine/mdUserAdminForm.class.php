<?php

/**
 * PluginmdUser form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdUserAdminForm extends BasemdUserForm
{
	
  public function setup()
  {
	parent::setup();
  	  unset ( 
					$this ['token'], 
					$this ['account_active'], 
					$this ['deleted_at'], 
					$this ['created_at'], 
					$this ['updated_at'],
					$this['super_admin'] 
				);
  	
  	$this->validatorSchema['email'] = new sfValidatorEmail();
  }

  	public function isValid(){
		if (parent::isValid ()) {
            $taintedValues = $this->getTaintedValues ();
            return mdUserHandler::checkEmailOfMdUser($this->getObject()->getEmail(), $taintedValues['email']);
        }else{
            return false;
        }

    }
    	
}
