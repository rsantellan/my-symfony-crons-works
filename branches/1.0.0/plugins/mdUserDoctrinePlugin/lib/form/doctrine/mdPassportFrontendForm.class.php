<?php

/**
 * mdUserContent form.
 *
 * @package    demo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdPassportFrontendForm extends BasemdPassportForm {

    public function configure() {
        parent::configure ();
        unset(
                $this ['time_to_confirm'],
                $this ['account_active'],
                $this ['token'],
                $this ['last_login'],
                $this ['groups_list'],
                $this ['permissions_list'],
                $this ['applications_list'],
                $this ['created_at'],
                $this ['updated_at'],
                $this ['md_user_id']
        );
        $this->validatorSchema ['username'] = new sfValidatorString(array('max_length' => 128, 'required' => true));
        $this->widgetSchema ['password'] = new sfWidgetFormInputPassword ( );
        $this->validatorSchema ['password']->setOption('required', true);
        $this->widgetSchema ['password_confirmation'] = new sfWidgetFormInputPassword ( );
        $this->validatorSchema ['password_confirmation'] = clone $this->validatorSchema ['password'];

        $this->widgetSchema->moveField('password_confirmation', 'after', 'password');

        $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_confirmation', array(), array('invalid' => 'The two passwords must be the same.')));
    }

}
