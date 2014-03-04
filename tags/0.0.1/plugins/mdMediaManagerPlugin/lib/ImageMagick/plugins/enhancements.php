<?php
class mdMagick_enhancements
{
    public function denoise(mdMagick $p,  $amount=1){
        $cmd   = $p->getBinary('convert');
        $cmd .= ' -noise '.$amount ;
        $cmd .= ' -background "none" "' . $p->getSource() .'"';
        $cmd .= ' "' . $p->getDestination() .'"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }


    public function sharpen(mdMagick $p, $amount =10){
        $cmd   = $p->getBinary('convert');
        $cmd .= ' -sharpen 2x' .$amount ;
        $cmd .= ' -background "none" "' . $p->getSource() .'"';
        $cmd .= ' "' . $p->getDestination() .'"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }

    public function smooth(mdMagick $p){
        $cmd   = $p->getBinary('convert');
        $cmd .= ' -despeckle -despeckle -despeckle ' ;
        $cmd .= ' -background "none" "' . $p->getSource() .'"';
        $cmd .= ' "' . $p->getDestination() .'"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }

    public function saturate(mdMagick $p, $amount=200){
        $cmd   = $p->getBinary('convert');
        $cmd .= ' -modulate 100,' .$amount ;
        $cmd .= ' -background "none" "' . $p->getSource().'"' ;
        $cmd .= ' "' . $p->getDestination().'"' ;

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }

    public function contrast(mdMagick $p,$amount=10){
        $cmd   = $p->getBinary('convert');
        $cmd .= ' -sigmoidal-contrast ' .$amount. 'x50%' ;
        $cmd .= ' -background "none" "' . $p->getSource().'"'  ;
        $cmd .= ' "' . $p->getDestination().'"'  ;

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }


    public function edges(mdMagick $p,$amount=10){
        $cmd   = $p->getBinary('convert');
        $cmd .= ' -adaptive-sharpen 2x' .$amount ;
        $cmd .= ' -background "none" "' . $p->getSource() .'"';
        $cmd .= ' "' . $p->getDestination() .'"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }

}
?>