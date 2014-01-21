<?php

define('DIR_SLASH', DIRECTORY_SEPARATOR);

class mdFileFactory
{
  private static $imageSupportedTypes = array(
                                              'gif' => 'gif', 
                                              'jpg' => 'jpg',																							'jpeg'=> 'jpeg',
                                              'png' => 'png'
                                              );
  
  private static $concreteFileSupportedTypes = array(
                                                    'doc' => 'doc', 
                                                    'docx' => 'docx', 
                                                    'pdf' => 'pdf',
                                                    'xls' => 'xls', 
                                                    'xlsx' => 'xlsx', 
                                                    'ppt' => 'ppt', 
                                                    'pptx' => 'pptx'
                                                    );
  
  public static function retrieveMdFile($path, $filename)
  {
    $file_extension = mdBasicFunction::get_file_extension($filename);

    if (array_key_exists(strtolower($file_extension), self::$imageSupportedTypes)) 
    {
      return new mdImageFile($path . $filename); 
    }
    
    if (array_key_exists(strtolower($file_extension), self::$concreteFileSupportedTypes)) 
    {
      return new mdConcreteFile($path , $filename); 
    }  
    return null;  
    //throw new Exception("the file type is not supported");
  }
  
}
