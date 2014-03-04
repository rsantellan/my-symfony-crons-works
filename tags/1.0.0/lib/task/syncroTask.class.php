<?php

class syncroTask extends sfBaseTask
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
    $this->name             = 'syncro';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [pasarDeAnio|INFO] task does things.
Call it with:

  [php symfony pasarDeAnio|INFO]
EOF;
  }

  /************************************************************************************************/
  //INSTALACION DEL CRON
  //0 0 15 12 * php /home/enbeta/domains/bunnyskinder.enbeta.net/mastodonte/symfony mastodonte:pasarDeAnio
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
    
    if (!Md_TaskManager::isTaskLocked(__class__)) 
    {
      Md_TaskManager::lockTask(__class__); 
      sfContext::createInstance($this->configuration);
      // initialize the database connection
      $databaseManager = new sfDatabaseManager($this->configuration);
      $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    
      $usuarios = Doctrine::getTable('usuario')->findAll();
      foreach($usuarios as $usuario){
        try{
          $usuario->updateNewsletter();
        }catch(Exception $e){
          echo $e->getMessage();
        }
      }
      
      Md_TaskManager::unlockTask(__class__);
    }
    
  }
}
