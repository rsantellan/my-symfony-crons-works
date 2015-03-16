<?php

/**
 * static actions.
 *
 * @package    frontend
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mdObjectTranslatorActions extends sfActions {
	
	var $app_list = array ();
	
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		$this->cargarDatos ();
		$this->selectionForm = $this->getSfFormForSelection ();
	}
	
	private function getSfFormForSelection() {
		$form = new sfForm ( );
		if (! $this->selected_module) {
			if(count($this->app_list) > 0){
				$i = 0;
				foreach ($this->app_list as $key => $value) {
					$i++;
					$this->selected_module = $value;
					if ( $i == 1 )
							break;
				} 
			}
		}
		if(!$this->list_lang){
 			$this->list_lang = mdI18nObjectHandler::loadApplicationLenguages($this->selected_module);
		}
		$form->setWidget ( 'selected_app', new sfWidgetFormSelect ( array ('label' => 'Aplicacion', 'choices' => $this->app_list, 'default' => $this->selected_module ) ) );
		$form->setWidget ( 'selected_catalogue', new sfWidgetFormInputHidden ( array ('default' => 'messages' ) ) );
		$form->setWidget ( 'selected_lang', new sfWidgetFormSelect ( array ('label' => 'Lenguaje', 'choices' => $this->list_lang, 'default' => $this->selected_lang ) ) );
		$form->setWidget ( 'pages', new sfWidgetFormChoice ( array ('label' => 'clases disponibles', 'multiple' => true, 'choices' => $this->getAbailableClasses () ) ) );
		$baseLang [''] = ''; 
		
		$form->setWidget ( 'base_lang', new sfWidgetFormSelect ( array ('label' => 'Lenguaje Base', 'choices' => $this->list_lang, 'default' => 0 ) ) );
		
		return $form;
	}
	
	private function getAbailableClasses() {
		return Doctrine::getTable ( 'mdI18NManageClasses' )->createQuery ( 'a' )->execute ();
	}
	
	private function cargarDatos() {
		$translatorSettings = sfConfig::get ( 'sf_mdI18nTranslator', '' );
		$arrApps = $translatorSettings ['translate_apps'];
		foreach ( $arrApps as $app ) {
			$this->app_list [$app] = $app;
		}
	
	}
	
	private function getObjectsOfType($class) {
		return Doctrine::getTable ( $class )->createQuery ( 'a' )->execute ();
	}
	
	public function executeGetApplicationObjectsAjax(sfWebRequest $request) {
		$objects = $this->getAbailableClasses ();
		$index = 0;
		$salida = array ();
		foreach ( $objects as $var ) {
			$salida [$index] ['object'] = $var->getClassName ();
			$index ++;
		}
		return $this->renderText ( json_encode ( $salida ) );
	}
	
	public function executeGetTranslationsFormsAjax(sfWebRequest $request) {
		
		$this->selected_lang = $request->getParameter ( 'lang' );
		$catalogue = $request->getParameter ( 'catalogue' );
		$this->selected_module = $request->getParameter ( 'app' );
		$index = $request->getParameter ( 'index' );
		$this->selected_object = $request->getParameter ( 'object' );
		$baseLang = $request->getParameter ( 'baselang' );
		$baseIndex = $index;
		$forms = array (0 => new sfForm ( ) );
		return $this->renderPartial ( 'formList', array ('objects' => $this->getObjectsOfType ( $this->selected_object ), 'index' => $baseIndex, 'object' => $this->selected_object, 'lang' => $this->selected_lang, 'baseLang' => $baseLang ) );
		
	}
	
	public function executeChageTextAjax(sfWebRequest $request) {
		$baseCulture = $this->getUser ()->getCulture ();
		$objectId = $request->getPostParameter ( 'object_id' );
		$objectClass = $request->getPostParameter ( 'object_class' );
		$selectedLang = $request->getPostParameter ( 'lang' );
		$selectedField = $request->getPostParameter ( 'field_name' );
		$value = $request->getPostParameter ( 'field' );
		
		$object = Doctrine::getTable ( $objectClass )->find ( $objectId );
		if (! $object)
			return $this->renderText ( 'Error' );
		if (mdI18nObjectHandler::mdI18nValidate( $objectClass, $selectedField, $value, $selectedLang )) {
			if(!mdI18nObjectHandler::mdSetI18n($selectedField,$value,$object, $baseCulture, $selectedLang)){
				return $this->renderText ( 'Error' );
			}
		}
		return $this->renderText ( 'ok' );
	}
	
	public function executeGetLangsAjax(sfWebRequest $request){
		$app=$request->getPostParameter('app');
		$this->selected_module = $app;
		$this->list_lang = mdI18nObjectHandler::loadApplicationLenguages($app);
		
		$options = array();
		$i=0;
		foreach($this->list_lang as $key => $cat){
		   $options[$i]['id'] = $key;
           $options[$i]['name'] = $cat;
           $i ++;
		}
		return $this->renderText(json_encode($options));
  }
}
