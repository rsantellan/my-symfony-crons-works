<?php

/**
 * progenitor form.
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class progenitorForm extends BaseprogenitorForm
{
  public function configure()
  {
      unset($this['md_user_id'], $this['hijos_list'], $this['clave']);
  }
  
  public function save($con = null)
  {
    $old_email = '';
   
    if(!$this->isNew()){
      $progenitor = $this->getObject();
      $old_email = $progenitor->getMail();
    }

    $progenitor = parent::save($con);

    if($progenitor)
    {
      $new_email = $progenitor->getMail();
      if($new_email != '' && ($this->isNew() || $old_email != $new_email))
      {
	$progenitor->enviarActivacion();
      }
    }
    
    return $progenitor;

  }
}
