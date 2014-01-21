<?php

class bkAuthComponents extends sfComponents
{

    public function executeLogin(sfWebRequest $request)
    {
			if(!isset($this->form))
      	$this->form = new mdLoginForm();
    }

}
