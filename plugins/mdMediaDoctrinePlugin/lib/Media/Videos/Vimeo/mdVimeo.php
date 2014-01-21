<?php
 
class mdVimeo
{
  protected $username;        // User Vimeo name
  
  protected $url   = NULL;    // The Vimeo URL for a video.
  
  public $width    = 400;    // (optional) The exact width of the video. Defaults to original size.

  public $maxwidth = NULL;    // (optional) Same as width, but video will not exceed original size.

  public $height   = 300;    // (optional) The exact height of the video. Defaults to original size.

  public $maxheight= NULL;    // (optional) Same as height, but video will not exceed original size.

  public $byline   = NULL;    // (optional) Show the byline on the video. Defaults to true.
      
  public $title    = NULL;    // (optional) Show the title on the video. Defaults to true.
      
  public $portrait = NULL;    // (optional) Show the user's portrait on the video. Defaults to true.
      
  public $color    = NULL;    // (optional) Specify the color of the video controls.
      
  public $callback = NULL;    // (optional) When returning JSON, wrap in this function.
      
  public $autoplay = NULL;    // (optional) Automatically start playback of the video. Defaults to false.
      
  public $loop     = NULL;    // (optional) Play the video again automatically when it reaches the end. Defaults to false.
      
  public $xhtml    = NULL;    // (optional) Make the embed code XHTML compliant. Defaults to true.
      
  public $api      = NULL;    // (optional) Enable the Javascript API for Moogaloop. Defaults to false.
      
  public $wmode    = NULL;    // (optional) Add the "wmode" parameter. Can be either transparent or opaque.
      
  public $iframe   = NULL;    // (optional) Use our new embed code. Defaults to true. New!

  protected $query    = NULL;
  
  protected static $OEMBED_ENDPOINT;
  
  protected static $API_ENDPOINT;
  
  public function __construct() 
  {
    self::$OEMBED_ENDPOINT = sfConfig::get('app_vimeo_OEMBED_ENDPOINT');
    self::$API_ENDPOINT = sfConfig::get('app_vimeo_API_ENDPOINT');
  }
  
  public function setUrl($url)
  {
    $this->url = $url;
  }
  
  /**
   *<?xml version="1.0" encoding="UTF-8"?>
   * <oembed>
   *   <type>video</type>
   *   <version>1.0</version>
   *   <provider_name>Vimeo</provider_name>
   *   <provider_url>http://www.vimeo.com/</provider_url>
   *   <title>Meet the office</title>
   *   <author_name>Blake Whitman</author_name>
   *   <author_url>http://www.vimeo.com/blakewhitman</author_url>
   *   <is_plus>0</is_plus>
   *   <html>&lt;object type=&quot;application/x-shockwave-flash&quot;...&lt;/object&gt;</html>
   *   <width>504</width>
   *   <height>380</height>
   *   <duration>361 </duration>
   *   <description>Check out the Vimeo Video School </description>
   *   <thumbnail_url>
   *     http://90.media.vimeo.com/d1/5/38/21/85/thumbnail-38218529.jpg
   *   </thumbnail_url>
   *   <thumbnail_width>160</thumbnail_width>
   *   <thumbnail_height>120</thumbnail_height>
   *   <video_id>757219</video_id>
   * </oembed>
   * @return type 
   */
  public function getEmbedObject()
  {
    if(is_null($this->url))
    {
      return NULL;
    }
    else
    {
      $this->_prepareCallback();
      $http_connection = new HttpConnection();
      $xml = $http_connection->get(self::$OEMBED_ENDPOINT . '?' . $this->query);
      $oembed = simplexml_load_string($xml);
      return $oembed;
    }
  }
  
  protected function _prepareCallback()
  {
    $this->query = 'url=' . rawurlencode($this->url);
    
    $attributes = array('width', 'maxwidth', 'height', 'byline', 'title', 'portrait', 'color', 'callback', 'autoplay', 'loop', 'xhtml', 'api', 'wmode', 'iframe');
    foreach($attributes as $attribute)
    {
      if(!is_null($this->$attribute)){
        $this->query.= '&' . $attribute . '=' . rawurlencode($this->$attribute);
      }
    }
  }
  
  public function getSrc($oembed)
  {
    $matches = array();
    
    $result = preg_match('/(.+)src="([^"]*)"(.+)/', $oembed->html, $matches);
    
    if(!($result)) return NULL;
    
    return $matches[2];
  }
}

