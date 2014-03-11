<?php

class mdWebImage
{
    //Diccionario que contiene todas las posibles opciones que se pueden pasar.
    //Es utilizado para armar la url de forma mas corta
    public static $dictionary = array(
        'p' => mdWebCodes::PERSPECTIVE,

        'o' => mdWebCodes::ORIGINAL,

        'r' => mdWebCodes::RESIZE,
        
        'rc' => mdWebCodes::RESIZECROP,

        'cr' => mdWebCodes::CROPRESIZE,

        'u' => mdWebCodes::ROUND_CORNERS,

        'c' => mdWebCodes::CROP,

        'w' => mdWebOptions::WIDTH,

        'h' => mdWebOptions::HEIGHT,

        's' => mdWebOptions::RZ_STRICT,

        'e' => mdWebOptions::EXACT_DIMENTIONS,

        'x' => mdWebOptions::CODE,

        't' => mdWebOptions::TOP,

        'l' => mdWebOptions::LEFT,

        'g' => mdWebOptions::GRAVITY,

				'a' => mdWebOptions::ANGLE_ROUND
    );

    public function __construct() {}

    public static function getUrl($mdImage, $options = null)
    {
        sfProjectConfiguration::getActive()->loadHelpers(array('Url'));
        if(!is_null($options))
        {
            if(isset($options['absolute_path']))
            {
                unset($options['absolute_path']);
                return url_for('@' . sfConfig::get('app_mdImage_routing', 'mdImageSrc') . '?i=' . mdWebImage::generateQueryStringParameter($mdImage, $options), true);
            }
        }
        return url_for('@' . sfConfig::get('app_mdImage_routing', 'mdImageSrc') . '?i=' . mdWebImage::generateQueryStringParameter($mdImage, $options));
    }

    public static function generateQueryStringParameter($mdImage, $options = null)
    {
        $relativePath = (is_object($mdImage)) ? $mdImage->getRouteWithOutPath() : $mdImage;
        $param = $relativePath;
        if(!is_null($options)) $param.= self::generateParametersForOptions($options);
        $return = base64_encode($param).'.'.mdBasicFunction::get_file_extension($relativePath); 
        return $return;
    }

    public static function getParametersFromQueryString($queryString)
    {
        $array = self::parse($queryString);
        return array(sfConfig::get('sf_upload_dir') . $array['route'], $array['options']);
    }

    public static function parse($queryString)
    {
        $array = array();
        $queryString = base64_decode($queryString, true);
        sfContext::getInstance()->getLogger()->info('{mdWebImage 74} queryString: ' . $queryString);
        $array_params = explode('|', $queryString);

        if(!isset($array_params[1])) throw new Exception('can not parse uri', 1000);

        //Obtengo ruta
        $array['route'] = $array_params[0];

        //Obtengo options
        $options = array();
        $optionsBloc = explode(':',$array_params[1]);
        $keys = str_split($optionsBloc[0]);
        $optionsValues = explode('/',$optionsBloc[1]);
        for($i=0;$i<count($keys);$i++)
        {
            $options[mdWebImage::$dictionary[$keys[$i]]] = $optionsValues[$i];
        }
        $array['options'] = $options;
        return $array;
    }

    public static function generateParametersForOptions($options = null)
    {
        $keys = '';
        $param = '';

        foreach($options as $key => $opt){
            $key_for_this_opt = array_search($key, mdWebImage::$dictionary);
            if($key_for_this_opt !== false){
                $keys .= $key_for_this_opt;
            }
        }
        if(!is_null($options)) $param = '|' . $keys . ':' . implode('/', $options);
        return $param;
    }
}

class mdWebCodes
{

    const ORIGINAL  = 'original';

    const RESIZE    = 'resize';
    
    const RESIZECROP = 'resizecrop';

    const CROPRESIZE = 'cropresize';

    const ROUND_CORNERS = 'rounded';

    const PERSPECTIVE   = 'perspective';

    const CROP          = 'crop';

}

class mdWebOptions
{

    const WIDTH     = 'width';

    const HEIGHT    = 'height';

    const EXACT_DIMENTIONS  = 'exactDimentions';

    const RZ_STRICT         = 'rz_strict';

    const CODE              = 'code';

    const ANGLE_ROUND       = 'angle';
    
    const TOP               = 'top';

    const LEFT              = 'left';

    const GRAVITY           = 'gravity';

}