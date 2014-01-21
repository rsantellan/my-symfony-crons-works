<?php
/**
 * @author Olivier Mansour
 * 
 * This plugin aims to simply resolve the problem of doing **cross app links** for Symfony 1.2. 
 *
 * It's done using the symfony core classes and some context switch, so you can really use the routing defined in each application. 
 *
 * # Usage 
 * This plugin provide an helper you can simply use as decribed [in the book](http://www.symfony-project.org/book/1_2/07-Inside-the-View-Layer#Helpers). For now just the url_for copycat is available : cross_app_url_for
 *  
 * function cross_app_url_for($appname, $url, $absolute = 'false', $env = null, $debug = 'false')
 *
 * Options are self-explanatory. $url is an internal uri as specified in the routing.ym off the $app application.
 *
 * # TODO 
 * investigate to check the overhead of the function
 * try catch the context creation 
 * dig more to find the adequat main controler (instead of lauching an exeception)
 * 
 * # Changelog
 * ## 01/12/2008 
 * initial realease - cross_app_url_for function
 *
 * # On the web
  [http://www.glagla.org/weblog/2008/11/10/liens-inter-applications-avec-symfony-12/](http://www.glagla.org/weblog/2008/11/10/liens-inter-applications-avec-symfony-12/)
 * 
 */

/**
 * return an url for a given symfony application and an internal url
 *
 * @author Olivier Mansour
 *
 * @param string $appname
 * @param string $url
 * @param boolean $absolute
 * @param string $env
 * @param boolean $debug
 * @return string
 */
function cross_app_url_for($appname, $url, $absolute = false, $env = null, $debug = false)
{

  $initial_app = sfContext::getInstance()->getConfiguration()->getApplication();
  $initial_web_controler = basename(sfContext::getInstance()->getRequest()->getScriptName());
  $initial_config = sfConfig::getAll();
  // get the environment
  if (is_null($env))
  {
    $env = sfContext::getInstance()->getConfiguration()->getEnvironment();
  }

  // context creation
  if (!sfContext::hasInstance($appname))
  {
    $context = sfContext::createInstance(ProjectConfiguration::getApplicationConfiguration($appname, $env, $debug), $appname);
  }
  else
  {
    $context = sfContext::getInstance($appname);
  }
  $web_url = $context->getController()->genUrl($url, $absolute);
  sfContext::switchTo($initial_app);
  sfConfig::add($initial_config);
  unset($context);

  //remove initial web controler
  // genUrl use $this->context->getRequest()->getScriptName();, its a call to $_SERVER
  // so starting the shameless part !
  $script_name = $appname;
  if (($env != 'prod') and $env)
  {
    $script_name.='_'.$env;
  }
  elseif ($script_name == "frontend")
  {
    $script_name="index";
  }
  $script_name.='.php';
  // check if this file exist
  if (!file_exists(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.$script_name))
    throw new sfException('can t find '.$script_name.' in the web directory');
  $web_url = str_replace ($initial_web_controler, $script_name, $web_url);

  return $web_url;
}
