<?php

/**
 * PluginmdUser form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdUserForm extends BasemdUserForm
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
					$this ['culture'],
					$this['super_admin'] 
				);
  	
  	$this->validatorSchema['email'] = new sfValidatorEmail();
  }

  	public function isValid(){
		if (parent::isValid ()) {
            $multipleAplication = sfConfig::get('app_multiple_active', false);
            if(!$multipleAplication){
                $taintedValues = $this->getTaintedValues ();
                $mdUser = Doctrine::getTable('mdUser')->findOneby('email', $taintedValues['email']);
                if($mdUser){
                    throw new Exception('Email allready exists', 151);
                }
            }
            return true;
        }else{
            return false;
        }

    }
    	
}
