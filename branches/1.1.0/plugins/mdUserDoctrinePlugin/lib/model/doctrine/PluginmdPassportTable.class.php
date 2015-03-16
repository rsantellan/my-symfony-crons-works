<?php

/**
 */
class PluginmdPassportTable extends Doctrine_Table {

    /**
     * Retrieve the mdPassport that confirms the user, password and application id
     * @param string $user
     * @param string $pass
     * @param int $appId
     * @return Doctrine_Collection
     * @author Rodrigo Santellan
     */
    public function retrieveMdPassportByUserPassAndApp($user, $pass, $appId) {
        $pass = md5($pass);
        $query = Doctrine_Query::create ()
                        ->select('mdP.*')
                        ->from('mdPassport mdP, mdPassportApplication mdPA')
                        ->where('mdP.username = ?', $user)
                        ->addWhere('mdP.password = ?', $pass)
                        ->addWhere('mdP.id = mdPA.md_passport_id')
                        ->addWhere('mdPA.md_application_id = ?', $appId);


        return $query->fetchOne();
    }

    /**
     * Retrieve the mdPassport that confirms the user and application id
     * @param string $user
     * @param int $appId
     * @return Doctrine_Collection
     * @author Rodrigo Santellan
     */
    public function retrieveMdPassportByUserName($user, $timeToLife = 86400) {
        $query = Doctrine_Query::create ()
                        ->select('mdP.*')
                        ->from('mdPassport mdP')
                        ->where('mdP.username = ?', $user);

        if (sfConfig::get('sf_driver_cache')) {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_retrieveMdPassportByUserName_' . $user);
        }

        return $query->fetchOne();
    }

    public function retrieveMdPassportByUserId($userId, $timeToLife = 86400) {
        $query = Doctrine_Query::create ()
                        ->select('mdP.*')
                        ->from('mdPassport mdP')
                        ->where('mdP.md_user_id = ?', $userId);


        if (sfConfig::get('sf_driver_cache')) {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_retrieveMdPassportByUserId_' . $userId);
        }

        return $query->fetchOne();
    }

    public function retrieveMdPassportByMdUserEmail($email) {
        $query = Doctrine_Query::create ()
                        ->select('mdP.*')
                        ->from('mdPassport mdP, mdUser mU')
                        ->where('mdP.md_user_id = mU.id')
                        ->addWhere('mU.email = ? ', $email);
        return $query->fetchOne ();
    }

    /*
      public function retrieveAllOtherMdPassportOfApplication($mdPassportId, $mdApplicationId){
      $query = Doctrine_Query::create ()
      ->select ('mdP.*')
      ->from ('mdPassport mdP, mdPassportApplication mdPA')
      ->where ('mdP.id = mdPA.md_passport_id')
      ->addWhere('mdP.id != ?', $mdPassportId)
      ->addWhere('mdPA.md_application_id = ?', $mdApplicationId);

      return $query->execute ();
      }

      public function retrieveMdPassportByMdUserEmailAndMdApplication($email , $mdApplication){
      $query = Doctrine_Query::create ()
      ->select ('mdP.*')
      ->from ('mdPassport mdP, mdPassportApplication mdPA, mdUser mU')
      ->where ('mdP.id = mdPA.md_passport_id')
      ->addWhere('mdPA.md_application_id = ?', $mdApplication->getId())
      ->addWhere('mdP.md_user_id = mU.id')
      ->addWhere('mU.email = ? ', $email);

      return $query->fetchOne ();
      }
     */

    public function removeCacheByKey($keyPart) {
        $manager = Doctrine_Manager::getInstance();
        $cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
        $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . $keyPart;
        @$cacheDriver->delete($key);
    }

    public function removeCacheByPrefix($keyPart) {
        $manager = Doctrine_Manager::getInstance();
        $cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
        $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . $keyPart;
        @$cacheDriver->deleteByPrefix($key);
    }

}
