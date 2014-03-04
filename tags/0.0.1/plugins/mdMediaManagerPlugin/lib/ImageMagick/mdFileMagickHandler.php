<?php
class mdFileMagickHandler
{

    /**
     * Se encarga de procesar la imagen creandola en caso de ser necesario
     * segun los parametros pasados en $options.
     *
     * La funcion devuelve la ruta a la imagen procesada
     *
     * @param <string> $route, path de la imagen original
     * @param <array> $options, opciones para procesar la imagen, ejemplo:
     *  $options['code']  => 'resize';
     *  $options['width'] => 60;
     *  $options['heigth']=> 60;
     *  $options['exactDimentions'] => 1;
     * @return <string>
     */
    public static function process($route, $options)
    {
        if(!isset($options[mdWebOptions::CODE]) )
        {
            if(isset($options[mdWebOptions::WIDTH]) || isset($options[mdWebOptions::HEIGHT]))
            {

                $options[mdWebOptions::CODE] = mdWebCodes::RESIZE;
            }
            
        }
        
        if($options[mdWebOptions::CODE] == mdWebCodes::ORIGINAL)
        {
            return $route; //devolver ruta original
        }        
        
        try{

            $cacheFile  = mdFileCacheHandler::getCacheFile($route, $options);

            if(!file_exists($cacheFile))
            {

                $mdMagick   = new mdMagick($route, $cacheFile);
								sfContext::getInstance()->getLogger()->info('{mdFileMagickHandler1} '.$route);
                if( sfConfig::get( 'sf_image_cuality_change', false ) )
                {
                    $cuality = (int) sfConfig::get( 'sf_image_cuality_porcent', 75 ) ;
                    $mdMagick->setImageQuality($cuality);
                }
								sfContext::getInstance()->getLogger()->info('{mdFileMagickHandler2} switch : ' . $options[mdWebOptions::CODE]);
                switch($options[mdWebOptions::CODE])
                {
                    case mdWebCodes::RESIZE:

                        list($width, $height, $exactDimentions) = self::processParameters($options);

                        $mdMagick->resize($width, $height, $exactDimentions);

                        break;
                    case mdWebCodes::RESIZECROP:

                        list($width, $height) = self::processParameters($options);

                        $mdMagick->resizeExactly($width, $height);

                        break;

	                  case mdWebCodes::CROPRESIZE:
	                       list($width, $height) = self::processParameters($options);

	                       $mdMagick->cropresize($width, $height);

	                       break;

                    case mdWebCodes::PERSPECTIVE:

                        throw new Exception('operation not implemented yet', 102);

                        break;
                    case mdWebCodes::ROUND_CORNERS:

                            list($round) = self::processParameters($options);

														sfContext::getInstance()->getLogger()->info('{mdFileMagickHandler3} roundCorners angle: ' . $round);
                            $mdMagick->roundCorners($round);
                            
                        break;
                    case mdWebCodes::CROP:

                            list($width, $height, $top, $left, $gravity) = self::processParameters($options);

                            $mdMagick->crop($width, $height, $top, $left, $gravity);

                       break;
                    default:

                        throw new Exception('operation not implemented yet', 102);

                        break;
                }

                if (is_readable($cacheFile))
                {
                    chmod($cacheFile, 0775);
                }
            }

            return $cacheFile;

        }catch(Exception $e){

            throw $e;
            
        }
        
    }

    /**
     * Devuelve el binario de la imagen de path $path
     *
     * @param <string> $path
     * @return <binary>
     */
    public static function getFileGetContents($path)
    {
        if(file_exists($path))
        {
            return file_get_contents($path);
        }
        else
        {
            throw new Exception('no image', 100);
        }
    }

    /**
     * Procesa los parametros validandolos
     *
     * @param <array> $options
     * @return <array>
     */
    private static function processParameters($options)
    {
        $values = array();
        switch($options[mdWebOptions::CODE])
        {
            case mdWebCodes::RESIZE:

                if (isset($options[mdWebOptions::WIDTH])) $width = $options[mdWebOptions::WIDTH];
                else throw new Exception('no width given', 100);

                $height = (isset($options[mdWebOptions::HEIGHT]) ? $options[mdWebOptions::HEIGHT] : 0);

                $exactDimentions = ((isset($options[mdWebOptions::EXACT_DIMENTIONS]) && $options[mdWebOptions::EXACT_DIMENTIONS] == 'true') ? true : false);

                $values = array($width, $height, $exactDimentions);
                
                break;
            case mdWebCodes::RESIZECROP:

                if (isset($options[mdWebOptions::WIDTH])) $width = $options[mdWebOptions::WIDTH];
                else throw new Exception('no width given', 100);

                if(isset($options[mdWebOptions::HEIGHT])) $height = $options[mdWebOptions::HEIGHT];
                else throw new Exception('no height given', 101);

                $values = array($width, $height);

                break;
          	case mdWebCodes::CROPRESIZE:

                if (isset($options[mdWebOptions::WIDTH])) $width = $options[mdWebOptions::WIDTH];
                else $width = null; //throw new Exception('no width given', 100);

                if(isset($options[mdWebOptions::HEIGHT])) $height = $options[mdWebOptions::HEIGHT];
                else $height = null; //throw new Exception('no height given', 101);

                $values = array($width, $height);

                break;
            case mdWebCodes::PERSPECTIVE:

                throw new Exception('operation not implemented yet', 102);

                break;
            case mdWebCodes::ROUND_CORNERS:

                if(isset($options[mdWebOptions::ANGLE_ROUND]))
									$angle = $options[mdWebOptions::ANGLE_ROUND];
								else
									$angle = 50;
								
								$values = array($angle);                    
                break;
            case mdWebCodes::CROP:
            
                if (isset($options[mdWebOptions::WIDTH])) $width = $options[mdWebOptions::WIDTH];
                else throw new Exception('no width given', 100);

                if(isset($options[mdWebOptions::HEIGHT])) $height = $options[mdWebOptions::HEIGHT] ;
                else throw new Exception('no height given', 101);
                    
                $top = ((isset($options[mdWebOptions::TOP])) ? $options[mdWebOptions::TOP] : 0);
                $left = ((isset($options[mdWebOptions::LEFT])) ? $options[mdWebOptions::LEFT] : 0);
                $gravity = ((isset($options[mdWebOptions::GRAVITY])) ? $options[mdWebOptions::GRAVITY] : mdMagickGravity::None);
                
                $values = array($width, $height, $top, $left, $gravity);
                
                break;
            default:
                    throw new Exception('operation not implemented yet', 102);
                break;
        }
        return $values;
    }

}
