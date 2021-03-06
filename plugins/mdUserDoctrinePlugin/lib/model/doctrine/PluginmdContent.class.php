<?php

/**
 * PluginmdContent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class PluginmdContent extends BasemdContent
{
    /**
     * objeto concreto al cual referencia el mdMediaContent
     * @var <object>
     */
    private $object = null;

    public function __toString()
    {
        return $this->getObjectClass();
    }

    public function retrieveObject()
    {
        if ($this->object == NULL)
        {
            $this->object = Doctrine::getTable($this->getObjectClass())->retrieveObject($this->getObjectId());
        }
        return $this->object;
    }
    
  public function retrieveParents()
  {
      return Doctrine::getTable("mdContentRelation")->retrieveParents($this->getId());
  }
  
  public function preDelete($event){
    if($this->getObjectClass() !== "mdMediaContent")
    {
        $aux = $this->retrieveObject();
        if($aux && !is_null($aux))
        {
          //print_r(get_class($aux));
          $aux->delete();
        }
        //$mdContent->delete();
    }
  }
}
