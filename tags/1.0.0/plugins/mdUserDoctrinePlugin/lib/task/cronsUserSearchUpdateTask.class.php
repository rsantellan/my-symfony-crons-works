<?php

class cronsUserSearchUpdateTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', 'frontend', sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', 'dev', sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
    ));

    $this->namespace        = 'crons';
    $this->name             = 'cronsUserSearchUpdateTask';
    $this->briefDescription = 'actualiza la tabla search';
    $this->detailedDescription = <<<EOF
The [crons:userInvite|INFO] task does things.
Call it with:

  [php symfony crons:cronsUserSearchUpdateTask|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array()) {
    if (!Md_TaskManager::isTaskLocked(__class__)) {
        Md_TaskManager::lockTask(__class__);
        
        // Create the Context
        $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
        $context       = sfContext::createInstance($configuration);
        
        $list = Doctrine::getTable("mdUser")->findAll();
        foreach($list as $user)
        {
            $user->save();
            $passport = mdUserHandler::retrieveMdPassportWithMdUserEmail($user->getEmail());
            $passport->save();
            $profile = mdUserHandler::retrieveMdUserProfileWithMdUserId($user->getId());
            $profile->save();
        }
        
        Md_TaskManager::unlockTask(__class__);
                
    } else {
        die('Task is Locked');
    }
  }
}
