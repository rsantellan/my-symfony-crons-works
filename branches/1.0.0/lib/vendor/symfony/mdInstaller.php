<?php

/*
 * Scrip para la instalacion basica de un mastodonte.
 * 
 * Estaria faltando la inclusion automatica de los plugins.
 * 
 * @author Rodrigo Santellan
 * 
 * 
 */ 

if(!$this instanceof sfGenerateProjectTask)
{
  die('Este script solo puede funcionar siendo una instancia de la creacion de un proyecto!'.PHP_EOL);
}

/**
 * Se configura el author, mastodonte es el basico.
 */

$author = "";
$author = $this->ask('Ingrese el nombre del autor (En caso de dejarlo vacio quedara mastodonte por defecto)');
if($author == '')
{
    $author = "Mastodonte <info@mastodonte.net>";
}
$this->runTask('configure:author', "'".$author."'");

$this->runTask('generate:app', 'frontend');
$this->runTask('generate:app', 'backend');

$this->getFilesystem()->mirror(
  sfConfig::get('sf_root_dir').'/lib/vendor/symfony/skeleton',
  sfConfig::get('sf_root_dir'),
  sfFinder::type('any')->discard('.sf'),
  array('override' => true)
);

$xmlFile = "mdPlugins.xml";

if(file_exists(sfConfig::get('sf_root_dir')."/".$xmlFile))
{
    
    $xml = simplexml_load_file ( sfConfig::get('sf_root_dir')."/".$xmlFile );
    $children = $xml->children("http://www.w3.org/2005/Atom");
    $file = sfConfig::get('sf_root_dir')."/"."svn.externals";
    if(file_exists($file))
    {
        unlink($file);
        echo "borrando temporales".PHP_EOL;
    }
    foreach($children as $plugin)
    {
        exec("echo '".(string) $plugin->name." ".(string) $plugin->path."' >> svn.externals");
    }
    exec("svn add plugins");
    exec("svn ci -m' ' plugins");
    exec("svn propset svn:externals -F svn.externals plugins");
}
else
{
    echo "No se a suministrado ningun plugin. Insertelos a mano.".PHP_EOL;
}

exec("svn up");
$this->runTask('cc');
//$this->runTask('doctrine:build --all --and-load --no-confirmation');
//exec("php symfony doctrine:build --all --and-load --no-confirmation");
$this->runTask('plugin:publish-assets');
$this->runTask('cc');
//exec();
