<?php

function format_text($text)
{
  if(preg_match('/^<p/', $text))
  {
    return $text;
  }
  else
  {
    return '<p>'.$text.'</p>';
  }
}

/**
 * Elimina las etiquetas HTML del texto. 
 * Adicionalmente se pueden pasar las etiquetas permitidas
 * 
 * @param $etiquetas_permitidas = array('<b><strong><li><ul><span>')
 */
function delete_format($text, $etiquetas_permitidas = NULL)
{
  return strip_tags($text, $etiquetas_permitidas);
}
