<?php

class usuariosComponents extends sfComponents
{
  public function executeHermanos($request)
  {
    $this->hermanos = Doctrine::getTable('hermanos')->findByUsuarioFrom($this->usuario->getId());
  } 

}
