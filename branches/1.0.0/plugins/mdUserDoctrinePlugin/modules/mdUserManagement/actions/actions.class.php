<?php

/**
 * static actions.
 *
 * @package    frontend
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mdUserManagementActions extends sfActions {

    public function preExecute() {
        if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) ){
            if (!$this->getUser()->hasPermission('Admin')) {
                $this->getUser()->setFlash('noPermission', 'noPermission');
                $this->redirect($this->getRequest()->getReferer());
            }
            if (!$this->getUser()->hasPermission('Backend User Show List')) {
                $this->getUser()->setFlash('noPermission', 'noPermission');
                $this->redirect($this->getRequest()->getReferer());
            }
        }
    }

    private function getIndexQuery()
    {
        $query = Doctrine::getTable ( 'mdUser' )->createQuery('u');
        if( sfConfig::get( 'sf_plugins_user_reverse_backend_order', false ) )
        {
          $query->orderBy("u.id DESC");
        }
        return $query;
    }

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        
        //$this->pager = new mdArrayPager('mdUser', sfConfig::get('app_max_shown_users', 20));
        //$list = mdUser::retrieveMdUsers();
        $this->pager = new sfDoctrinePager ( 'mdUser', sfConfig::get('app_max_shown_users', 20) );

        $this->pager->setQuery ( $this->getIndexQuery() );
        //$this->pager->setResultArray($list);
        $this->pager->setPage($this->getRequestParameter('page',1));
        $this->pager->init();

        $this->formFilter = new mdUserFormFilter();
    }
    
/**
* Revisada en lo basico
* @author Rodrigo Santellan
* 
**/ 
public function executeAddNewUser(sfWebRequest $request) {
  $salida = "";
  $canCreate = true;
  if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) )
  {
    if (!$this->getUser()->hasPermission('Backend Create User'))
    {
      $canCreate = false;
    }
  }

  if($canCreate){
      if( sfConfig::get( 'sf_plugins_user_attributes', false ) )
      {
        $mdProfiles = Doctrine::getTable('mdProfile')->getMdProfilesByObjectClassName('mdUserProfile');
        $salida = $this->getPartial('newUserProfiles', array('mdProfiles' => $mdProfiles));
      }
      else
      {
        $randomPassword = mdBasicFunction::createRandomPassword();
        $form = new mdUserProfileForm();
        $salida = $this->getPartial('newUser', array('form' => $form, 'randomPassword' => $randomPassword));
      }
  }
  return $this->renderText(json_encode($salida));

}

		public function executeAddNewProfile(sfWebRequest $request) 
		{
			$salida = array();
      $mdUserId = $request->getParameter('mdUserId');
      $mdUserProfile = mdUserHandler::retrieveMdUserProfileWithMdUserId($mdUserId);
			$mdProfiles = mdProfileHandler::retrieveAllMdProfilesNotBelongingToObject($mdUserProfile->getId(), $mdUserProfile->getObjectClass());
			$salida = $this->getPartial('addUserProfiles', array('mdProfiles' => $mdProfiles,'mdUserId' => $mdUserId));

			return $this->renderText(json_encode($salida));
		}

		public function executeShowSmallUserProfileAjax(sfWebRequest $request) 
		{
            $salida = array();
            $salida ['response'] = "ERROR";
            if($request->getParameter('mdProfileId') == 0)  return $this->renderText(json_encode($salida));
            $mdUserProfile = Doctrine::getTable('mdUserProfile')->findByMdUserId($request->getParameter('mdUserId'));
            $form = $mdUserProfile->getAttributesFormOfMdProfileById($request->getParameter('mdProfileId'));
            $salida['body'] = $this->getPartial('newProfileUserForm', array('form' => $form, 'mdUserId' => $request->getParameter('mdUserId'), 'mdProfileId' => $request->getParameter('mdProfileId')));			
            $salida ['response'] = "OK";
            return $this->renderText(json_encode($salida));
		}
    /**
     * Revisada en lo basico
     * @author Rodrigo Santellan
     * 
     **/ 
    public function executeProcessNewMdUserProfileAjax(sfWebRequest $request) {
        if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) ){
            if (!$this->getUser()->hasPermission('Backend Create User')) {
                return $this->renderText(array('result' => 1, 'body' => ''));
            }
        }
        
        $postParamenters = $request->getPostParameter('md_user_profile');
        $mdUserProfile = new mdUserProfile ( );
        if( sfConfig::get( 'sf_plugins_user_attributes', false ) ){
            $mdProfileId = null;
            $hasProfile = false;
            $mdAttributeParameters = array();
            if (isset($postParamenters ['mdAttributes'])) {
                foreach($postParamenters ['mdAttributes'] as $mdAttributeParams)
                {
                    if(is_array($mdAttributeParams))
                    {
                        if(isset($mdAttributeParams['mdProfileId']))
                        {
                            $hasProfile = true;
                            $mdUserProfile->addTmpArrayMdProfileId($mdAttributeParams['mdProfileId']);
                            $mdAttributeParameters[$mdAttributeParams['mdProfileId']] = $mdAttributeParams;
                        }
                    }
                }
                if ($hasProfile)
                {
                    $mdUserProfile->setEmbedProfile(true);
                    $mdUserProfile->setTmpMdAttributesValues($mdAttributeParameters);
                }
                else
                {
                    $mdUserProfile->setEmbedProfile(false);
                }
            }
        }
        $form = new mdUserProfileForm($mdUserProfile);
        $form->bind($this->request->getParameter($form->getName()), $this->request->getFiles($form->getName()));
        $salida = array();
        if ($form->isValid()) {
            try {
                sfContext::getInstance ()->getLogger()->info('<! ACEPTA LOS CHEQUEOS !>');
                $mdUserProfile = $form->save();
                $randomPassword = mdBasicFunction::createRandomPassword();
                $mdPassport = $mdUserProfile->retrieveMdPassport();
                sfContext::getInstance ()->getLogger()->err('<<<!!!!!' . $mdPassport->getId());
                if( !sfConfig::get( 'sf_plugins_user_not_send_mail', false ) )
                {
                    mdMailHandler::sendActivationMail($mdPassport);
                }
                
                $body = $this->getUserDetail($mdUserProfile->retrieveMdUser());
                $salida ['result'] = 0;
                $salida ['body'] = $body;
                $salida['user_id'] = $mdUserProfile->retrieveMdUser()->getId();
                $salida['id'] = $mdUserProfile->getId();
                $salida['className'] = $mdUserProfile->getObjectClass();
            } catch (Exception $e) {
                sfContext::getInstance ()->getLogger()->info('<! Se capturo una excepcion !>');
                sfContext::getInstance ()->getLogger()->err($e->getMessage());
                $randomPassword = mdBasicFunction::createRandomPassword();
                $salida ['result'] = 1;
                $salida ['body'] = $this->getPartial('new_user', array('form' => $form, 'randomPassword' => $randomPassword, 'error' =>  $e->getMessage()));
            }
        } else {
            sfContext::getInstance ()->getLogger()->info('<! No acepto los chequeos !>');
            $errors = $form->getFormattedErrors();
            foreach($errors as $e)
            {
                sfContext::getInstance ()->getLogger()->err($e);
            }
            $randomPassword = mdBasicFunction::createRandomPassword();
            $body = $this->getPartial('new_user', array('form' => $form, 'randomPassword' => $randomPassword));
            $salida ['result'] = 1;
            $salida ['body'] = $body;
        }
        return $this->renderText(json_encode($salida));
    }

    /**
     * Gets the user small detail.
     * Revisada en lo basico
     * @author Rodrigo Santellan
     * @param sfRequest $request A request object
     */
    public function executeGetUserSmallDetailAjax(sfWebRequest $request) {
        $mdUser = Doctrine::getTable('mdUser')->retrieveMdUserById($request->getParameter('mdUserId'));
        $salida = array();
        $body = $this->getPartial('closedUser', array('mdUser' => $mdUser));
        $salida ['result'] = 0;
        $salida ['body'] = $body;
        $salida ['mdUserId'] = $request->getParameter('mdUserId');
        return $this->renderText(json_encode($salida));
    }

    /**
     * Gets the user detail.
     * Revisada en lo basico
     * @author Rodrigo Santellan
     * @param sfRequest $request A request object
     */
    public function executeGetUserDetailAjax(sfWebRequest $request) {
        $mdUser = Doctrine::getTable('mdUser')->retrieveMdUserById($request->getParameter('mdUserId'));

        $salida = array();
        $body = $this->getUserDetail($mdUser);
        $returnType = 0;
        if (count($mdUser->getMdPassport()) == 0) {
            $returnType = 1;
        }
        $salida ['result'] = $returnType;
        $salida ['body'] = $body;
        $salida['id'] = $mdUser->getId();
        $salida['className'] = 'mdUserProfile';
        return $this->renderText(json_encode($salida));
    }

    /**
     * Revisada en lo basico
     * @author Rodrigo Santellan
     * 
     **/ 
    private function getUserDetail($mdUser) {
        $body = "";
        $mdPassport = Doctrine::getTable('mdPassport')->retrieveMdPassportByUserId($mdUser->getId());
        $mdUserForm = new mdUserAdminForm($mdUser);
        if($mdPassport)
        {
            $mdPassportForm = new mdPassportAdminForm($mdPassport);
            $body = $this->getPartial('open_box', array('mdUserForm' => $mdUserForm, 'mdPassportForm'=> $mdPassportForm, 'mdUserProfile'=> new mdUserProfileAdminForm($mdUser->getMdUserProfile())));
        }
        else
        {
            $body = $this->getPartial('open_box_md_user', array('mdUserForm' => $mdUserForm));
        }
        return $body;

    }

    /**
     * Revisada en lo basico
     * @author Rodrigo Santellan
     * 
     **/ 
    public function executeProcessMdUserProfileAjax(sfWebRequest $request) {
        $salida = array();
        if (!$this->getUser()->hasPermission('Backend Create User')) {
            return $this->renderText(array('result' => 1, 'body' => ''));
        }
        $mdUserProfileValues = $request->getPostParameter('md_user_profile');
        $mdUserProfile = Doctrine::getTable('mdUserProfile')->find($mdUserProfileValues ['id']);
        if (isset($mdUserProfileValues['mdAttributes'])) {
            $mdUserProfile->setEmbedProfile(true);
        }
        $form = new mdUserProfileAdminForm($mdUserProfile);

        $form->bind($this->request->getParameter($form->getName()), $this->request->getFiles($form->getName()));
        if ($form->isValid()) {
            $form->save();
            $salida ['result'] = 0;
            $salida ['body'] = 'ok';
            $salida ['mduserid'] = $form->getObject()->getId();
        } else {
            $body = $form->getFormattedErrors();
            $salida ['result'] = 1;
            $salida ['body'] = $body; 
        }
        return $this->renderText(json_encode($salida));
    }

    /**
     * Revisada en lo basico
     * @author Rodrigo Santellan
     * 
     **/ 
    public function executeDeleteUserAjax(sfWebRequest $request)
    {
        $salida = array();
        //try{
            $md_user = Doctrine::getTable('mdUser')->find(array($request->getParameter('id')));
            $md_user->delete();

            $salida['response'] = 'OK';
            return $this->renderText(json_encode($salida));
        /*}catch(Exception $e){
            sfContext::getInstance()->getLogger()->err("Error, borrado de usuario: Archivo".$e->getFile(). ' linea : '. $e->getLine());
            
            $salida['response'] = 'ERROR';
            $salida['mensaje'] = $e->getMessage();
            return $this->renderText(json_encode($salida));
        }*/
    }

    public function executeProcessNewMdUserProfileAjaxToPassport(sfWebRequest $request) {

        $mdUserProfile = Doctrine::getTable('mdUserProfile')->findByMdUserId($request->getParameter('mdUserId'));
        
        $mdProfileId = $request->getParameter('mdProfileId');
        
        $form = $mdUserProfile->getAttributesFormOfMdProfileById($mdProfileId);
        
        $form->bind($request->getParameter($form->getName()));
        $salida = array();
        if($form->isValid()){
            $mdUserProfile->saveAllAttributes($form);
            $mdUser = mdUserHandler::retrieveMdUser($request->getParameter('mdUserId'));
            $idAndClass = $this->getMdUserIdAndClassName($mdUser);
            $salida['response'] = "OK";
            $options ['id'] = $idAndClass['id'];
            $options ['className'] = $idAndClass['class'];
            $options ['body'] = $this->getUserDetail($mdUser);
            $salida['options'] = $options;
          
        }else{
            $salida['response'] = "ERROR";
            $options = array();
            $options['errors'] = $form->getFormattedErrors();
            $options['body'] = $this->getPartial('newProfileUserForm', array('form' => $form, 'mdUserId' => $request->getParameter('mdUserId'), 'mdProfileId' => $request->getParameter('mdProfileId')));			
            $salida['options'] = $options;
        }
        return $this->renderText(json_encode($salida));
    }

    public function executeResetUserPasswordAjax(sfWebRequest $request) {
        if (!$this->getUser()->hasPermission('Backend Create User')) {
            return $this->renderText(array('result' => 1, 'body' => ''));
        }
        try {
            $salida = array();
            $mdPassport = Doctrine::getTable('mdPassport')->find($request->getPostParameter('mdPassportId'));
            if ($mdPassport->resetPassword()) {
                //Mandar el mail
                mdMailHandler::sendConfirmationMail($mdPassport);
                $salida ['result'] = 0;
                $salida ['body'] = 'Mando el mail';
            } else {
                $salida ['result'] = 1;
                $salida ['body'] = 'No ok';
            }
        } catch (Exception $e) {
            $salida ['result'] = 1;
            $salida ['body'] = 'No ok: ' . $e->getMessage();
        }
        return $this->renderText(json_encode($salida));
    }


    /**********************************************************
     *
     *
     *  TODAVIA NO SE REVISO!!!!!
     *  @TODO
     *
     **/


    public function executeProcessMdPassportAjax(sfWebRequest $request)
    {
        $salida = array();
        if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) ){
            if (!$this->getUser()->hasPermission('Backend Create User')) {
                return $this->renderText(array('result' => 1, 'body' => ''));
            }
        }
        $mdPassportValues = $request->getPostParameter('md_passport');
        $mdPassport = Doctrine::getTable('mdPassport')->find($mdPassportValues ['id']);

        $form = new mdPassportAdminForm($mdPassport);
        $form->bind($this->request->getParameter($form->getName()), $this->request->getFiles($form->getName()));
        if ($form->isValid()) {
            $form->save();
            $salida['response'] = "OK";
            $options = array();
            $options['mdUserId'] = $mdPassport->getMdUser()->getId();
            $salida['options'] = $options;
        } else {
            $body = $this->getPartial('md_passport_basic_form', array('mdPassportForm' => $form));
            $salida['response'] = "ERROR";
            $options = array();
            $options['body'] = $body;
            $salida['options'] = $options;
        }
        return $this->renderText(json_encode($salida));
    }

    public function executeProcessMdUserAjax(sfWebRequest $request)
    {
        $salida = array();
        if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) ){
            if (!$this->getUser()->hasPermission('Backend Create User')) {
                return $this->renderText(array('result' => 1, 'body' => ''));
            }
        }
        
        $aux = new mdUserAdminForm();
        $values = $request->getPostParameter($aux->getName());
        $mdUser = mdUserHandler::retrieveMdUser($values ['id']);
        
        $form = new mdUserAdminForm($mdUser);
        $form->bind($this->request->getParameter($form->getName()), $this->request->getFiles($form->getName()));
        if ($form->isValid()) {
            
            $form->save();
            try
            {
                if(strcmp($mdUser->getEmail(), $values['email']) != 0)
                {
                    if( !sfConfig::get( 'sf_plugins_user_not_send_mail', false ) )
                    {
                        $mdPassport = $mdUser->retrieveMdPassport();
                        if($mdPassport)
                        {
                            mdMailHandler::sendActivationMail($mdPassport);
                        }
                        
                    }    
                    
                }
            }catch(Exception $e)
            {
                
            }
            
            
            $salida['response'] = "OK";
            $options = array();
            $options['mdUserId'] = $mdUser->getId();
            $salida['options'] = $options;
        } else {
            $body = $this->getPartial('md_user_basic_form', array('mdUserForm' => $form));
            $salida['response'] = "ERROR";
            $options = array();
            $options['body'] = $body;
            $salida['options'] = $options;
        }
        return $this->renderText(json_encode($salida));
    }    

		public function executeSwitchMdUserSuperAdmin(sfWebRequest $request){
			$mdUserId = $request->getParameter('mdUserId');
			$mdUser = Doctrine::getTable('mdUser')->find($mdUserId);
			$mdUser->setSuperAdmin(($mdUser->getSuperAdmin()==1?0:1));
			$mdUser->save();
			return $this->renderText(json_encode(array()));
		}    

		public function executeSwitchMdPassportIsActive(sfWebRequest $request){
			$mdPassportId = $request->getParameter('mdPassportId');
			$mdPassport = Doctrine::getTable('mdPassport')->find($mdPassportId);
			$mdPassport->setAccountActive(($mdPassport->getAccountActive()==1?0:1));
      try
      {
        $mdPassport->save();
        return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
      }catch(Exception $e)
      {
        return $this->renderText(mdBasicFunction::basic_json_response(false, array()));
      }
		}

		public function executeSwitchMdPassportIsBlocked(sfWebRequest $request){
			$mdPassportId = $request->getParameter('mdPassportId');
			$mdPassport = Doctrine::getTable('mdPassport')->find($mdPassportId);
			$mdPassport->setAccountBlocked(($mdPassport->getAccountBlocked()==1?0:1));
      try
      {
        $mdPassport->save();
        return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
      }catch(Exception $e)
      {
        return $this->renderText(mdBasicFunction::basic_json_response(false, array()));
      }
		}
        
    public function executeGetPermissionOfApplicationAjax(sfWebRequest $request) {
        if (!$this->getUser()->hasPermission('Backend Add Permission')) {
            return $this->renderText(array('result' => 0, 'body' => ''));
        }

        $mdPassport = Doctrine::getTable('mdPassport')->find(array($request->getParameter('mdPassportId')));
        $permissionsIds = $mdPassport->getAllPermissionIds();
        $appListId = array();
        array_push($appListId, $request->getParameter('mdApplicationId'));
        $permissions = Doctrine::getTable('mdPermission')->getRelatedPermissions($permissionsIds, $this->getUser()->isSuperAdmin(), $appListId);

        $options = array();
        $i = 0;
        foreach ($permissions as $perm) {
            $options[$i]['id'] = $perm->getId();
            $options[$i]['name'] = $perm->getName();
            $i++;
        }
        $salida = array();
        $salida ['result'] = 1;
        $salida ['body'] = $options;
        return $this->renderText(json_encode($salida));
    }

    public function executeListProfiles(sfWebRequest $request) {
        if (!$this->getUser()->hasPermission('Backend Create User')) {
            return $this->renderText(array('result' => 0, 'body' => ''));
        }
        $mdUserId = $request->getPostParameter('mdUserId', NULL);
        $mdProfiles = Doctrine::getTable('mdProfile')->getMdProfilesOfApplication($request->getPostParameter('mdAppId'), 'mdUserProfile');

        $salida = array('result' => 1, 'body' => $this->getPartial('listUserProfiles', array('mdUserId' => $mdUserId, 'mdProfiles' => $mdProfiles)));
        return $this->renderText(json_encode($salida));
    }

    public function executeShowUserProfileAjax(sfWebRequest $request) {
        if (!$this->getUser()->hasPermission('Backend Create User')) {
            return $this->renderText(array('result' => "ERROR", 'body' => ''));
        }
        $salida = '';
        $mdUserId = $request->getPostParameter('mdUserId', '');
        $mdProfileId = $request->getPostParameter('mdProfileId');
        $mdPassportId = $request->getPostParameter('mdPassportId');
        
        $mdUserProfile = new mdUserProfile();
        if ($mdProfileId) {
            if ($mdProfileId == 0) {
                $mdUserProfile->setEmbedProfile(false);
            } else {
                $mdUserProfile->addTmpArrayMdProfileId($mdProfileId);
                $mdUserProfile->setEmbedProfile(true);
            }
        }
        $randomPassword = mdBasicFunction::createRandomPassword();
        $form = new mdUserProfileForm($mdUserProfile);
        $salida = $this->getPartial('new_user', array('form' => $form, 'randomPassword' => $randomPassword));
        return $this->renderText(json_encode(array('result' => "OK", 'body' => $salida)));
    }

    public function executeSaveProfileAjax(sfWebRequest $request) {
      $parameters = $request->getPostParameters();
      $form_name = $parameters['form_name'];
      $salida = array();
      $mdUserProfile = Doctrine::getTable('mdUserProfile')->find($parameters['mdUserProfileId']);
      $form = $mdUserProfile->getAttributesFormOfMdProfileById($parameters[$form_name]['mdProfileId']);
      $form->bind($parameters[$form_name]);
      if($form->isValid())
      {
        $mdUserProfile->saveAllAttributes($form);
        $salida ['response'] = "OK";
        return $this->renderText(json_encode($salida));
      }
      else
      {
        $salida ['response'] = "ERROR";
        $options = array();
        $options['body'] = $this->getPartial('profile_form', array('form'=>$form, 'mdProfileId' => $parameters[$form_name]['mdProfileId'], 'mdUserProfileId' => $parameters['mdUserProfileId'] ));
        $options['mdProfileId'] = $parameters[$form_name]['mdProfileId'];
        $salida['options'] = $options;
        return $this->renderText(json_encode($salida));          
      }
    }




    public function executeGetDiscountGroupBox(sfWebRequest $request) {
        if (!$this->getUser()->hasPermission('Backend Add Group')) {
            return $this->renderText(array('result' => 0, 'body' => ''));
        }

        $salida = array();
        $salida ['result'] = 1;
        $body = $this->getPartial('addDiscountGroupBox', array('userId' => $request->getParameter('id')));
        $salida ['body'] = $body;
        return $this->renderText(json_encode($salida));
    }

    public function executeSearchmdUserManagement(sfWebRequest $request) {
        
        $this->formFilter = new mdUserFormFilter();
        $this->formFilter->bind($request->getParameter($this->formFilter->getName()));
        $return = mdBasicFunction::emptyForm($request->getParameter($this->formFilter->getName()));
        if($return)
        {
          $this->search = $this->getIndexQuery();
        }
        else
        {
            $this->formFilter->bind($request->getParameter($this->formFilter->getName()));
            if ($this->formFilter->isValid()){
                $this->search = $this->formFilter->buildQuery($this->formFilter->getValues());
            } else {
                $this->search= $this->getIndexQuery();
            }
        }
        $this->pager = new sfDoctrinePager('mdUser', sfConfig::get('app_max_shown_users', 20));
        $this->pager->setQuery($this->search);
        $this->pager->setPage($request->getParameter('page', 1));
        $this->pager->init();

        $this->setTemplate('index');
        
    }

    public function executeUpdateUsersPicturesSlider(sfWebRequest $request) {
        $mdUser = Doctrine::getTable('mdUser')->find(array($request->getParameter('mdUserId')));
        $mdUserProfile = $mdUser->getMdUserProfile(1); //Ver como se maneja la aplicacion
        $form = new mdUserProfileForm($mdUserProfile);

        return $this->renderText(json_encode(array('user' => $this->getPartial('editUserProfileImages', array('form' => $form)))));
    }


    /**
     * Funciones Open, closed y add, controlan el contenido
     * que se ve en el accordion
     *
     */
    public function executeOpenBox(sfWebRequest $request){
        $mdUser = Doctrine::getTable('mdUser')->retrieveMdUserById($request->getParameter('id'));
        $idAndClass = $this->getMdUserIdAndClassName($mdUser);
        return $this->renderText(json_encode(array(
            'content' => $this->getUserDetail($mdUser),
            'id' => $idAndClass['id'],
            'className' => $idAndClass['class']
        )));
   }

    private function getMdUserIdAndClassName($mdUser)
    {
        $return = array();
        $mdUserProfile = $mdUser->getMdUserProfile();
        if($mdUserProfile)
        {
            $return['id'] = $mdUser->getMdUserProfile()->getId();
            $return['class'] = $mdUser->getMdUserProfile()->getObjectClass();
        }
        else
        {
            $return['id'] = $mdUser->getId();
            $return['class'] = $mdUser->getObjectClass();            
        }
        return $return;
    }

    public function executeClosedBox(sfWebRequest $request){
        $mdUser = Doctrine::getTable('mdUser')->retrieveMdUserById($request->getParameter('id'));

        return $this->renderText(json_encode(array(
            'content' => $this->getPartial('closed_box', array('object'=> $mdUser))
        )));
    }

    public function executeAddBox(sfWebRequest $request){
        return $this->renderText(json_encode(array(
            'content' => $this->getAddNewPartial(),
        )));
    }

    private function getAddNewPartial()
    {
      $salida = "";
      $canCreate = true;
      if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) )
      {
        if (!$this->getUser()->hasPermission('Backend Create User'))
        {
          $canCreate = false;
        }
      }

      if($canCreate){
          if( sfConfig::get( 'sf_plugins_user_attributes', false ) )
          {
            $mdProfiles = Doctrine::getTable('mdProfile')->getMdProfilesByObjectClassName('mdUserProfile');
            $salida = $this->getPartial('newUserProfiles', array('mdProfiles' => $mdProfiles));
          }
          else
          {
            $randomPassword = mdBasicFunction::createRandomPassword();
            $form = new mdUserProfileForm();
            $salida = $this->getPartial('new_user', array('form' => $form, 'randomPassword' => $randomPassword));
          }
      }
      return $salida;
    }
    
    public function executeRetrieveMdPassportForm(sfWebRequest $request)
    {
        $mdUserId = $request->getParameter('mdUserId');
        $mdUserProfileWithPassportAdminForm = new mdUserProfileWithPassportAdminForm();
        $salida ['response'] = "OK";
        $options = array();
        $options['body'] = $this->getPartial('md_user_passport_form', array('form'=>$mdUserProfileWithPassportAdminForm, 'mdUserId' => $mdUserId));
        $options['id'] = $mdUserId;
        $salida['options'] = $options;
        return $this->renderText(json_encode($salida));          
    }
    
    public function executeProcessMdUserWithPassportAjax(sfWebRequest $request)
    {
        $salida = array();
        $mdUserProfile = new mdUserProfile();
        $parameters = $request->getPostParameters();
        $mdUserProfile->setMdUserIdTmp ( $parameters['mdUserId'] );
        $form = new mdUserProfileWithPassportAdminForm($mdUserProfile);
        $form->bind($this->request->getParameter($form->getName()), $this->request->getFiles($form->getName()));
        if ($form->isValid()) 
        {
            $form->save();
            $mdUser = mdUserHandler::retrieveMdUser($parameters['mdUserId']);
            $idAndClass = $this->getMdUserIdAndClassName($mdUser);
            $salida ['response'] = "OK";
            $options ['id'] = $idAndClass['id'];
            $options ['className'] = $idAndClass['class'];
            $options ['body'] = $this->getUserDetail($mdUser);
            $salida['options'] = $options;
        }
        else
        {
            $options['body'] = $this->getPartial('md_user_passport_form', array('form'=>$form, 'mdUserId' => $parameters['mdUserId']));
            $options['id'] = $parameters['mdUserId'];
            $salida['options'] = $options;
            $salida ['response'] = "ERROR";
        }
        return $this->renderText(json_encode($salida));  
    }
}
