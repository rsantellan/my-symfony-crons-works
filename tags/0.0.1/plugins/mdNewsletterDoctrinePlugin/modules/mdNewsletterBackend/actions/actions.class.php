<?php

/**
 * newsletterBackend actions.
 *
 * @package    mdNewsletterBackend
 * @subpackage default
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdNewsletterBackendActions extends sfActions
{
  
    public function preExecute() {
        if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) ){
            if (!$this->getUser()->hasPermission('Admin')) {
                $this->getUser()->setFlash('noPermission', 'noPermission');
                $this->redirect($this->getRequest()->getReferer());
            }
            if (!$this->getUser()->hasPermission('Newsletter management')) {
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
    public function executeExportUsers(sfWebRequest $request)
    {
        $this->results = mdNewsletterHandler::retrieveUsers();
        $this->exportExcel($this->results);
        //$this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdNewsletterBackend', 'clean.php').'/clean');
    }

    public function executeExportUsersOfSended(sfWebRequest $request)
    {
        $id = $request->getParameter("id");
        $this->forward404Unless($id);
        
        $mdNewsletterContentSended = Doctrine::getTable("mdNewsletterContentSended")->find($id);//mdNewsletterHandler::retrieveAllMdNewsletterContentSendedOfId($id);
        $this->forward404Unless($mdNewsletterContentSended);
        $this->results = array();
        foreach($mdNewsletterContentSended->getMdNewsletterSend() as $send)
        {
          array_push($this->results, $send->getMdNewsLetterUser()->getMdUser());
        }
        $this->exportExcel($this->results);
        //$this->results = mdNewsletterHandler::retrieveUsers();
        //$this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdNewsletterBackend', 'clean.php').'/clean');      
        $this->setTemplate("exportUsers");
    }
    
    private function exportExcel($userList)
    {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
                ->setCreator("Mastodonte")
                ->setLastModifiedBy("Mastodonte")
                ->setTitle("Office 2007 XLSX Document")
                ->setSubject("Office 2007 XLSX Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");      
                
                
        $objPHPExcel->setActiveSheetIndex(0);
        $letter = (string)(mdBasicFunction::retrieveLeters(0)."1");
        $objPHPExcel->getActiveSheet()
                ->setCellValue($letter, "Email");
        $index = 2;
        foreach($userList as $user)
        {
            
            $letter = (string)(mdBasicFunction::retrieveLeters(0).$index);
            $objPHPExcel->getActiveSheet()
                    ->setCellValue($letter, $user->getEmail());
            $index++;
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="newsletter.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');        
    }
    
    public function executeIndex(sfWebRequest $request)
    {
        
        
        //$aux = Doctrine::getTable('mdNewsletterContent')->find(1);
      
        //mdMailHandler::sendSwiftMail("rsantellan@gmail.com", "rsantellan@gmail.com", $aux->getSubject(), $aux->getBody());
        
        $this->pager = new sfDoctrinePager ( 'mdNewsletterContent', sfConfig::get('app_max_shown_users', 20) );

        $this->pager->setQuery (mdNewsletterHandler::retrieveAllMdNewsletterContents());
        //$this->pager->setResultArray($list);
        $this->pager->setPage($this->getRequestParameter('page',1));
        $this->pager->init();

        $this->formFilter = array();
    }


    public function executeShowContent(sfWebRequest $request)
    {
      $this->mdNewsletterContent = Doctrine::getTable('mdNewsletterContent')->find(array($request->getParameter('id')));
      $this->forward404Unless($this->mdNewsletterContent);
      $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdNewsletterBackend', 'clean.php') . '/clean');
    }
    
    public function executeShowContentSended(sfWebRequest $request)
    {
      $this->mdNewsletterContent = Doctrine::getTable('mdNewsletterContentSended')->find(array($request->getParameter('id')));
      $this->forward404Unless($this->mdNewsletterContent);
      $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdNewsletterBackend', 'clean.php') . '/clean');
    }
    
    public function executeRemoveContentSended(sfWebRequest $request)
    {
      $this->mdNewsletterContent = Doctrine::getTable('mdNewsletterContentSended')->find(array($request->getParameter('id')));
      $this->forward404Unless($this->mdNewsletterContent);
      $this->mdNewsletterContent->delete();
      return $this->renderText(mdBasicFunction::basic_json_response(true, array() ));
    }        
    /*
    public function executeNewNewsLetterUser(sfWebRequest $request)
    {
        $this->form = new mdNewsletterForm();
        $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('newsletterBackend', 'clean.php') . '/clean');
    }
    */
    
    public function executeSaveNewMdNewsletterUser(sfWebRequest $request)
    {
        $this->form = new mdNewsletterForm();
        $ok = false;
        $quantity = 0;
        $groups = array();
        if( sfConfig::get( 'sf_plugins_newsletter_group_enable', false ) )
        {
          $groups = Doctrine::getTable("mdNewsLetterGroup")->findAll();
        }
        
        if ($request->isMethod('post')) 
        {
            $this->form->bind($request->getParameter($this->form->getName()));
            if($this->form->isValid())
            {
                $mdNewsLetterUser = mdNewsletterHandler::registerUser($this->form->getValue('mail'));
                if( sfConfig::get( 'sf_plugins_newsletter_group_enable', false ) )
                {
                  $groupId = $request->getParameter('newsletter_group', 0);
                  if($groupId != 0)
                  {
                    $mdNewsLetterGroupUser = Doctrine::getTable("mdNewsLetterGroupUser")->retrieveByGroupAndUserId($groupId, $mdNewsLetterUser->getId());
                    if(!$mdNewsLetterGroupUser)
                    {
                      $mdNewsLetterGroupUser = new mdNewsLetterGroupUser();
                      $mdNewsLetterGroupUser->setMdNewsletterGroupId($groupId);
                      $mdNewsLetterGroupUser->setMdNewsletterUserId($mdNewsLetterUser->getId());
                      $mdNewsLetterGroupUser->save();
                    }
                  }
                }                
                $ok = true;
                $quantity = mdNewsletterHandler::retrieveNumberOfUserInNewsLetter();
            }
        }
        return $this->renderText(mdBasicFunction::basic_json_response($ok, array("quantity"=> $quantity, "body"=>$this->getPartial("addUser", array("form"=>$this->form, 'groups' => $groups)))));
    }

    public function executeRemoveMdNewsletterUser(sfWebRequest $request)
    {
        $this->form = new mdNewsletterForm();
        $ok = false;
        $exists = false;
        $quantity = 0;
        if ($request->isMethod('post')) 
        {
            $parameters = $request->getParameter($this->form->getName());
            $this->form->bind($parameters);
            if($this->form->isValid())
            {
                $mdNewsLetterUser = mdNewsletterHandler::retrieveNewsLetterUserByEmail($parameters["mail"]);
                if($mdNewsLetterUser)
                {
                  $exists = true;
                  $mdNewsLetterUser->delete();
                }
                $ok = true;
                $quantity = mdNewsletterHandler::retrieveNumberOfUserInNewsLetter();
            }
        }
        return $this->renderText(mdBasicFunction::basic_json_response($ok, array("exists" => $exists, "quantity"=> $quantity, "body"=>$this->getPartial("removeUser", array("form"=>$this->form)))));
    }

    public function executeSaveMdNewsLetterContentSended(sfWebRequest $request)
    {
      $this->form = new mdNewsletterContentSendedForm();
      $parameters = $request->getParameter($this->form->getName());
      
      $this->form->bind($parameters);
      $ok = false;
      $table_row = "";
      if($this->form->isValid())
      {      
        $ok = true;
        $postParameters = $request->getPostParameters();
        $mdNewsletterContentSended = $this->form->save();
        $mdNewsletterContentSended->setSubject($mdNewsletterContentSended->getMdNewsletterContent()->getSubject());
        $mdNewsletterContentSended->setBody($mdNewsletterContentSended->getMdNewsletterContent()->getBody());
        $mdNewsletterContentSended->save();
        switch ($postParameters["send"])
        {
          case 0:
            //Aca es para todos
            $mdNewsletterContentSended->setForStatus(mdNewsletterContentSended::FORALL);
            $mdNewsletterContentSended->save();
            mdNewsletterHandler::sendEmailToAllUsers($mdNewsletterContentSended->getId());
            break;
          case 1:
            //Aca es para algunos
            $mdNewsletterContentSended->setForStatus(mdNewsletterContentSended::FORUSERS);
            $mdNewsletterContentSended->save();
            $aux = $postParameters["send_users"];
            if($aux == "")
            {
              $emails = array();
            }
            else
            {
                $emails = explode(",", $aux);
            }
            mdNewsletterHandler::sendEmailToSomeUsers($mdNewsletterContentSended->getId(), $emails);          
            break;
          case 2:
            //Para los groupos
            $mdNewsletterContentSended->setForStatus(mdNewsletterContentSended::FORGROUPS);
            $mdNewsletterContentSended->save();
            $aux = $postParameters["send_groups"];
            if($aux == "")
            {
              $emails = array();
            }
            else
            {
                $groupsIds = explode(",", $aux);
            }
            mdNewsletterHandler::sendEmailToGroups($mdNewsletterContentSended->getId(), $groupsIds);
            break;
        }
        if($postParameters["send"] == 0)
        {
          
        }
        else
        {

        }
        
        $table_row = $this->getPartial("newsletter_table_line", array("contentSended"=>$mdNewsletterContentSended));
      }
      $body = $this->getPartial("addDates", array("form" => $this->form));
      return $this->renderText(mdBasicFunction::basic_json_response($ok, array("body"=> $body, "table_row" =>$table_row)));
    }

