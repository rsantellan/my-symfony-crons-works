<?php

/**
 * mdUserContent form.
 *
 * @package    demo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdPassportAdminForm extends BasemdPassportForm
{
    public function configure() {
        parent::configure ();
        unset (
            $this ['time_to_confirm'],
            $this ['account_active'],
            $this ['token'],
            $this ['last_login'],
            $this ['groups_list'],
            $this ['permissions_list'],
            $this ['applications_list'],
            $this ['created_at'],
            $this ['updated_at'],
            $this ['password'],
            $this ['md_user_id'],
            $this ['account_blocked']
            );

        $this->validatorSchema ['username'] = new sfValidatorString(array('max_length' => 128));
    }
}
