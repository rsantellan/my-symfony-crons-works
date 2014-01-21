<?php
 
class mdI18nBehaviorListener extends Doctrine_Record_Listener
{  
	public function postSave(Doctrine_Event $event) 
	{
		$object = $event->getInvoker();
		
		try{
			$object->hasParent();
			return;
		}catch(Exception $e){
			
		}
		
		if(!Doctrine::getTable('mdI18NManageClasses')->getObjectByClassName(get_class($object))){
			$mdI18NManageClasses = new mdI18NManageClasses();
			$mdI18NManageClasses->setClassName(get_class($object));
			$mdI18NManageClasses->save();
		}
	}
	
}

