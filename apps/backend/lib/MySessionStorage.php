<?php
class MySessionStorage extends sfSessionStorage
{
  public function initialize($parameters = null)
  {
    $upload = sfContext::getInstance()->getRequest()->getParameter('upload',false);
    //Shitty work-around for swfuploader
    if( $upload )
    {
      $sessionName = $parameters["session_name"];
      $value = sfContext::getInstance()->getRequest()->getParameter($sessionName);
      if($value)
      {
        session_name($sessionName);
        session_id($value);
      }
    }

    parent::initialize($parameters);
  }
}
