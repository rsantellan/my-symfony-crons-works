<?php
 
class mdContentBehaviorListener extends Doctrine_Record_Listener
{  
	public function postSave(Doctrine_Event $event) 
	{
            $object = $event->getInvoker();
            if(!Doctrine::getTable('mdContent')->retrieveByObject($object)){
								if(is_int($object->getMdUserIdTmp()) and $object->getMdUserIdTmp()>0){
	                $mdContent = new MdContent();
	                $mdContent->setObjectClass(get_class($object));
	                $mdContent->setObjectId($object->getId());
	                $mdContent->setMdUserId($object->getMdUserIdTmp());
	                $mdContent->save();
								}
            }
	}
	
	public function preDelete(Doctrine_Event $event)
  {
            
            $object = $event->getInvoker();
            sfContext::getInstance()->getLogger()->log('>>>>>>>>> PRE DELETE mdContentBehavior : '.$object->getObjectClass());
            $mdContent = Doctrine::getTable('mdContent')->retrieveByObject($object);
            if($mdContent && !is_null($mdContent))
            {
              sfContext::getInstance()->getLogger()->log('>>>>>>>>> PRE DELETE mdContentBehavior : '.$object->getObjectClass().' Encontro el mdContent');
              Doctrine::getTable('mdContentRelation')->deleteRelatedOfId($mdContent->getId());
            }
            /*foreach($list as $aux)
            {
              $aux->delete();
            }
            $content = Doctrine::getTable('mdContent')->retrieveByObject($object);
            $content->delete();*/
	}

	public function postDelete(Doctrine_Event $event)
  {
    if(class_exists("mdNewsfeedHandler"))
    {
      $object = $event->getInvoker();
      mdNewsfeedHandler::deleteObjectNewsFeeds($object->getId(), $object->getObjectClass());
    }	    
  }  

}

