<?php

/**
 * static actions.
 *
 * @package    frontend
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mdUserManagementFrontendActions extends sfActions {

    public function executeEditUser(sfWebRequest $request) {
        $mdUserProfile = $this->getUser()->getProfile();
        $mdProfileId = $request->getParameter('mdProfileId', sfConfig::get('app_defaults_user_profile_id', 0));
        if ($mdProfileId != 0) {
            $mdUserProfile->addTmpArrayMdProfileId($mdProfileId);
            $mdUserProfile->setEmbedProfile(true);
        }

        $this->form = new mdUserProfileAdminForm($mdUserProfile);

        if ($request->getParameter('clean', false)) {
            $this->setLayout('clean');
        } else {
            if ($request->isXmlHttpRequest()) {
                $this->setLayout('clean');
            }
        }
    }

    public function executeGetEditPageAjax(sfWebRequest $request) {
        $body = $this->getPartial("mdUserManagementFrontend/edit_user");

        return $this->renderText(mdBasicFunction::basic_json_response(true, array("body" => $body)));
    }

    public function executeGetSmallInfoAjax(sfWebRequest $request) {
        $body = $this->getPartial("mdUserManagementFrontend/smallUserInformationData");

        return $this->renderText(mdBasicFunction::basic_json_response(true, array("body" => $body)));
    }

    public function executeProccesMyChangeEmailAjax(sfWebRequest $request) {
        $this->form = new emailForm();
        $this->exception = '';
        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid()) {
            $values = $request->getParameter($this->form->getName());
            if (strcmp($this->getUser()->getEmail(), $values['email']) != 0) {
                $mdUserAux = Doctrine::getTable("mdUser")->findOneBy("email",  $values['email']);
                if($mdUserAux)
                {
                    $this->exception = 1;
                    $body = $this->getPartial("mdUserManagementFrontend/changeEmail", array("form"=>$this->form, 'exception' => $this->exception));
                    return $this->renderText(mdBasicFunction::basic_json_response(false, array("body"=>$body)));
                }
                else
                {
                    if (!sfConfig::get('sf_plugins_user_not_send_mail', false)) {
                        $mdUser = $this->getUser()->getMdPassport()->retrieveMdUser();
                        $mdUser->setEmail($values['email']);
                        mdMailHandler::sendActivationMail($this->getUser()->getMdPassport());
                    }
                }

            }
            return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
        } else {
            $this->exception = 2;
            $body = $this->getPartial("mdUserManagementFrontend/changeEmail", array("form"=>$this->form, 'exception' => $this->exception));
            return $this->renderText(mdBasicFunction::basic_json_response(false, array("body"=>$body)));
        }
    }

    public function executeProccesChangePasswordAjax(sfWebRequest $request) {
        $this->form = new PasswordChangeForm();

        $this->exception = '';
        $this->form->bind($request->getParameter($this->form->getName()));
        if($this->form->isValid()){
            $mdPassport = $this->getUser()->getMdPassport();
            $values = $request->getParameter($this->form->getName());
            if($mdPassport->validatePassword($values['old_password']))
            {
                $mdPassport->changePassword($values['password']);
                return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
            }
            else
            {
              $this->exception = "Password anterior no confirmado.";
              $body = $this->getPartial('mdUserManagementFrontend/change_password_form', array('form' => $this->form, 'exception' => $this->exception));
              return $this->renderText(mdBasicFunction::basic_json_response(false, array("body"=>$body)));
              
            }
            
            
        }else{
          
            $this->exception = "Las contraseña ingresadas son distintas";
            $body = $this->getPartial('mdUserManagementFrontend/change_password_form', array('form' => $this->form, 'exception' => $this->exception));
            return $this->renderText(mdBasicFunction::basic_json_response(false, array("body"=>$body)));
        }
    }

/**
     * Revisada en lo basico
     * @author Rodrigo Santellan
     *
     **/
    public function executeProcessMdUserProfileAjax(sfWebRequest $request) {
        $salida = array();
        $mdUserProfileValues = $request->getPostParameter('md_user_profile');
        $mdUserProfile = Doctrine::getTable('mdUserProfile')->find($mdUserProfileValues ['id']);
        if (isset($mdUserProfileValues['mdAttributes'])) {
            $mdUserProfile->setEmbedProfile(true);
        }
        $form = new mdUserProfileAdminForm($mdUserProfile);

        $form->bind($this->request->getParameter($form->getName()), $this->request->getFiles($form->getName()));
        if ($form->isValid()) {
            $form->save();
            return $this->renderText(mdBasicFunction::basic_json_response(true, array("mduserid"=>$form->getObject()->getId())));
        } else {
            $body = $this->getPartial('mdUserManagementFrontend/md_user_profile_form', array('form' => $form));
            return $this->renderText(mdBasicFunction::basic_json_response(false, array("body"=>$body)));
        }
    }
    
    public function executeGetProfileFormAjax(sfWebRequest $request) {
        $mdUserProfile = new mdUserProfile();
        $mdProfileId = $request->getParameter('mdProfileId', sfConfig::get('app_defaults_user_profile_id', 0));
        if ($mdProfileId != 0) {
            $mdUserProfile->addTmpArrayMdProfileId($mdProfileId);
            $mdUserProfile->setEmbedProfile(true);
        }
        $form = new mdUserProfileForm($mdUserProfile);
        $salida = array();
        $body = $this->getPartial('mdUserManagementFrontend/newUser', array('form' => $form));
        $salida ['result'] = 1;
        $salida ['body'] = $body;
        return $this->renderText(json_encode($salida));
    }

    public function executeProcessNewMdUserProfileAjax(sfWebRequest $request) {

        $requiere_login = $request->getParameter('requiere_login', false);
        $postParamenters = $request->getPostParameter('md_user_profile');
        $mdUserProfile = new mdUserProfile ( );
        if (sfConfig::get('sf_plugins_user_attributes', false)) {
            $mdProfileId = null;
            $hasProfile = false;
            $mdAttributeParameters = array();
            if (isset($postParamenters ['mdAttributes'])) {
                foreach ($postParamenters ['mdAttributes'] as $mdAttributeParams) {
                    if (is_array($mdAttributeParams)) {
                        if (isset($mdAttributeParams['mdProfileId'])) {
                            $hasProfile = true;
                            $mdUserProfile->addTmpArrayMdProfileId($mdAttributeParams['mdProfileId']);
                            $mdAttributeParameters[$mdAttributeParams['mdProfileId']] = $mdAttributeParams;
                        }
                    }
                }
                if ($hasProfile) {
                    $mdUserProfile->setEmbedProfile(true);
                    $mdUserProfile->setTmpMdAttributesValues($mdAttributeParameters);
                } else {
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
                $mdPassport = $mdUserProfile->retrieveMdPassport();
                if (!sfConfig::get('sf_plugins_user_not_send_mail', false)) {
                    mdMailHandler::sendActivationMail($mdPassport);
                }
                $options = array();
                $options['md_user_id'] = $mdPassport->getMdUserId();
                if ($requiere_login) {
                    $this->logUser($mdPassport);
                }
                return $this->renderText(mdBasicFunction::basic_json_response(TRUE, $options));
            } catch (Exception $e) {
                sfContext::getInstance ()->getLogger()->info('<! Se capturo una excepcion !>');
                sfContext::getInstance ()->getLogger()->err($e->getMessage());
                $salida ['body'] = $this->getPartial('mdUserManagementFrontend/newUser', array('form' => $form,'errors'=> array($e->getMessage())));
                return $this->renderText(mdBasicFunction::basic_json_response(FALSE, $salida));
            }
        } else {
            sfContext::getInstance ()->getLogger()->info('<! No acepto los chequeos !>');
            $errors = $form->getFormattedErrors();
            foreach ($errors as $e) {
                sfContext::getInstance ()->getLogger()->err($e);
            }
            $salida ['body'] = $this->getPartial('mdUserManagementFrontend/newUser', array('form' => $form));
            return $this->renderText(mdBasicFunction::basic_json_response(FALSE, $salida));
        }
    }

    private function logUser($mdPassport) {
        $this->getUser()->signin($mdPassport, false);
        $this->getUser()->setAuthenticated(true);
        $this->getUser()->addCredential('user');
    }

    public function executeRetrieveUserEditForm(sfWebRequest $request) {
        $form = new mdUserProfileAdminForm($this->getUser()->getProfile());
        $options = array();
        $options['body'] = $this->getPartial('mdUserManagementFrontend/minEditUser', array('form' => $form));
        return $this->renderText(mdBasicFunction::basic_json_response(TRUE, $options));
    }

    public function executeRetrieveSmallInfo(sfWebRequest $request) {

        $options = array();
        $options['body'] = $this->getComponent('mdUserManagementFrontend', 'smallUserInformation'); //$this->getPartial('mdUserManagementFrontend/minEditUser', array('form'=>$form));
        return $this->renderText(mdBasicFunction::basic_json_response(TRUE, $options));
    }

    public function executeProcessEditUser(sfWebRequest $request) {
        $parameters = $request->getPostParameter('md_user_profile');
        $mdUserProfile = $this->getUser()->getProfile();
        $mdProfileId = $request->getParameter('mdProfileId', sfConfig::get('app_defaults_user_profile_id', 0));
        if ($mdProfileId != 0) {
            $mdUserProfile->addTmpArrayMdProfileId($mdProfileId);
            $mdUserProfile->setEmbedProfile(true);
        }

        $this->form = new mdUserProfileAdminForm($mdUserProfile);
        $this->form->bind($parameters);
        $salida = array();
        if ($this->form->isValid()) {
            $this->form->save();
            $salida['response'] = "OK";
            $options = array();
            $salida['options'] = $options;
        } else {
            $salida['response'] = "ERROR";
            $options = array();

            $salida['options'] = $options;
        }
        return $this->renderText(json_encode($salida));
    }

    public function executeSaveProfileAjax(sfWebRequest $request) {
        $parameters = $request->getPostParameters();
        $form_name = $parameters['form_name'];
        $salida = array();
        $mdUserProfile = Doctrine::getTable('mdUserProfile')->find($parameters['mdUserProfileId']);
        $form = $mdUserProfile->getAttributesFormOfMdProfileById($parameters[$form_name]['mdProfileId']);
        $form->bind($parameters[$form_name]);
        if ($form->isValid()) {
            $mdUserProfile->saveAllAttributes($form);
            $salida ['response'] = "OK";
            return $this->renderText(json_encode($salida));
        } else {
            $salida ['response'] = "ERROR";
            $options = array();
            $options['body'] = $this->getPartial('profile_form', array('form' => $form, 'mdProfileId' => $parameters[$form_name]['mdProfileId'], 'mdUserProfileId' => $parameters['mdUserProfileId']));
            $options['mdProfileId'] = $parameters[$form_name]['mdProfileId'];
            $salida['options'] = $options;
            return $this->renderText(json_encode($salida));
        }
    }

    public function executeRegisterMinimunUserAjax(sfWebRequest $request) {
        $values = $request->getPostParameters();


        $salida = array();

        $this->form = new mdPassportLoginUserForm();


        $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
        try {
            if ($this->form->isValid()) {
                $mdPassport = mdUserHandler::retrieveMdPassportWithMdUserEmail($values[$this->form->getName()]['email']);
                if ($mdPassport) {
                    $body = $this->getPartial('minimunUserRegisterForm', array('form' => $this->form));
                    $salida ['result'] = 1;
                    $salida ['code'] = 1;
                    $salida ['body'] = $body;
                    $salida ['maui'] = true;
                } else {
                    $mdPassport = $this->form->save();
                    $salida ['result'] = 0;
                    $salida ['code'] = 0;
                    $salida ['body'] = $mdPassport->getId();

                    $this->logUser($mdPassport);

                    if ($request->hasParameter('share')) {
                        $salida['share'] = $request->getParameter('share');

                        $mdUserShare = new mdUserShare();
                        $mdUserShare->setMdUserId($this->getUser()->getMdUserId());
                        $mdUserShare->setEmail($this->getUser()->getMdPassport()->getMdUser()->getEmail());
                        $mdUserShare->save();
                    } else {
                        $salida['share'] = 0;
                    }

                    mdMailHandler::sendActivationMail($mdPassport);
                }
            } else {
                $body = $this->getPartial('minimunUserRegisterForm', array('form' => $this->form));
                $salida ['result'] = 1;
                $salida ['code'] = 0;
                $salida ['body'] = $body;
            }
        } catch (Exception $e) {
            $errorTemplate = "Error";
            switch ($e->getCode()) {
                case 130:
                    $errorTemplate = $this->getPartial('errorExistingEmail');
                    break;
                case 131:
                    $errorTemplate = $this->getPartial('errorExistingUsername');
                    break;
                default:
                    break;
            }
            //print_r($e->getMessage());
            $body = $this->getPartial('minimunUserRegisterForm', array('form' => $this->form));
            $salida ['result'] = 1;
            $salida ['code'] = $e->getMessage();
            $salida ['body'] = $body;
            $salida ['error'] = $errorTemplate;
        }


        return $this->renderText(json_encode($salida));
    }


    public function executeRetrieveLastUploadImageAsAvatar(sfWebRequest $request) {
        $class = $request->getParameter("class");
        $id = $request->getParameter("id");
        $width = $request->getParameter("width", 86);
        $height = $request->getParameter("height", 75);
        $object = Doctrine::getTable($class)->find($id);
        if($object)
        {
            $instance = mdMediaManager::getInstance(mdMediaManager::IMAGES, $object)->load("default");
            if($instance->getCount() > 0)
            {
                $default_album = $instance->getAlbums("default");
                $last  = null;
                foreach($instance->getItems() as $item)
                {
                    $last = $item;
                    
                }
                $mdMediaContent = $last->retrieveMdMediaContent();
                $mdMediaAlbum = Doctrine::getTable('mdMediaAlbum')->find($default_album->id);
                $mdMediaAlbum->changeAvatar($mdMediaContent->getId());
            }
            $body = $this->getPartial("mdUserManagementFrontend/avatar_image", array("width" => $width, "height" => $height, mdWebOptions::CODE => mdWebCodes::RESIZECROP));
            return $this->renderText(mdBasicFunction::basic_json_response(true, array('body'=>$body)));
        }
        else
        {
            return $this->renderText(mdBasicFunction::basic_json_response(false, array()));
        }


        
    }
    /*     * ************
     *
     * REVISADO HASTA ACA.
     *
     * *********** */

    public function executeShowMinimunUserForm(sfWebRequest $request) {
        $this->form = new mdPassportLoginUserForm();
    }

    public function executeGetRegisterMinimunUserAjax(sfWebRequest $request) {
        $this->form = new mdPassportLoginUserForm();
        $salida = array();
        $body = $this->getPartial('minimunUserRegisterForm', array('form' => $this->form));
        $salida ['result'] = 1;
        $salida ['body'] = $body;
        return $this->renderText(json_encode($salida));
    }

    public function executeRegisterMinimunAjax(sfWebRequest $request) {
        $values = $request->getPostParameters();


        $salida = array();

        $this->form = new mdPassportLoginNoUserForm();


        $this->form->bind($this->request->getParameter($this->form->getName()), $this->request->getFiles($this->form->getName()));
        try {
            if ($this->form->isValid()) {
                $mdPassport = Doctrine::getTable('mdPassport')->retrieveMdPassportByUserAndApp($values[$this->form->getName()]['email'], $this->getUser()->getMdApplication()->getId());
                if ($mdPassport) {
                    $body = $this->getPartial('minimunRegisterForm', array('form' => $this->form));
                    $salida ['result'] = 1;
                    $salida ['body'] = $body;
                } else {
                    $mdPassport = $this->form->save();
                    $salida ['result'] = 0;
                    $salida ['body'] = $mdPassport->getId();
                    $mdPassportApplication = new mdPassportApplication();
                    $mdPassportApplication->setMdPassportId($mdPassport->getId());
                    $mdPassportApplication->setMdApplicationId($this->getUser()->getMdApplication()->getId());
                    $mdPassportApplication->save();
                    $this->logUser($mdPassport);
                    $this->sendActivationEmail($mdPassport);
                }
            } else {
                $body = $this->getPartial('minimunRegisterForm', array('form' => $this->form));
                $salida ['result'] = 1;
                $salida ['body'] = $body;
            }
        } catch (Exception $e) {
            $salida ['result'] = 1;
            $salida ['body'] = $this->getPartial('minimunRegisterForm', array('form' => $this->form));
            $salida ['error'] = __($e->getMessage());
        }


        return $this->renderText(json_encode($salida));
    }

    public function executeEditUserData(sfWebRequest $request) {
        if (!$this->getUser()->isAuthenticated()) {
            $this->redirect("default/index");
        }
        $this->emailAndUserForm = new emailAndUserForm($this->getUser()->getMdPassport());

        $this->passwordForm = new passwordForm($this->getUser()->getMdPassport());

        $mdUserProfile = $this->getUser()->getProfile();

        $this->mdUserProfile = new mdUserProfileSimpleForm($mdUserProfile);

        $this->profileForm = $mdUserProfile->getAttributesFormOfMdProfileById(11);
    }

    public function executeChangeUsernameAndEmail(sfWebRequest $request) {
        $this->emailAndUserForm = new emailAndUserForm($this->getUser()->getMdPassport());
        $this->emailAndUserForm->bind($this->request->getParameter($this->emailAndUserForm->getName()), $this->request->getFiles($this->emailAndUserForm->getName()));
        if ($this->emailAndUserForm->isValid()) {
            $this->emailAndUserForm->save();
            $this->getUser()->refreshMdPassport();
            $salida = array();
            $salida ['result'] = 1;
            $salida ['body'] = $this->getPartial('usernameAndMailForm', array('emailAndUserForm' => $this->emailAndUserForm));
            return $this->renderText(json_encode($salida));
        } else {
            $salida = array();
            $salida ['result'] = 0;
            $salida ['body'] = $this->getPartial('usernameAndMailForm', array('emailAndUserForm' => $this->emailAndUserForm));
            return $this->renderText(json_encode($salida));
        }
    }

    public function executeChangePassword(sfWebRequest $request) {
        $this->passwordForm = new passwordForm($this->getUser()->getMdPassport());
        $this->passwordForm->bind($this->request->getParameter($this->passwordForm->getName()), $this->request->getFiles($this->passwordForm->getName()));
        if ($this->passwordForm->isValid()) {
            $data = $this->request->getParameter($this->passwordForm->getName());
            $this->getUser()->getMdPassport()->changePassword($data['password']);
            $this->getUser()->refreshMdPassport();
            $salida = array();
            $salida ['result'] = 1;
            $salida ['body'] = $this->getPartial('changePasswordForm', array('passwordForm' => $this->passwordForm));
            return $this->renderText(json_encode($salida));
        } else {
            $salida = array();
            $salida ['result'] = 0;
            $salida ['body'] = $this->getPartial('changePasswordForm', array('passwordForm' => $this->passwordForm));
            return $this->renderText(json_encode($salida));
        }
    }

    public function executeSaveSimpleUserProfile(sfWebRequest $request) {
        $this->mdUserProfile = new mdUserProfileSimpleForm($this->getUser()->getProfile());
        $this->mdUserProfile->bind($this->request->getParameter($this->mdUserProfile->getName()), $this->request->getFiles($this->mdUserProfile->getName()));
        if ($this->mdUserProfile->isValid()) {
            $this->mdUserProfile->save();
            $this->getUser()->refreshMdPassport();
            $salida = array();
            $salida ['result'] = 1;
            $salida ['body'] = $this->getPartial('mdUserProfileForm', array('mdUserProfile' => $this->mdUserProfile));
            return $this->renderText(json_encode($salida));
        } else {
            $salida = array();
            $salida ['result'] = 0;
            $salida ['body'] = $this->getPartial('mdUserProfileForm', array('mdUserProfile' => $this->mdUserProfile));
            return $this->renderText(json_encode($salida));
        }
    }

    public function executeChangeProfile(sfWebRequest $request) {
        $mdUserProfile = $this->getUser()->getProfile();

        $this->profileForm = $mdUserProfile->getAttributesFormOfMdProfileById(11);
        $mdUserProfile->setTmpMdProfileId(11);
        $mdUserProfile->setEmbedProfile(true);
        $values = $this->request->getParameter($this->profileForm->getName());
        $mdUserProfile->setTmpMdAttributesValues($values);
        $this->profileForm->bind($this->request->getParameter($this->profileForm->getName()), $this->request->getFiles($this->profileForm->getName()));
        if ($this->profileForm->isValid()) {
            $mdUserProfile->saveAllAttributes($this->profileForm);

            $this->getUser()->refreshMdPassport();
            $salida = array();
            $salida ['result'] = 1;
            $salida ['body'] = $this->getPartial('mdProfileForm', array('profileForm' => $this->profileForm));
            return $this->renderText(json_encode($salida));
        } else {
            $salida = array();
            $salida ['result'] = 0;
            $salida ['body'] = $this->getPartial('mdProfileForm', array('profileForm' => $this->profileForm));
            return $this->renderText(json_encode($salida));
        }
    }

}
