<?php

class mdUserBlockedHandler 
{
    public static function changeBlockedStatus($mdUserId, $blocked)
    {
      $blockedUser = Doctrine::getTable("mdBlockedUsers")->findOneBy("md_user_id", $mdUserId);
      if(!$blocked && $blockedUser)
      {
        $blockedUser->delete();
        return true;
      }
      if($blocked && $blockedUser)
      {
        return true;
      }
      if($blocked && !$blockedUser)
      {
        $userBlocked = new mdBlockedUsers();
        $userBlocked->setMdUserId($mdUserId);
        $userBlocked->setReason($mdUserId);
        $userBlocked->save();
        return true;
      }
      
      return true;
    }
}
