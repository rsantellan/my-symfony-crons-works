<?php

/**
 * Adds a stylesheet to the response object.
 *
 * @see sfResponse->addStylesheet()
 */
function use_plugin_stylesheet($plugin, $css, $position = '', $options = array()) {
	sfContext::getInstance ()->getResponse ()->addStylesheet ( '../' . $plugin . '/css/' . $css, $position, $options );
}

/**
 * Adds a javascript to the response object.
 *
 * @see sfResponse->addJavascript()
 */
function use_plugin_javascript($plugin, $js, $position = '', $options = array()) {
	sfContext::getInstance ()->getResponse ()->addJavascript ( '../' . $plugin . '/js/' . $js, $position, $options );
}

function plugin_image_tag($plugin, $source, $options = array()) {
	if (! $source) {
		return '';
	}
	
	$options = _parse_attributes ( $options );
	
	$absolute = false;
	if (isset ( $options ['absolute'] )) {
		unset ( $options ['absolute'] );
		$absolute = true;
	}
	
	if (! isset ( $options ['raw_name'] )) {
		$options ['src'] = plugin_image_path ($plugin, $source, $absolute );
		
	} else {
		$options ['src'] = $source;
		unset ( $options ['raw_name'] );
	}
	
	if (isset ( $options ['alt_title'] )) {
		// set as alt and title but do not overwrite explicitly set
		if (! isset ( $options ['alt'] )) {
			$options ['alt'] = $options ['alt_title'];
		}
		if (! isset ( $options ['title'] )) {
			$options ['title'] = $options ['alt_title'];
		}
		unset ( $options ['alt_title'] );
	}
	
	if (isset ( $options ['size'] )) {
		list ( $options ['width'], $options ['height'] ) = explode ( 'x', $options ['size'], 2 );
		unset ( $options ['size'] );
	}
	
	return tag ( 'img', $options );
}

/**
 * Returns the path to an image asset.
 *
 * <b>Example:</b>
 * <code>
 *  echo image_path('foobar');
 *    => /images/foobar.png
 * </code>
 *
 * <b>Note:</b> The asset name can be supplied as a...
 * - full path, like "/my_images/image.gif"
 * - file name, like "rss.gif", that gets expanded to "/images/rss.gif"
 * - file name without extension, like "logo", that gets expanded to "/images/logo.png"
 *
 * @param string $source   asset name
 * @param bool   $absolute return absolute path ?
 *
 * @return string file path to the image file
 * @see    image_tag
 */
function plugin_image_path($plugin, $source, $absolute = false) {
	/*sfContext::getInstance()->getLogger()->err('ruta!!!!!!!!>>>>>>>>');
	sfContext::getInstance()->getLogger()->err('images/../'.$plugin.'/images');*/
	
	return _compute_public_path ( $source, 'images/../'.$plugin.'/images', 'png', $absolute );
}