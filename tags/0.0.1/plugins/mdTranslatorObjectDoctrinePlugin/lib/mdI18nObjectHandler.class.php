<?php 

class mdI18nObjectHandler
{
	/**
	 * For a given appliation loads all the lenguages defined in the app.yml
	 * @param String $application
	 * @return Array of lenguages.
	 * @author Rodrigo Santellan
	 */
	public static function loadApplicationLenguages($application){
		$config_dir = sfConfig::get ( 'sf_apps_dir' ) . '/'.$application.'/config';
		$config = sfYaml::load ( $config_dir . '/app.yml' );
		return $config['all']['cultures']['enabled'] ;
	}
	
	/**
	 * Validate the value against the field of the class form.
	 * @param String $class That the field belong 
	 * @param String $field Name of the field
	 * @param String $value Value of the field
	 * @param String $lang Selected lenguage
	 * @return Boolean
	 * @author Rodrigo Santellan
	 */
	public static function mdI18nValidate($class, $field, $value, $lang) {
		$formClass = $class . 'Form';
		$form = new $formClass ( );
		try {
			$form->disableLocalCSRFProtection ();
			$form->embedI18n ( array ($lang ) );
			$validator = $form->getValidator ( $lang );
			$validator [$field]->clean ( $value );
		} catch ( Exception $e ) {
			$this->exception = $e;
			return false;
		}
		return true;
	}
	
	/**
	 * Set the field and save the object with the given culture
	 * @param String $field_name Name of the field
	 * @param String $value Value of the field
	 * @param Object $object Child of sfDoctrineRecord 
	 * @param String $fromLang lenguage that the user comes
	 * @param String $toLang lenguage that the user whants to save
	 * @return boolean
	 * @author Rodrigo Santellan 
	 */
	public static function mdSetI18n($field_name, $value, $object, $fromLang, $toLang){
		if(is_null($object)) return false;
		sfDoctrineRecord::setDefaultCulture($toLang);
		$object->__call ( 'set' . $field_name, array ($value ) );
		$object->save();
		sfDoctrineRecord::setDefaultCulture($fromLang);
		return true;
	}
	
	/**
	 * Get the value of the field of the given culture
	 * @param String $field_name Name of the field
	 * @param sfOutputEscaperIteratorDecorator $object Object from the template
	 * @param String $baseLang base lang
	 * @param String $toLang switch lang
	 * @return string
	 * @author Rodrigo Santellan
	 */
	public static function mdI18nGetField($field_name,$object, $baseLang, $toLang){
		$object = $object->getRawValue();
		sfDoctrineRecord::setDefaultCulture($toLang);
		$return = $object->__call('get'.$field_name,array());
		sfDoctrineRecord::setDefaultCulture($baseLang);
		return $return;
	}
	
	/**
	 * Get the value of the field of the given culture
	 * @param String $field_name Name of the field
	 * @param String $objectClass name of the class of the object
	 * @param String $objectId id of the object
	 * @param String $baseLang base lang
	 * @param String $toLang switch lang
	 * @return string
	 * @author Rodrigo Santellan
	 */
	public static function mI18nGetFieldFromClass($field_name,$objectClass,$objectId,$baseLang,$toLang){

		$object = Doctrine::getTable ( $objectClass )->find ( $objectId );
		sfDoctrineRecord::setDefaultCulture($toLang);
		$return = $object->__call('get'.$field_name,array());
		sfDoctrineRecord::setDefaultCulture($baseLang);
		return $return;
	}
	
	/**
	 * Get the value of the field of the given culture
	 * @param String $field_name Name of the field
	 * @param mdI18nObjectBasicClass $object to change
	 * @param String $baseLang base lang
	 * @param String $toLang switch lang
	 * @return string
	 * @author Rodrigo Santellan
	 */
	public static function m18nGetFieldFromBasicObject($field_name,$object, $baseLang, $toLang){
		$object = Doctrine::getTable ( $object->getClass() )->find ( $object->getId() );
		sfDoctrineRecord::setDefaultCulture($toLang);
		$return = $object->__call('get'.$field_name,array());
		sfDoctrineRecord::setDefaultCulture($baseLang);
		return $return;
	}
	/**
	 * Return all the mdI18nObjectBasicClass of the given object, this contains the ones from the object and his attributes if they are available
	 * @param sfOutputEscaperIteratorDecorator $object Object from the template
	 * @return Array
	 * @author Rodrigo Santellan
	 */
	public static function mdI18nGetObjects($object, $profileId = NULL){
		$object = $object->getRawValue();
		$allI18n = $object->getI18n()->getOptions();
		$objectList = array();
		$fields = $allI18n['fields'];
        foreach($allI18n['fields'] as $field){
			$mdI18Object = new mdI18nObjectBasicClass($object->getId(),get_class($object),$field,$field);
			array_push($objectList,$mdI18Object);
		}
		try{
			$attributes = $object->retrieveAllAtributesObjects($profileId); //$object->getAllAtributes();
			foreach($attributes as $att){
				$attI18n = $att->getI18n()->getOptions();
				foreach($attI18n['fields'] as $field){
					$mdI18Object = new mdI18nObjectBasicClass($att->getId(),get_class($att),$field,$att->getMdAttribute()->getName());
					array_push($objectList,$mdI18Object);
                }
			}
		}catch(Exception $e){

		}
		return $objectList;
	}
	
