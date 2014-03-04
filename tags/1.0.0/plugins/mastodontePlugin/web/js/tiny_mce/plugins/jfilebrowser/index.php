<?php

include("include/config.php");

$error = '';
if(isset($_REQUEST['uploadFile'])):

    include("include/fileManager.class.php");

    $directorio = $_REQUEST['directorio'];
    try
    {
        if($directorio == -1) throw new Exception('Debes seleccionar un directorio', 104);
        fileManager::upload($_FILES, JFILEBROWSER_PATH . '/' . $directorio);
    }
    catch(Exception $e)
    {
        $error = $e->getMessage();
    }

endif; ?>

<?php require_once RELATIVE_PATH_TO_LAYOUT; ?>
