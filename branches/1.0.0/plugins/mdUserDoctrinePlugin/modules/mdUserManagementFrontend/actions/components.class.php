<?php

class mdUserManagementFrontendComponents extends sfComponents {

    public function executeBasicRegisterForm() {
        $mdProfileId = sfConfig::get('app_user_default_profile', 0);
        $mdUserProfile = new mdUserProfile();
        if ($mdProfileId) {
            if ($mdProfileId == 0) {
                $mdUserProfile->setEmbedProfile(false);
            } else {
                $mdUserProfile->addTmpArrayMdProfileId($mdProfileId);
                $mdUserProfile->setEmbedProfile(true);
            }
        }
        $this->form = new mdUserProfileForm($mdUserProfile);
    }

    public function executeSmallUserInformation() {

    }

    public function executeMinimunRegisterForm() {
        $this->form = new mdPassportLoginNoUserForm();
    }

    public function executeMinimunUserRegisterForm() {
        $this->form = new mdPassportLoginUserForm();
    }

    public function executeChangeEmail(sfWebRequest $request) {
        $this->form = new emailForm(array("email"=>$this->getUser()->getEmail()));
        $this->exception = '';
    }

    public function executeChangePassword(sfWebRequest $request) {
        $this->form = new PasswordChangeForm();
    }

    public function executeChangeUserProfile(sfWebRequest $request) {
        $this->form = new mdUserProfileAdminForm($this->getUser()->getProfile());
    }

    public function executeChangeUserSimpleAvatar(sfWebRequest $request) {
        
    }
}
