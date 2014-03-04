<?php

/**
 * mdNewsletterContent form.
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdNewsletterContentForm extends PluginmdNewsletterContentForm
{
  public function configure()
  {
    parent::configure();

    $this->widgetSchema['subject'] = new sfWidgetFormInputText();
    
    $this->widgetSchema['body'] = new sfWidgetFormTextareaTinyMCE(array('height' => '400'), array('rows' => 15));
    $this->validatorSchema['body'] = new sfValidatorString(array('required' => false));
  }
  
  public function doSave($con = null) 
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers("Partial");
    $data = $this->getTaintedValues();
    $data['body'] = get_partial("mdNewsletterBackend/mailing", array('body' => $data['body'], 'subject' => $data['subject']));
    $this->bind($data);
    
    return parent::doSave($con);
  }
}
