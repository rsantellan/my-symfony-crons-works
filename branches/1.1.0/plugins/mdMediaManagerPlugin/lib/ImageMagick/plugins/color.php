<?php

class mdMagick_color {

    public function darken(mdMagick $p ,$alphaValue = 50)
    {
        $percent = 100 - (int) $alphaValue;

        //get original file dimentions

        list ($width, $height) = $p->getInfo();

        $cmd = $p->getBinary('composite');
        $cmd .=  ' -blend  ' . $percent . ' ';
        $cmd .= '"'.$p->getSource().'"';
        $cmd .= ' -size '. $width .'x'. $height.' xc:black ';
        $cmd .= '-matte "' . $p->getDestination().'"' ;

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }

    /**
     *
     *  Brightens an image, defualt: 50%
     *
     * @param $imageFile String - Physical path of the umage file
     * @param $newFile String - Physical path of the generated image
     * @param $alphaValue Integer - 100: white , 0: original color (no change)
     * @return boolean - True: success
     */
    public function brighten(mdMagick $p, $alphaValue = 50){
        $percent = 100 - (int) $alphaValue;

        //get original file dimentions

        list ($width, $height) = $p->getInfo();

        $cmd = $p->getBinary('composite');
        $cmd .=  ' -blend  ' . $percent . ' ';
        $cmd .= '"'.$p->getSource().'"';
        $cmd .= ' -size '. $width .'x'. $height.' xc:white ';
        $cmd .= '-matte "' . $p->getDestination().'"' ;

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p;
    }
    
    /**
     * Convert's the image to grayscale
     */
//    function toGrayScale(mdMagick $p){
//        $cmd  = $p->getBinary('convert');
//        $cmd .= ' "' . $p->getSource() .'"';
//        $cmd .= ' -colorspace Gray  ';
//        $cmd .= ' "' . $p->getDestination().'"' ;
//
//        $p->execute($cmd);
//        $p->setSource($p->getDestination());
//        $p->setHistory($p->getDestination());
//        return  $p ;
//    }

    public function toGreyScale(mdMagick $p, $enhance=2){
        $cmd   = $p->getBinary('convert');
        $cmd .= ' -modulate 100,0 ' ;
        $cmd .= ' -sigmoidal-contrast '.$enhance.'x50%' ;
        $cmd .= ' -background "none" "' . $p->getSource().'"' ;
        $cmd .= ' "' . $p->getDestination() .'"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }

    /**
     * Inverts the image colors
     */
    public function invertColors(mdMagick $p){
        $cmd  = $p->getBinary('convert');
        $cmd .= ' "' . $p->getSource() .'"';
        $cmd .= ' -negate ';
        $cmd .= ' "' . $p->getDestination() .'"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }
    
    public function sepia(mdMagick $p, $tone = 90){
        $cmd   = $p->getBinary('convert');
        $cmd .= ' -sepia-tone '. $tone .'% ' ;
        $cmd .= ' -modulate 100,50 ' ;
        $cmd .= ' -normalize ' ;
        $cmd .= ' -background "none" "' . $p->getSource() .'"' ;
        $cmd .= ' "' . $p->getDestination().'"' ;
        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }
    
    public function autoLevels(mdMagick $p){
        $cmd  = $p->getBinary('convert');
        $cmd .= ' -normalize ' ;
        $cmd .= ' -background "none" "' . $p->getSource().'"'  ;
        $cmd .= ' "' . $p->getDestination() .'"' ;

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }
	
}
?>