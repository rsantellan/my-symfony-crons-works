<?php
class mdMagick_convert
{
    public function convert(mdMagick $p)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -quality ' . $p->getImageQuality();
        $cmd .= ' "' . $p->getSource() .'"  "'. $p->getDestination().'"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        return  $p ;
    }

    public function save(mdMagick $p)
    {
        return $p->convert($p);
    }
}
?>