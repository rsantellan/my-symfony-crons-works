<?php

class startbillingTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'rsantellan';
    $this->name             = 'startbilling';
    $this->briefDescription = 'Crea las facturas para el mes actual';
    $this->detailedDescription = <<<EOF
The [startbilling|INFO] task does things.
Call it with:

  [php symfony startbilling|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    accountsHandler::generateMonthBilling(date('n'), date('Y'));
    facturaHandler::generateAccountBill(date('n'), date('Y'));
    return true;
    $date = new DateTime();
//    $date->modify('-1 year');
    $date->modify('-2 month');
    $nowMonth = date('n');
    $nowYear = date('Y');
    $month = $date->format('n');
    $year = $date->format('Y');
    var_dump($month);
    var_dump($year);
    $termino = false;
    while(!$termino)
    {
      $date->modify('+1 month');
      $month = $date->format('n');
      $year = $date->format('Y');
      var_dump($month);
      var_dump($year);
      accountsHandler::generateMonthBilling($month, $year);
      facturaHandler::generateAccountBill($month, $year);
      
      if($year == $nowYear && $month == $nowMonth)
      {
          $termino = true;
      }
    }
  }
}
