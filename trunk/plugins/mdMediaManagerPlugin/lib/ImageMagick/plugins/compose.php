<?php
class mdMagick_compose
{
    /**
     * Add's an watermark to an image
     *
     * @param $watermarkImage String - Image path
     * @param $gravity mdMagickGravity - The placement of the watermark
     * @param $transparency Integer - 1 to 100 the tranparency of the watermark (100 = opaque)
     */
    public function watermark(mdMagick $p, $watermarkImage, $gravity = 'center', $transparency = 50){
        //composite -gravity SouthEast watermark.png original-image.png output-image.png
        $cmd   = $p->getBinary('composite');
        $cmd .= ' -dissolve ' . $transparency ;
        $cmd .= ' -gravity ' . $gravity ;
        $cmd .= ' ' . $watermarkImage ;
        $cmd .= ' "' . $p->getSource() .'"' ;
        $cmd .= ' "' . $p->getDestination() .'"' ;

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }

    /**
     *
     * Joins severall imagens in one tab strip
     *
     * @param $paths Array of Strings - the paths of the images to join
     */
    public function tile(mdMagick $p,  Array $paths = null, $tileWidth = '', $tileHeight=1){
        if( is_null($paths) ) {
            $paths = $p->getHistory(mdMagickHistory::returnArray);
        }
        $cmd  = $p->getBinary('montage');
        $cmd .= ' -geometry x+0+0 -tile '.$tileWidth.'x'.$tileHeight.' ';
        $cmd .= implode(' ', $paths);
        $cmd .= ' "' . $p->getDestination() .'"' ;

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }

    /**
     * Attempts to create an image(s) from a File (PDF & Avi are supported on most systems)
     * it grabs the first frame / page from the source file
     * @param $file  String - the path to the file
     * @param $ext   String - the extention of the generated image
     */
    public function acquireFrame(mdMagick $p, $file, $frames=0)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' "' . $file .'"['.$frames.']' ;
        $cmd .= ' "' . $p->getDestination().'"'  ;

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }
}
?>