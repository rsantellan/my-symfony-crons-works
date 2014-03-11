<?php

class progenitoresTask extends sfBaseTask
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
    $this->name             = 'progenitores';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [progenitores|INFO] task does things.
Call it with:

  [php symfony progenitores|INFO]
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

      sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
      
      $databaseManager = new sfDatabaseManager($this->configuration);
      $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    
      //0, 49, 99, 149
      $usuarios = Doctrine::getTable('usuario')
        ->createQuery('u')
        ->where('u.mail_padres != ?', '')
        ->groupBy('u.mail_padres')
        ->offset(0)
        ->limit(50)
        ->execute();

      //soluciona bug de symfony que ponge como dominio la ruta al archivo symfony
      $badTLD = 'http://symfony/symfony/';
      $TLD = 'http://www.bunnyskinder.com.uy/';

      foreach($usuarios as $usuario){
        try{
          $padre = new progenitor();
          $padre->setMail(strtolower($usuario->getMailPadres()));
          $padre->setNombre(ucwords(strtolower($usuario->getNombrePadres())));
          $padre->setCelular($usuario->getCelularPadres());
          $padre->setDireccion(ucwords(strtolower($usuario->getDireccion())));
          $padre->setTelefono($usuario->getTelefono());
	  $padre->setClave(mdBasicFunction::generateTrivialPassword());
          $padre->save();
	  
          usuario_progenitor::addPadre($usuario->getId(), $padre->getId());

	  if($padre->getMail() != '')
	  {
	    $link = str_replace($badTLD, $TLD, url_for('@activation?code=' . $padre->doCode(), true));

	    $padre->enviarActivacion($link);
	  }
	  
        }catch(Exception $e){
            
          echo $e->getMessage();

        }
      }
      
      Md_TaskManager::unlockTask(__class__);
    }
    
  }
}
