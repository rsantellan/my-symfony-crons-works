<?php

class mdWebVideo
{

    public function __construct() {}

    public static function getUrl($mdVideo, $options = null)
    {
        sfProjectConfiguration::getActive()->loadHelpers(array('Url'));
        return url_for('@' . sfConfig::get('app_mdImage_routing', 'mdVideoSrc') . '?i=' . mdWebVideo::generateQueryStringParameter($mdVideo, $options));
    }

    public static function getAvatarUrl($mdAvatarVideo, $options = null)
    {
        sfProjectConfiguration::getActive()->loadHelpers(array('Url'));
        return url_for('@' . sfConfig::get('app_mdImage_routing', 'mdVideoAvatarSrc') . '?i=' . mdWebVideo::generateQueryStringParameter($mdAvatarVideo, $options));
    }

    public static function generateQueryStringParameter($mdVideo, $options = null)
    {
        $relativePath = (is_object($mdVideo)) ? $mdVideo->getRouteWithOutPath() : $mdVideo;
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

    public static function parse($queryString)
    {
        $array = array();
        $queryString = base64_decode($queryString, true);
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

}