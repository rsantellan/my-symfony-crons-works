<?php

/**
 * mdUser form.
 *
 * @package    mdBasicPlugin
 * @subpackage form
 * @author     Your name here
 * @version    0.2
 * @author Rodrigo Santellan
 */
class mdPassportLoginForm extends sfForm {
	public function configure() {
		$this->setWidgets ( 
						array (
								'username' => new sfWidgetFormInput ( ), 
								'password' => new sfWidgetFormInputPassword ( ),
								'remember' => new sfWidgetFormInputHidden ( ) 
							) 
						);
		
		$this->widgetSchema->setNameFormat ( 'login[%s]' );
		
		$this->setValidators ( 
						array (
								'username' => new sfValidatorString ( 
									array (
										'required' => true
										) 
									), 
								'password' => new sfValidatorPass (
									array (
										'required' => true
										)
									),
								 'remember' => new sfValidatorBoolean(
									)
								) 
							);
	}

}
