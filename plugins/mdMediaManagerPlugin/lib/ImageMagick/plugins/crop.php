<?php
class mdMagick_crop
{
    /**
     *
     * @param $width Integer
     * @param $height Integer
     * @param $top Integer - The Y coordinate for the left corner of the crop rectangule
     * @param $left Integer - The X coordinate for the left corner of the crop rectangule
     * @param $gravity mdMagickGravity - The initial placement of the crop rectangule
     * @return unknown_type
     */
    function crop(mdMagick $p, $width, $height, $top = 0, $left = 0, $gravity = 'center')
    {

        $cmd  = $p->getBinary('convert');
        $cmd .= ' ' . $p->getSource() ;

        if (($gravity != '')|| ($gravity != mdMagickGravity::None) )  $cmd .= ' -gravity ' . $gravity ;

        $cmd .= ' -crop ' . (int)$width . 'x'.(int)$height ;
        //$cmd .= ' >+' . round(($resized_w - $width) / 2);
        $cmd .= '+' . $left.'+'.$top;
        $cmd .= ' -interlace line';
        $cmd .= ' ' . $p->getDestination();
        
        if( sfConfig::get( 'sf_plugin_mdMedia_imagick_debug', false ) )
        {
            sfContext::getInstance()->getLogger()->err($cmd);
        }
        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }

    /**
    * MASTODONTE hace crop primero y despues resize
    * @param $width
    * @param $height
    */
    public function cropresize(mdMagick $p , $width, $height)
    {
        $p->requirePlugin('resize');
        $p->requirePlugin('info');

        list($w,$h) = $p->getInfo($p->getSource());

				if($height === null and $width !== null){ //calculo el alto proporcional al ancho dado
					$height = $width * $h / $w;
				}elseif($width === null and $height !== null){
					$width = $height * $w / $h;
				}

        if($w > $h)
        {
            $cheight = $height * $w / $width;
            $cwidth = $w;

            if($cheight > $h)
            {
               $cheight = $h;
               $cwidth = $h * $width / $height;
            }
        }
        else
        {
            $cwidth = $width * $h / $height;
            $cheight = $h;

            if($cwidth > $w)
            {
               $cwidth = $w;
               $cheight = $w * $height / $width;
            }
        }

        $p->crop($cwidth, $cheight)->resize($width, $height);
        return $p;
    }
}
?>