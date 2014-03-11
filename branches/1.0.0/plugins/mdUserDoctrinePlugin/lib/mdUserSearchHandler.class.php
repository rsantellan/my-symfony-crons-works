<?php

class mdUserSearchHandler {
  
  public static function retrieveByMdUserId($mdUserId)
  {
    return Doctrine::getTable("mdUserSearch")->searchByMdUserId($mdUserId);
  }
  
  public static function setMdPassportToNull($mdUserId)
  {
    $mdUserSearch = self::retrieveByMdUserId($mdUserId);// Doctrine::getTable("mdUserSearch")->searchByMdUserId($mdUserId);
    if($mdUserSearch)
    {
      $mdUserSearch->setUsername(NULL);
      $mdUserSearch->save();  
    }
  }
  
  public static function saveMdUser($mdUser)
  {
    $mdUserSearch = self::retrieveByMdUserId($mdUser->getId());//Doctrine::getTable("mdUserSearch")->searchByMdUserId($mdUser->getId());
    if(!$mdUserSearch)
    {
        $mdUserSearch = new mdUserSearch();
        $mdUserSearch->setMdUserId($mdUser->getId());
    }
    $mdUserSearch->setEmail($mdUser->getEmail());
    $mdUserSearch->save();
  }
  
  public static function saveMdPassport($mdPassport)
  {
    $mdUserSearch = self::retrieveByMdUserId($mdPassport->getMdUserId());//Doctrine::getTable("mdUserSearch")->searchByMdUserId($mdPassport->getMdUserId());
    if(!$mdUserSearch)
    {
        $mdUserSearch = new mdUserSearch();
        $mdUserSearch->setMdUserId($mdPassport->getMdUserId());
    }
    $mdUserSearch->setUsername($mdPassport->getUsername());
    $mdUserSearch->setActive($mdPassport->getAccountActive());
    $mdUserSearch->setBlocked($mdPassport->getAccountBlocked());
    //Esto lo hago por el admin
    $found = false;
    if($mdPassport->getMdUser()->getSuperAdmin())
    {
      $found = true;
    }
    else
    {
      if (sfConfig::get('sf_plugins_user_groups_permissions', false))
      {
        $mdGroups = mdGroupHandler::retrieveAllMdGroupsOfMdPassport($mdPassport->getId());
        $found = false;
        $index = 0;
        while(!$found && $index < count($mdGroups))
        {
            $auxGroup = $mdGroups[$index];
            if($auxGroup->getName() == "admin")
            {
                $found = true;
            }
            $index++;
        }
      }
    }
    $mdUserSearch->setAdmin($found);
    $mdUserSearch->save();    
  }
  
  public static function saveMdUserProfile($mdUserProfile)
  {
    $mdObject = Doctrine::getTable('mdContent')->retrieveByObject($mdUserProfile);
    if(!$mdObject)
    {
        if($mdUserProfile->getMdUserIdTmp() != 0)
        {
            $mdUserId = $mdUserProfile->getMdUserIdTmp();
        }
        else
        {
            return;
        }
        
    }
    else
    {
        $mdUserId = $mdObject->getMdUserId();
    }
    $mdUserSearch = self::retrieveByMdUserId($mdUserId);//Doctrine::getTable("mdUserSearch")->searchByMdUserId($mdUserId);
    if(!$mdUserSearch)
    {
        $mdUserSearch = new mdUserSearch();
        $mdUserSearch->setMdUserId($mdUserId);
    }
    $mdUserSearch->setName($mdUserProfile->getName());
    $mdUserSearch->setLastName($mdUserProfile->getLastName());
    $mdUserSearch->setCountryCode($mdUserProfile->getCountryCode());
    $mdUserSearch->save();    
  }
  
  public static function saveAvatar($src, $mdUserProfileId)
  {
    $mdUserProfile = Doctrine::getTable("mdUserProfile")->find($mdUserProfileId);
    $mdObject = Doctrine::getTable('mdContent')->retrieveByObject($mdUserProfile);
    $mdUserId = $mdObject->getMdUserId(); 
    $mdUserSearch = self::retrieveByMdUserId($mdUserId);
    if(!$mdUserSearch)
    {
        $mdUserSearch = new mdUserSearch();
        $mdUserSearch->setMdUserId($mdUserId);
    }
    $mdUserSearch->setAvatarSrc($src);
    $mdUserSearch->save(); 
  }
  
  public static function saveEmailIsPublic($mdUserProfileId, $is_public = false)
  {
    $mdUserProfile = Doctrine::getTable("mdUserProfile")->find($mdUserProfileId);
    $mdObject = Doctrine::getTable('mdContent')->retrieveByObject($mdUserProfile);
    $mdUserId = $mdObject->getMdUserId(); 
    $mdUserSearch = self::retrieveByMdUserId($mdUserId);
    if($mdUserSearch)
    {
      $mdUserSearch->setShowEmail($is_public);
      $mdUserSearch->save();
    }
  }
  
  public static function doSearch($phrase = "", $mdUserId = null, $active = true, $blocked = false, $use_admin = true, $admin = false)
  {
    $list = Doctrine::getTable("mdUserSearch")->doSearch($phrase, $active, $blocked, $use_admin, $admin);
    if(is_null($mdUserId))
    {
      return $list;
    }
    $return = array();
    foreach($list as $userId)
    {
      if($mdUserId != (int)$userId[0])
      {
        array_push($return, $userId);
      }
    }
    return $return;
  }
    
}
