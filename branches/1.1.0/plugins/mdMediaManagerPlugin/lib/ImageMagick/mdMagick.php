<?php

class mdMagick
{
    private $availableMethods = array();

    private $loadedPlugins = array();

    private $escapeChars = null ;

    private $history = array();

    private $originalFile = '';

    private $source = '';

    private $destination = '';

    private $imageMagickPath = '/usr/bin/';

    private $imageQuality = 90 ;

    public $debug = true;

    private $log = array();

    function __construct($sourceFile = '', $destinationFile = '')
    {
        $this->imageMagickPath = (sfConfig::get('app_mdImageMagick_path',false) ? sfConfig::get('app_mdImageMagick_path') : $this->imageMagickPath);

        $this->originalFile = $sourceFile;

        $this->source = $sourceFile ;

        $this->destination = $destinationFile;

        if(is_null($this->escapeChars) ){
            $this->escapeChars = !( strtolower ( substr( php_uname('s'), 0, 3))  == "win" ) ;
        }

        $this->loadPlugins();
    }


    public function getLog()
    {
        return $this->log;
    }

    public function getBinary($binName)
    {
        return $this->getImageMagickPath()  . $binName ;
    }

    function setSource($path)
    {
        $this->source = str_replace(' ','\ ',$path) ;
        return $this ;
    }

    function getSource()
    {
        return $this->source ;
    }

    function setDestination($path)
    {
        $path = str_replace(' ','\ ',$path) ;
        $this->destination = $path ;
        return $this;
    }

    function getDestination()
    {
        if( ($this->destination == ''))
        {
            $source = $this->getSource() ;
            $ext = end (explode('.', $source)) ;
            $this->destinationFile = dirname($source) . '/' . md5(microtime()) . '.' . $ext;
        }
        return $this->destination ;
    }

    function setImageMagickPath($path)
    {
        if($path != '')
            if ( strpos($path, '/') < strlen($path))
                $path .= '/';
        $this->imageMagickPath = str_replace(' ','\ ',$path);
    }

    function getImageMagickPath()
    {
        return $this->imageMagickPath;
    }

    function setImageQuality($value)
    {
        $this->imageQuality = intval($value);
        return $this;
    }

    function getImageQuality()
    {
        return $this->imageQuality;
    }

    function getHistory( $type = Null )
    {
        switch ($type)
        {
            case mdMagickHistory::returnCsv:
                return explode(',', array_unique($this->history));
            break;

            default:
                case mdMagickHistory::returnArray :
                    return array_unique($this->history) ;
            break;
        }
    }

    public function setHistory($path)
    {
        $this->history[] = $path ;
        return $this;
    }

    public function clearHistory()
    {
        unset ($this->history);
        $this->history = array();
    }


    public function requirePlugin($name, $version=null)
    {
        if(key_exists($name, $this->loadedPlugins)) {
            if(! is_null($version)) {
               if( property_exists($this->loadedPlugins[$name], 'version') ){
                    if($this->loadedPlugins[$name]->version > $version)
                       return true;

                    if($this->debug) throw new mdMagickException ('Plugin "'.$name.'" version ='.$this->loadedPlugins[$name]->version . ' required >= ' . $version);
               }
            }
            return true ;
        }

        if($this->debug) throw new mdMagickException ('Plugin "'.$name.'" not found!');
        return false;
    }

    private function loadPlugins()
    {
        $base = dirname(__FILE__) . '/plugins';
        $plugins = glob($base . '/*.php');
        foreach($plugins as $plugin)
        {
            $name = basename($plugin, '.php');
            $className = 'mdMagick_'.$name ;
            $obj = new $className();
            $this->loadedPlugins[$name] = $obj;
            foreach (get_class_methods($obj) as $method )
            {
                 $this->availableMethods[$method] = $name;
            }
        }
    }


