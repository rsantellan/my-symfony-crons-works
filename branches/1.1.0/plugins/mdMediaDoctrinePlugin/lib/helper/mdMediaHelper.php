<?php

function render_media($mdMediaConcrete, $options = array())
{
    if(is_object($mdMediaConcrete)){
        $array = array_merge(array('mediaConcrete' => $mdMediaConcrete), $options);
        echo get_partial('mdMediaContentAdmin/' . $mdMediaConcrete->getObjectClass(), $array);
    }else {
        sfContext::getInstance()->getLogger()->log('>>> render_media on non object, this is a cache problem');
    }
}
/**
 * render_public_media Renderiza la media acorde al tipo que es
 *
 * @param unknown $mdMediaConcrete
 * @param unknown $options = array()
 *  Los parametros por defecto son.
 *  array(
 *        "width" => 200,
 *        "height" => 200,
 *        "EXACT_DIMENTIONS" => true,
 *        "CODE" => mdWebCodes::RESIZECROP,
 * @return void
 */
function render_public_media($mdMediaConcrete, $options = array())
{
  if(!isset($options["width"]))
  {
    $options["width"] = 200;
  }
  if(!isset($options["height"]))
  {
    $options["height"] = 200;
  }
  if(isset($options["EXACT_DIMENTIONS"]))
  {
    $options["EXACT_DIMENTIONS"] = true;
  }
  else
  {
    $options["EXACT_DIMENTIONS"] = false;
  }
  if(!isset($options["CODE"]))
  {
    $options["CODE"] = mdWebCodes::CROPRESIZE;
  }
  if(!isset($options["IMAGE"]))
  {
    $options["IMAGE"] = false;
  }
  $array = array_merge(array('mediaConcrete' => $mdMediaConcrete), $options);
  echo get_partial('mdMediaContentFrontend/' . $mdMediaConcrete->getObjectClass(), $array);
}
