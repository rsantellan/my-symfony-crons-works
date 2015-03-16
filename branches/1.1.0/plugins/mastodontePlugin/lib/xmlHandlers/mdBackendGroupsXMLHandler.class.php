<?php

class mdBackendGroupsXMLHandler {

    private $xml = null;
    private $backendGroupList = null;

    public function __construct() {
        $this->load();
    }

    private function load() {
        try {
            if(!file_exists ( $this->getXMLPlaceAndName() ))
            {
                throw new Exception("No xml file in the path", 160);
            }
            $this->xml = @simplexml_load_file($this->getXMLPlaceAndName());
            foreach ($this->xml->groups as $group) {
                $mdXmlGroup = new mdXmlGroup();
                $mdXmlGroup->setId((int) $group->group['id']);
                $mdXmlGroup->setName((string) $group->group->name);
                $mdXmlGroup->setRequiered((bool) $group->group->requiered);
                $this->backendGroupList[(int) $group->group['id']] = $mdXmlGroup;
            }
        } catch (Exception $e) {
            sfContext::getInstance()->getLogger()->err($e->getMessage());
            throw new Exception("No xml file in the path", 160);
        }
    }

    private function getXMLPlaceAndName() {
        $config_dir = sfConfig::get('sf_app_config_dir');
        return $config_dir . DIRECTORY_SEPARATOR . 'mdGroupRequieredToLogin.xml';
    }

    public function retrieveBackendGroupList() {
        return $this->backendGroupList;
    }

    public function retrieveFormList() {
        $list = array();
        foreach ($this->backendGroupList as $group) {
            $form = new mdAuthXMLForm(array('object' => $user));
            array_push($list, $form);
        }
        return $list;
    }

    public function save() {
        if (!is_null($this->xml)) {
            file_put_contents($this->getXMLPlaceAndName(), $this->xml->asXML());
        }
    }

    public function retrieveUser($username) {
        return $this->user_list[$username];
    }

    public function saveMdUserFile($username, $mdUserFile) {
        foreach ($this->xml->user as $users) {
            if ((string) $users->user == $username) {
                $users->name = $mdUserFile->getName();
                $users->user = $mdUserFile->getUsername();
                $users->password = $mdUserFile->getPassword();
                $users->email = $mdUserFile->getEmail();
            }
        }

        $this->save();
    }

}