/*
    public function executeAddBox(sfWebRequest $request){
        $form = new mdNewsletterContentForm();
        $salida = $this->getPartial('add_box', array('form' => $form));
        return $this->renderText(json_encode( array('content' => $salida)));
    }
*/    
    /**
     * Formulario expandido para Editar Productos
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeOpenBox(sfWebRequest $request){
        $mdNewsletterContent = Doctrine::getTable('mdNewsletterContent')->find(array($request->getParameter('id')));
        $salida = array();
        $salida['content'] = $this->getPartial ( 'open_box', array ('form'=> new mdNewsletterContentForm($mdNewsletterContent) ) );
        $salida['id'] = $mdNewsletterContent->getId();
        $salida['className'] = "mdNewsletterContent";

        return $this->renderText(json_encode($salida));
    }
    
    public function executeClosedBox(sfWebRequest $request){
        $mdNewsletterContent = Doctrine::getTable('mdNewsletterContent')->find(array($request->getParameter('id')));
        return $this->renderText(json_encode(array('content' => $this->getPartial('closed_box', array ('object' => $mdNewsletterContent )))));
    }
    
    public function executeRetrieveUsersBox(sfWebRequest $request)
    {
      $users = mdNewsletterHandler::retriveAll();
      $body = $this->getPartial('usersList', array("users" => $users));
      return $this->renderText(mdBasicFunction::basic_json_response(true, array('body' => $body)));
    }
    
    public function executeRetrieveGroupsBox(sfWebRequest $request)
    {
      $groups = Doctrine::getTable("mdNewsLetterGroup")->findAll();
      $body = $this->getPartial('groupsList', array("groups" => $groups));
      return $this->renderText(mdBasicFunction::basic_json_response(true, array('body' => $body)));
    }    
    
    public function executeDeleteContent(sfWebRequest $request)
    {
      $id = $request->getParameter("id");
      $this->forward404Unless($id);      
      $mdNewsletterContent = Doctrine::getTable('mdNewsletterContent')->find(array($request->getParameter('id')));
      $this->forward404Unless($mdNewsletterContent);
      $mdNewsletterContent->delete();
      return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
    }    
    
    public function executeImportar(sfWebRequest $request)
    {
      $this->form = new mdImportNewsletterForm();
      $this->error = 0;
      if($request->isMethod('post')){
          $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
          
          if ($this->form->isValid()){
              $file = $this->form->getValue("archivo");
              $extension = $file->getOriginalExtension();
              if($extension == ".xls")
              {
                $realPath = sfConfig::get('sf_cache_dir')."/mdNewsletterImport/";
                MdFileHandler::checkPathFormat($realPath);
                $new_file = $realPath . $file->getOriginalName ();
                $hasCopy = copy($file->getTempName(), $new_file);                
                chmod($new_file, 0777);
                mdNewsletterHandler::importUsers($new_file, $extension);
                $this->getUser()->setFlash('importNewsletter','Complete');
                if($hasCopy)
                {
                  unlink($new_file);
                }
              }
              else
              {
                $this->error = 1;
              }
              //$subject = sfConfig::get('app_title_contact');
              //$body = $this->getPartial('mail', array('form' => $this->form));
              //$this->getUser()->setFlash('mdContactSend','Send');
      				//mdMailHandler::sendMdContactMail($body, $subject, array('email' => $this->form->getValue('mail'),'name' => $this->form->getValue('nombre')));
          }

      }
      $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdNewsletterBackend', 'clean.php').'/clean');      
    }
}
