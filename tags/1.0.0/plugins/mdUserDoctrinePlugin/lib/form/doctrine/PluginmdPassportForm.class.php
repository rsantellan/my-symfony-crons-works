<?php

/**
 * PluginmdPassport form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdPassportForm extends BasemdPassportForm
{
	
	public function setup() {
		parent::setup ();
		
		unset(
			$this['md_user_id'],
			$this['account_active'],
			$this['token'],
			$this['last_login'],
			$this['time_to_confirm'],
			$this['created_at'],
			$this['updated_at'],
			$this ['groups_list'], 
			$this ['permissions_list'],
			$this ['applications_list']
			
			);
		$this->widgetSchema ['password'] = new sfWidgetFormInputPassword ( );
		$this->validatorSchema ['password']->setOption ( 'required', true );	
		$this->widgetSchema ['password_confirmation'] = new sfWidgetFormInputPassword ( );
		$this->validatorSchema ['password_confirmation'] = clone $this->validatorSchema ['password'];
		
		$this->widgetSchema->moveField ( 'password_confirmation', 'after', 'password' );
		
		$this->mergePostValidator ( new sfValidatorSchemaCompare ( 'password', sfValidatorSchemaCompare::EQUAL, 'password_confirmation', array (), array ('invalid' => 'The two passwords must be the same.' ) ) );
			
		
		
		if (! $this->isNew ()) {
			
			$mdUser = $this->getObject ()->getMdUser ();
		} else {
			
			$mdUser = new mdUser ( );
		}
		
		$mdUserForm = new mdUserForm ( $mdUser );
		$this->embedForm ( 'mdUser', $mdUserForm );
	}
	
	public function isValid(){
		if (parent::isValid ()) {
			if (! $this->isNew ()) {
				return true;
			}
			$taintedValues = $this->getTaintedValues ();

			$mdPassportList = Doctrine::getTable('mdPassport')->retrieveMdPassportByUserName($taintedValues ['username']);
			
			if($mdPassportList){
				throw new Exception('El username ya existe', 100);
			}
			return true;
		}
    return false;
	}
		
}
