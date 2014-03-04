<?php

/**
 * mdWebImage actions.
 *
 * @package    mdMediaManagerPlugin
 * @subpackage mdWebImage
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdWebImageActions extends sfActions
{

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

    try{

        $param = $request->getParameter ( 'i' );
        $response = $this->getResponse();

        list($route, $options) = mdWebImage::getParametersFromQueryString($param);

        if ($route)
        {
            $filePath = mdFileMagickHandler::process($route, $options);

            $last_modified_time = @filemtime($filePath);

            if($last_modified_time)
            {
                $response->setContentType('image/jpeg'); //Tipo de contenido imagen
                $response->setHttpHeader('Last-Modified', $response->getDate($last_modified_time)); //Fecha de ultima modificacion de la imagen
                $response->addCacheControlHttpHeader('max_age=2592000'); //Maximo de vida en cache de 30 dias
                $response->addCacheControlHttpHeader('private=True'); //contenido cacheado localmente en el navegador del usuario
            }

            if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && @strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time )
            {
                $response->setStatusCode(304); //304 Not Modified
            }
            else
            {
                //Status Code por default 200 OK
                $response->setContent ( mdFileMagickHandler::getFileGetContents($filePath) );
            }
        }
        else
        {
            $response->setStatusCode(404); //404 Not Found
        }
    }catch(Exception $e){
        
        $response->setStatusCode(404); //404 Not Found

    }

    $this->setLayout ( false );
    return sfView::NONE;
  }

}