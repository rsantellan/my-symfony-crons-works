<?php

/**
 * default actions.
 *
 * @package    demo
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class configurationsActions extends sfActions
{

    public function preExecute() {
        //Si el usuario tiene permisos
        if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) ){
            if (!$this->getUser()->hasPermission('Admin')) {
                $this->getUser()->setFlash('noPermission', 'noPermission');
                $this->redirect($this->getRequest()->getReferer());
            }
            if (!$this->getUser()->hasPermission('Backend Configurations')) {
                $this->getUser()->setFlash('noPermission', 'noPermission');
                $this->redirect($this->getRequest()->getReferer());
            }            
        }
    }
    
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->xmlMailForm = new mdMailXMLForm();
    if( sfConfig::get( 'sf_plugins_mdAuthFile_xml_edit', false ) )
    {
        $this->mdAuthXMLHandler = new mdAuthXMLHandler();
    }

    if( sfConfig::get( 'sf_plugins_mdBackendGroupsFile_xml_edit', false ) )
    {
        $this->mdBackendGroupsXMLHandler = new mdBackendGroupsXMLHandler();
    }

    if( sfConfig::get( 'sf_plugins_mdBackendSalesFile_xml_edit', false ) )
    {
        $this->xmlSaleForm = new mdSaleXMLForm();
        $this->xmlSaleHandler = new mdSaleXMLHandler();
    }
  }
  
  public function executeProcessmdMailXMLFormAjax(sfWebRequest $request)
  {
    $salida = array();
    $this->xmlMailForm = new mdMailXMLForm();
    $this->xmlMailForm->bind($request->getParameter($this->xmlMailForm->getName()));
    if($this->xmlMailForm->isValid())
    {
      $this->xmlMailForm->save();
      $this->xmlMailForm = new mdMailXMLForm();
      $salida['result'] = "OK";
      $options = array();
      $options['body'] = $this->getPartial('md_mail_configuration_form', array('xmlMailForm'=> $this->xmlMailForm));
      $salida['options'] = $options;
    }
    else
    {
      $salida['result'] = "ERROR";
      $options = array();
      $options['erroreprocessmdMailXMLFormAjaxs'] = $this->xmlMailForm->getFormattedErrors();
      $options['body'] = $this->getPartial('md_mail_configuration_form', array('xmlMailForm'=> $this->xmlMailForm));
      
      $salida['options'] = $options;
    }
    return $this->renderText(json_encode($salida));
  }
  
  public function executeProcessmdAuthXMLFormAjax(sfWebRequest $request)
  {
    $salida = array();
    if( sfConfig::get( 'sf_plugins_mdAuthFile_xml_edit', false ) )
    {
      $this->mdAuthXMLHandler = new mdAuthXMLHandler();
      $parameters = $request->getParameter("md_auth_manager");
      $this->form = new mdAuthXMLForm(array('object'=>$this->mdAuthXMLHandler->retrieveUser($parameters['user_old'])));
      $this->form->bind($parameters);
      if($this->form->isValid())
      {
        $salida['result'] = "OK";
        $mdUserFile = $this->form->save();
        $this->form = new mdAuthXMLForm(array('object'=>$mdUserFile));
        $options = array();
        $options['body'] = $this->getPartial('md_auth_configuration_form', array('form'=> $this->form));
        $salida['options'] = $options;
      }
      else
      {
        $salida['result'] = "ERROR";
        $options = array();
        $options['body'] = $this->getPartial('md_auth_configuration_form', array('form'=> $this->form));
        $options['erroreprocessmdAuthXMLFormAjaxs'] = $this->form->getFormattedErrors();
        $salida['options'] = $options;
      }      
    }    
    return $this->renderText(json_encode($salida)); 
  }

  public function executeProcessmdSaleXMLFormAjax(sfWebRequest $request)
  {
    $salida = array();
    $xmlSaleForm = new mdSaleXMLForm();
    
    $xmlSaleForm->bind($request->getParameter($xmlSaleForm->getName()));
    if($xmlSaleForm->isValid())
    {
      $xmlSaleForm->save();
      $xmlSaleForm = new mdSaleXMLForm();
      $salida['result'] = "OK";
      $options = array();
      $options['body'] = $this->getPartial('md_sale_configuration_form', array('form'=> $xmlSaleForm));
      $xmlSaleHandler = new mdSaleXMLHandler();
      $data = $xmlSaleHandler->getReplyOn();
      $val = (array)$data;
      $options['reply_to'] =  $val[0];
      $data = $xmlSaleHandler->getInformBuyer();
      $val = (array)$data;
      $options['inform_buyer'] =  $val[0];
      return $this->renderText(mdBasicFunction::basic_json_response(true, $options));
    }
    else
    {
      $salida['result'] = "ERROR";
      $options = array();
      $options['erroreprocessmdMailXMLFormAjaxs'] = $xmlSaleForm->getFormattedErrors();
      $options['body'] = $this->getPartial('md_sale_configuration_form', array('form'=> $xmlSaleForm));
      $xmlSaleHandler = new mdSaleXMLHandler();
      $options['reply_to'] = $xmlSaleHandler->getReplyOn();
      $options['inform_buyer'] = $xmlSaleHandler->getInformBuyer();
      return $this->renderText(mdBasicFunction::basic_json_response(false, $options));
    }
  }

}
