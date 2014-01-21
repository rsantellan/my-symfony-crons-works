<?php

class mdCheckNewNewslettersTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'backend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'mdNewsletter';
    $this->name             = 'mdCheckNewNewsletters';
    $this->briefDescription = 'Chequea que los nuevos mails se envien';
    $this->detailedDescription = <<<EOF
The [mdCheckNewNewsletters|INFO] task does things.
Call it with:

  [php symfony mdCheckNewNewsletters|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    if (!Md_TaskManager::isTaskLocked(__class__)) 
    {
        Md_TaskManager::lockTask(__class__); 
        sfContext::createInstance($this->configuration);
        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

        // add your code here        
        
        mdNewsletterHandler::sendAllNotSendedMails();
        
        Md_TaskManager::unlockTask(__class__);
    }    

  }
}
