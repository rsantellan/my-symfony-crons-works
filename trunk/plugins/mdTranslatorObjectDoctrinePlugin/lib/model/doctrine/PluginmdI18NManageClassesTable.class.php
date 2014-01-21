<?php

abstract class PluginmdI18NManageClassesTable extends Doctrine_Table
{
	public function getObjectByClassName($className){
		$q = $this->createQuery('j')
      			->where('j.class_name = ?', $className);
 
    return $q->fetchOne();
		
	}
}