	/**
	 * Returns all the attributes from an object.
	 * @param mdAttributeBehavoir class $object
	 * @return array of mdI18nObjectBasicClass || array() on case is empty.
	 * @author Rodrigo Santellan
	 */
	public static function mdI18nGetObjectsAttributes($object){
		$objectList = array();
		try{
			$attributes = $object->getAllAtributes(); 
			foreach($attributes as $att){
				$baseAttribute =$att; 
				$attI18n = $baseAttribute->getI18n()->getOptions();
				foreach($attI18n['fields'] as $field){
					$mdI18Object = new mdI18nObjectBasicClass($baseAttribute->getId(),$baseAttribute->getClass(),$field, $baseAttribute->getName());
					array_push($objectList,$mdI18Object);
				}
			}
			foreach($object->getRelatedObjectClass() as $related){
				try{
					$related = new $related;
					$attributes = $related->getAllAtributes(); 
					foreach($attributes as $att){
						$baseAttribute =$att; 
						$attI18n = $baseAttribute->getI18n()->getOptions();
						foreach($attI18n['fields'] as $field){
							$mdI18Object = new mdI18nObjectBasicClass($baseAttribute->getId(),$baseAttribute->getClass(),$field, $baseAttribute->getName());
							array_push($objectList,$mdI18Object);
						}
					}
				}catch(Exception $e){
					
				}
			}
		}catch(Exception $e){
			//print_r($e->getMessage());
		}
		return $objectList;
	}
	
	/**
	 * Returns all the list of objects from an attribute.
	 * @param mdAttributeBehavoir class $object
	 * @return array of mdI18nObjectBasicClass || array() on case is empty.
	 * @author Rodrigo Santellan
	 */
	public static function mdI18nGetObjectsAttributesLists($object){
		$objectList = array();
		$object = Doctrine::getTable ( $object->getClass() )->find ( $object->getId() );
		$objects = $object->getMdAttributeValue();
		foreach($objects as $obj){
			$attI18n = $obj->getI18n()->getOptions();
			foreach($attI18n['fields'] as $field){
				$mdI18Object = new mdI18nObjectBasicClass($obj->getId(),get_class($obj),$field, $obj->getName());
				array_push($objectList,$mdI18Object);
			}
			
		}
		return $objectList;
	}
}

/**
 * Basic class to manage the object translations
 * @author rodrigo
 *
 */
class mdI18nObjectBasicClass{
	private $_id;
	private $_class;
	private $_field;
	private $_show;
	
	/**
	 * @return the $_id
	 */
	public function getId() {
		return $this->_id;
	}

	/**
	 * @return the $_class
	 */
	public function getClass() {
		return $this->_class;
	}

	/**
	 * @return the $_field
	 */
	public function getField() {
		return $this->_field;
	}

	/**
	 * @return the $_show
	 */
	public function getShow() {
		return $this->_show;
	}
	
	/**
	 * @param $_id the $_id to set
	 */
	public function setId($_id) {
		$this->_id = $_id;
	}

	/**
	 * @param $_class the $_class to set
	 */
	public function setClass($_class) {
		$this->_class = $_class;
	}

	/**
	 * @param $_field the $_field to set
	 */
	public function setField($_field) {
		$this->_field = $_field;
	}
	/**
	 * @param $_show the $_show to set
	 */
	public function setShow($_show) {
		$this->_show = $_show;
	}




	
	public function __construct($id,$class,$field,$show){
		$this->setId($id);
		$this->setClass($class);
		$this->setField($field);
		$this->setShow($show);
	}
	

}
