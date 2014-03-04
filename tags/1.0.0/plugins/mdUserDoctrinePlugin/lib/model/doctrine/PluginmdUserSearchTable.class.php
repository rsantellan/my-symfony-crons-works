<?php
/**
 */
class PluginmdUserSearchTable extends Doctrine_Table
{

  public function doSearch($phrase = "", $active = true, $blocked = false, $use_admin = true, $admin = false)
  {
    $query = $this->createQuery("dS");
    $query->select("dS.md_user_id");
    $pieces = explode(" ", $phrase);
    $count = 0;

    foreach($pieces as $word)
    {
      if(strlen($word) > 1)
      {
        $count++;
        $query->orWhere("dS.email LIKE ? OR dS.username LIKE ? OR dS.name LIKE ? OR dS.last_name LIKE ?", array($word."%", $word."%", $word."%", $word."%"));
      }
    }
    if($count == 0)
    {
      $query->addWhere("dS.id = ?", 0);
    }
    if($use_admin)
    {
      $query->addWhere("dS.active = ? AND dS.blocked = ? AND dS.admin = ?", array($active, $blocked, $admin));
    }
    else
    {
      $query->addWhere("dS.active = ? AND dS.blocked = ?", array($active, $blocked));
    }
    $query->setHydrationMode(Doctrine_Core::HYDRATE_NONE);
    
    return $query->execute();
  }
  
  public function searchByMdUserId($mdUserId)
  {
    $query = $this->createQuery("dS")
              ->addWhere("dS.md_user_id = ?", $mdUserId);
    return $query->fetchOne();      
              
  }
}
