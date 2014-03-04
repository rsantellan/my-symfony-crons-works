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
    $dataConfig = '
      plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist, spellchecker",
      theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|",
      theme_advanced_buttons2 : "bullist,numlist,|,link,unlink,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,undo,redo,cut,copy,paste,pastetext,pasteword,|",
      theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,image, cleanup",
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left",
      theme_advanced_statusbar_location : "bottom",
      theme_advanced_resizing : true,';
    $this->widgetSchema['body'] = new sfWidgetFormTextareaTinyMCE(array('height' => '400', 'config' => $dataConfig), array('rows' => 15));
    $this->validatorSchema['body'] = new sfValidatorString(array('required' => false));
  }
  
  public function doSave($con = null) 
  {
    $data = $this->getTaintedValues();
    if($this->getObject()->isNew())
    {
      sfContext::getInstance()->getConfiguration()->loadHelpers("Partial");
      //$data = $this->getTaintedValues();
      //$data['body'] = get_partial("mdNewsletterBackend/mailing", array('body' => $data['body'], 'subject' => $data['subject']));
      //$this->bind($data);
    }
    else
    {
      $data['body'] = $data['body']." ";
    }
    $this->bind($data);
    return parent::doSave($con);
  }
}