    public function execute($cmd)
    {
        $ret = null ;
        $out = array();

        if($this->escapeChars) {
            $cmd= str_replace    ('(','\(',$cmd);
            $cmd= str_replace    (')','\)',$cmd);
        }
				
				sfContext::getInstance()->getLogger()->info('{mdMagick} exec: '.$cmd .' 2>&1');

        exec( $cmd .' 2>&1', $out, $ret);

        if($ret != 0)
            if($this->debug) trigger_error (new mdMagickException ('Error executing "'. $cmd.'" <br>return code: '. $ret .' <br>command output :"'. implode("<br>", $out).'"' ), E_USER_NOTICE );

        $this->log[] = array(
            'cmd' => $cmd
            ,'return' => $ret
            ,'output' => $out
        );

        return $ret ;
    }

    public function __call($method, $args)
    {
					sfContext::getInstance()->getLogger()->info('{mdMagick} __call');
        if(! key_exists($method, $this->availableMethods))
           throw new Exception ('Call to undefined method : ' . $method);

					sfContext::getInstance()->getLogger()->info('{mdMagick} __call: '. $method . ' \n' . $this->availableMethods[$method] );

           array_unshift($args, $this);
           $ret = call_user_func_array(array($this->loadedPlugins[$this->availableMethods[$method]], $method), $args);

           if($ret === false)
              throw new Exception ('Error executing method "' . $method ."'");

           return $ret ;
    }
}

class mdMagickHistory
{
    const returnArray = 0 ;
    const returnCsv   = 1 ;

    private function __construct(){}
}


class mdMagickException extends Exception
{
    function __construct($message, $code=1)
    {
        //parent::__construct('', $code);
        $this->message($message);
    }

    function message($message)
    {
        echo '<br><b>phMagick</b>: ' . $message ;
    }
}


class mdMagickGravity
{
    const None      = 'None' ;

    const Center    = 'Center' ;

    const East      = 'East' ;

    const Forget    = 'Forget' ;

    const NorthEast = 'NorthEast' ;

    const North     = 'North' ;

    const NorthWest = 'NorthWest' ;

    const SouthEast = 'SouthEast' ;

    const South     = 'South' ;

    const SouthWest = 'SouthWest' ;

    const West      = 'West' ;

    private function __construct(){}
}


class mdMagickTextObjectDefaults
{
    public static $fontSize ='12';

    public static $font = false;

    public static $color = '#000';

    public static $background = false;

    public static $gravity = mdMagickGravity::Center; //ignored in fromString()

    public $Text = '';

    private function __construct(){}
}


class mdMagickTextObject
{
    protected $fontSize;

    protected $font;

    protected $color;

    protected $background;

    protected $pGravity; //ignored in fromString()

    protected $pText = '';

    public function __construct(){
        $this->fontSize   = mdMagickTextObjectDefaults::$fontSize;
        $this->font       = mdMagickTextObjectDefaults::$font;
        $this->color      = mdMagickTextObjectDefaults::$color ;
        $this->background = mdMagickTextObjectDefaults::$background;
        $this->pGravity   = mdMagickTextObjectDefaults::$gravity;
    }

    function defaultFontSize($value){
        mdMagickTextObjectDefaults::$fontSize = $value;
    }

    function defaultFont($value){
        mdMagickTextObjectDefaults::$font = $value;
    }

    function defaultColor($value){
        mdMagickTextObjectDefaults::$color = $value;
    }

    function defaultBackground($value){
        mdMagickTextObjectDefaults::$background = $value;
    }

    function defaultGravity($value){
        mdMagickTextObjectDefaults::$gravity = $value;
    }

    function fontSize($i){
        $this->fontSize = $i ;
        return $this;
    }

    function font($i){
        $this->font = $i ;
        return $this;
    }

    function color($i){
        $this->color = $i ;
        return $this;
    }

    function background($i){
        $this->background = $i ;
        return $this;
    }

    function __get($var){
        return $this->$var ;
    }

    function gravity( $gravity){
        $this->pGravity = $gravity;
        return $this ;
    }

    function text( $text){
        $this->pText = $text;
        return $this ;
    }
}

?>
