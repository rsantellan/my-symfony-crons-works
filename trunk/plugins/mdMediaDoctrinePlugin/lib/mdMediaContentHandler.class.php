<?php

class mdMediaContentHandler
{

  public static function retrieveMdMediaContentByid($id)
  {
    return Doctrine::getTable("mdMediaContent")->find($id);
  }
  
}
