<?php
 
class mdI18nBehavior extends Doctrine_Template
{
	public function setTableDefinition()
    {
		$this->addListener(new mdI18nBehaviorListener());
	}
	
	public function retrieveI18nFields(){
		return $this->getInvoker()->getMyI18nFields();
	}
	
	public function getClass(){
		return get_class($this->getInvoker());
	}
    
	public function getRelatedObjects(){
		$list = array();
		try{
			$list = $this->getInvoker()->getI18nRelatedObjects();
		}catch(Exception $e){
			
		}
		return $list;
	}
	
	public function getRelatedObjectClass(){
		$list = array();
		try{
			$list = $this->getInvoker()->getI18nRelatedObjectsClass();
		}catch(Exception $e){
			
		}
		return $list;
	}
}

