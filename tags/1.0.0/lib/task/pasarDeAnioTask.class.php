<?php

class pasarDeAnioTask extends sfBaseTask {

    protected function configure() {
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

        $this->namespace = 'mastodonte';
        $this->name = 'pasarDeAnio';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [pasarDeAnio|INFO] task does things.
Call it with:

  [php symfony pasarDeAnio|INFO]
EOF;
    }

    /*     * ********************************************************************************************* */

    //INSTALACION DEL CRON
    //0 0 15 12 * php /home/enbeta/domains/bunnyskinder.enbeta.net/mastodonte/symfony mastodonte:pasarDeAnio
    /*     * ********************************************************************************************* */
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

    protected function execute($arguments = array(), $options = array()) {

        if (!Md_TaskManager::isTaskLocked(__class__)) {
            Md_TaskManager::lockTask(__class__);
            sfContext::createInstance($this->configuration);
            // initialize the database connection
            $databaseManager = new sfDatabaseManager($this->configuration);
            $connection = $databaseManager->getDatabase($options['connection'])->getConnection();


            $q = Doctrine_Manager::getInstance()->getCurrentConnection();

            // Los de color rojo los marco como egresados
            $q->execute('UPDATE usuario SET egresado = "1" WHERE clase = "rojo" and egresado = "0"');

            // A los egresados le quito la clase
            $q->execute('UPDATE usuario SET clase = "" WHERE egresado = "1" AND clase <> ""');

            // Paso de anio los de color verde a rojo
            $q->execute('UPDATE usuario SET clase = "rojo" WHERE clase = "verde" and egresado = "0"');

            // Paso de anio los de color amarillo a verde
            $q->execute('UPDATE usuario SET clase = "verde" WHERE clase = "amarillo" and egresado = "0"');

            $usuarios = Doctrine::getTable('usuario')->findAll();

            foreach ($usuarios as $usuario) {
                // Si es egresado lo saco de todas las actividades en las que estaba
                if ($usuario->getEgresado()) {
                    $actividades = $this->getUsuarioActividades();
                    foreach ($actividades as $actividad) {
                        $actividad->delete();
                    }
                }

                $usuario->save();
            }

            Md_TaskManager::unlockTask(__class__);
        }
    }

}
