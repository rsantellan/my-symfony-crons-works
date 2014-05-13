<?php

class regenerateNewsletterGroupsTask extends sfBaseTask
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
    $this->name             = 'regenerateNewsletterGroups';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [regenerateNewsletterGroups|INFO] task does things.
Call it with:

  [php symfony regenerateNewsletterGroups|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();    
    //Borro todo lo que estaba en la tabla
    $sqlDeleteGroupsUsers = "delete FROM md_news_letter_group_user";
    $q->execute($sqlDeleteGroupsUsers);

    //Obtengo todos los usuarios del newsletter
    $sqlFetchNewsletterUsers = "SELECT id, md_user_id FROM md_news_letter_user";
    $auxList = $q->fetchAssoc($sqlFetchNewsletterUsers);
    $newsletterList = array();
    foreach($auxList as $userAux)
    {
      $newsletterList[$userAux["md_user_id"]] = $userAux["id"];
    }

    // Obtengo todos los grupos del newsletter
    $sqlNewsletterGroups = "SELECT id, name FROM md_news_letter_group";
    $auxNewsletterGroups = $q->fetchAssoc($sqlNewsletterGroups);
    $groupsList = array();
    foreach($auxNewsletterGroups as $auxGroup)
    {
       //var_dump($auxGroup);
       $groupsList[$auxGroup["name"]] = $auxGroup["id"];
    }
    

    // Listado de las actividades
    $sqlActividades = "SELECT id, nombre, md_news_letter_group_id FROM actividades";
    $listActividades = $q->fetchAssoc($sqlActividades);

    // Datos basicos.
    $clases = array('verde', 'amarillo', 'rojo'); 
    $horarios = array('matutino', 'vespertino', 'doble_horario');

    $sqlInsert = "INSERT INTO md_news_letter_group_user(md_newsletter_group_id, md_newsletter_user_id, created_at, updated_at) VALUES (?, ? ,now(), now())";
    /***
     1 - Agrego los egresados

    ***/
    $sqlEgresados = "SELECT progenitor.id, progenitor.md_user_id FROM progenitor LEFT JOIN usuario_progenitor ON usuario_progenitor.progenitor_id = progenitor.id LEFT JOIN usuario ON usuario_progenitor.usuario_id = usuario.id WHERE usuario.egresado = 1";
    $listaEgresados = $q->fetchAssoc($sqlEgresados);
    $grupoUsado = "EGRESADOS";
    $idGrupoUsado = $groupsList[$grupoUsado];
    $usedList = array();
    foreach($listaEgresados as $egresado)
    {
          if(!isset($usedList[$egresado["md_user_id"]]))
          {
             $newsletterUserId = $newsletterList[$egresado["md_user_id"]];
             $q->execute($sqlInsert, array($idGrupoUsado, $newsletterUserId));
             $usedList[$egresado["md_user_id"]] = 1;
          }
    }


    /****

      2 - Agrego todas las clases con sus horarios

    ****/
    $sqlHorariosClases = "SELECT progenitor.id, progenitor.md_user_id FROM progenitor LEFT JOIN usuario_progenitor ON usuario_progenitor.progenitor_id = progenitor.id LEFT JOIN usuario ON usuario_progenitor.usuario_id = usuario.id WHERE usuario.egresado = 0 AND usuario.horario = ? AND usuario.clase = ?";

   foreach($clases as $clase)
   {
      foreach($horarios as $horario)
      {
         $usedList = array();
         $listadoPorHorarios = $q->fetchAssoc($sqlHorariosClases, array($horario, $clase));
         $grupoUsado = $clase . ' (' . $horario . ')';
         $idGrupoUsado = $groupsList[$grupoUsado];         
         foreach($listadoPorHorarios as $auxUsuario)
         {
            if(!isset($usedList[$auxUsuario["md_user_id"]]))
            {
              $newsletterUserId = $newsletterList[$auxUsuario["md_user_id"]];
              $q->execute($sqlInsert, array($idGrupoUsado, $newsletterUserId));
              $usedList[$auxUsuario["md_user_id"]] = 1;
            }
         }
         //var_dump($grupoUsado);
         //var_dump(count($usedList));
      }
   }
   
    /****

      3 - Agrego todas las actividades

    ****/
    $sqlPadresActividad = "SELECT progenitor.id, progenitor.md_user_id, actividades.md_news_letter_group_id FROM progenitor LEFT JOIN usuario_progenitor ON usuario_progenitor.progenitor_id = progenitor.id LEFT JOIN usuario ON usuario_progenitor.usuario_id = usuario.id LEFT JOIN usuario_actividades ON usuario_actividades.usuario_id = usuario.id LEFT JOIN actividades ON usuario_actividades.actividad_id = actividades.id WHERE usuario.egresado = 0 AND actividades.id = ?";
    foreach($listActividades as $actividad)
    {
      $usedList = array();
      $listado = $q->fetchAssoc($sqlPadresActividad, array($actividad["id"]));
      foreach($listado as $auxUsuario)
      {
         if(!isset($usedList[$auxUsuario["md_user_id"]]))
         {
            $idGrupoUsado = $auxUsuario["md_news_letter_group_id"];
            $newsletterUserId = $newsletterList[$auxUsuario["md_user_id"]];
            $q->execute($sqlInsert, array($idGrupoUsado, $newsletterUserId));
            $usedList[$auxUsuario["md_user_id"]] = 1;
         }
      }
    }

    /****

      4 - Agrego todos los padres.

    ****/
    $sqlEgresados = "SELECT progenitor.id, progenitor.md_user_id FROM progenitor LEFT JOIN usuario_progenitor ON usuario_progenitor.progenitor_id = progenitor.id LEFT JOIN usuario ON usuario_progenitor.usuario_id = usuario.id WHERE usuario.egresado = 0";
    $listaEgresados = $q->fetchAssoc($sqlEgresados);
    $grupoUsado = "PADRES";
    $idGrupoUsado = $groupsList[$grupoUsado];
    $usedList = array();
    foreach($listaEgresados as $egresado)
    {
          if(!isset($usedList[$egresado["md_user_id"]]))
          {
             $newsletterUserId = $newsletterList[$egresado["md_user_id"]];
             $q->execute($sqlInsert, array($idGrupoUsado, $newsletterUserId));
             $usedList[$egresado["md_user_id"]] = 1;
          }
    } 
  }
}
