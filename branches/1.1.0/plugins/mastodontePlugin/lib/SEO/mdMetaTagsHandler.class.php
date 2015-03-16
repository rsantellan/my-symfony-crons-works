<?php

class mdMetaTagsHandler{
	
	
	/**
	* Agrega y configura metatags desde variables i18n
	* Se pueden configurar los valores por defecto desde el app.yml
	* 
	* Metas:
  *  prefix: 'Meta_'															// Prefijo de los sources i18n
  *  tags: ['title','description','keywords']			// Metatags a configurar en cada página
  *  sources:																			// Source del i18n usado para cada tag
  *    title: 'Titulo'
  *    description: 'Desripcion'
  *    keywords: 'Keywords'
  *  addParameterToSource: true										// Agrega los parametros al source del i18n
  *  genericSource:	'Global'											// Source i18n para los metatags genéricos
	* 
	* 
	* 
	* @param sfAction 	$action							La instancia de la acción
	* @param string			$i18nSource					El textos 'source' del i18n
	* @param array 			$options
	* 
	* Opciones:
	* string prefix									Prefijo del i18n																			Meta_
	* array tags										Coleccion de metatags a usar 													array('title','description')
	* array sources									Coleccion del source usado para cada metatag 					nombre_del_metatag
	* bool preserveActionMetas			En true no sobreescribe los metas de la accion				false
	* 
	*
	* Modo de uso:
	* En la acción 
	* 	mdMetaTagsHandler::addMetas($this,'Inicio');
	* 
	* Usando parametro dinamicos en los textos
	* 
	* 	$params = array();
	* 	$params['[Producto]'] = $this->producto->getName();
	* 	$params['[CategoriaPadre]'] = $this->padre->getName();
	* 	$params['[CategoriaHijo]'] = $this->categoria->getName();
	* 
	* 	mdMetaTagsHandler::addMetas($this,'Producto', array('params'=>$params));
  * 
	*
	* Para usar metas genericos en todo el sitio:
	* 
	* 		public function postExecute(){
  *				mdMetaTagsHandler::addGenericMetas($this,'del sitio');
  * 		}
  *
	*  
	*
	*
	* @package mastodontePlugin
	* @version 1.0.0
	* @author maui
	**/
	static public function addMetas(sfAction $action, $i18nSource, $options = array()){
		$lang = sfContext::getInstance()->getI18N();
		
		if(!isset($options['prefix']))
			$prefix = sfConfig::get('app_Metas_prefix','Meta_');
		else
			$prefix = $options['prefix'];
						
		if(!isset($options['tags']))
			$tags = sfConfig::get('app_Metas_tags',array('title','description'));
		else
			$tags = $options['tags'];
		
		if(isset($options['sources']))
			$sources = $options['sources'];
			
		if(isset($options['params']))
			$params = $options['params'];
		else
			$params = array();
		
		$preserveActionMetas = false;
		if(isset($options['preserveActionMetas'])){
			$preserveActionMetas = true;
		}
		
		$debug = false;
		if(isset($options['debug'])){
			$debug = true;
		}
			
		$sources_default = sfConfig::get('app_Metas_sources',array('title'=>'title', 'description'=>'description'));
		
		foreach($tags as $tag){
			if(!isset($sources[$tag]))
				$sources[$tag] = $sources_default[$tag];
		}

		if(sfConfig::get('app_Metas_addParameterToSource', false) and count($params)>0){
			$keys = array_keys($params);
			$keys = implode(' ',$keys);
			$keys = ' ' . $keys;
		}else{
			$keys = '';
		}
		foreach($tags as $tag){
			$inst_source = $prefix . $sources[$tag] . ' ' . $i18nSource .$keys;
			if($debug) echo $inst_source . ' <=> ' . $lang->__($inst_source);
			if($lang->__($inst_source) != $inst_source and $lang->__($inst_source) != ''){
				
				if($tag == 'title'){
					if(!$preserveActionMetas or $action->getResponse()->getTitle() == ''){
						$action->getResponse()->setTitle($lang->__($inst_source, $params));
						if($debug) echo  '  <=> setup title';
					}
				
				}else{
					if(!$preserveActionMetas or !in_array($tag, $metas)){
						$action->getResponse()->addMeta($tag, $lang->__($inst_source, $params));
						if($debug) echo  '  <=> setup ' . $tag;
					}
				}
			}
			if($debug) echo '<br/>';	
		}
		return $action;
	}
	/**
	* Agrega y configura metatags genericos para todas las paginas. 
	* Completa los tags vacios con los campos genericos.
	* No sobreescribe los tags ya configurados en la accion.
	* Se usa desde la accion postExecute de los modulos, por lo general
	* Se pueden configurar los valores por defecto desde el app.yml
	* 
	* @param sfAction 	$action							La instancia de la acción
	* @param string			$i18nSource					El textos 'source' del i18n			'Global'
	* @param array 			$options
	*
	* Para usar metas genericos en todo el sitio:
	* 
	* 		public function postExecute(){
  *				mdMetaTagsHandler::addGenericMetas($this,'del sitio');
  * 		}
  *
	*
	* @package mastodontePlugin
	* @version 1.0.0
	* @author maui
	**/
	static public function addGenericMetas(sfAction $action, $i18nSource = null, $options = array()){
		if(is_null($i18nSource)){
				$i18nSource = sfConfig::get('app_Metas_genericSource','Global');
		}
    $options['preserveActionMetas'] = true;

		return self::addMetas($action, $i18nSource, $options);

	}
}
