<?php

class sendNewslettersTask extends sfBaseTask
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

    $this->namespace        = 'mastodonte';
    $this->name             = 'sendNewsletters';
    $this->briefDescription = 'Chequea que los nuevos mails se envien';
    $this->detailedDescription = <<<EOF
The [mdCheckNewNewsletters|INFO] task does things.
Call it with:

  [php symfony sendNewslettersTask|INFO]
EOF;
  }
     
  /************************************************************************************************/
  //INSTALACION DEL CRON ENBETA
  //*/15 * * * * php /home/enbeta/domains/bunnyskinder.enbeta.net/mastodonte/symfony mastodonte:sendNewsletters
  //INSTALACION DEL CRON LOCAL
  //*/15 * * * * php /home/chugas/mastodonte/clientes/jardin/trunk/symfony mastodonte:sendNewsletters
  /************************************************************************************************/
  /*
    *     *     *   *    *        command to be executed
    -     -     -   -    -
    |     |     |   |    |
    |     |     |   |    +----- day of week (0 - 6) (Sunday=0)
    |     |     |   +------- month (1 - 12)
    |     |     +--------- day of        month (1 - 31)
    |     +----------- hour (0 - 23)
    +------------- min (0 - 59)
   * 
   */  
  protected function execute($arguments = array(), $options = array())
  {
    //if (!Md_TaskManager::isTaskLocked(__class__)) 
    //{
    //    Md_TaskManager::lockTask(__class__); 
          sfContext::createInstance($this->configuration);
          // initialize the database connection
          $databaseManager = new sfDatabaseManager($this->configuration);
          $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

          cronFunctions::sendNewsletters(30);
        
    //  Md_TaskManager::unlockTask(__class__);
    //}    

  }
}
