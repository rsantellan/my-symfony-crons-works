<?php

/**
 * PluginmdNewsletterContentSended form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdNewsletterContentSendedForm extends BasemdNewsletterContentSendedForm
{
  public function setup()
  {
    parent::setup();
    unset ( 
        $this ['created_at'], 
        $this ['updated_at'],
        $this ['body'],
        $this ['send_counter'],
        $this ['sended'],
        $this ['subject'],
        $this ['for_all']
      );
    $this->widgetSchema['md_newsletter_content_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['sending_date'] = new sfWidgetFormInputDatepicker(array('default' => date('Y-m-d H:i:s'), 'useTimeWidget' => true));
    $this->validatorSchema['sending_date'] = new sfExtraValidatorDatepickerTime();        
  }  
}
