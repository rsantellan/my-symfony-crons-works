<?php

class progenitoresComponents extends sfComponents
{
  
  public function executePadres($request)
  {
    $this->progenitores = $this->usuario->getProgenitores();
  }  

}
