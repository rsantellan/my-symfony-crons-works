<?php
class mdMagick_info
{
    public function getInfo(mdMagick $p, $file='')
    {
        if ($file == '') $file = $p->getSource();
        return getimagesize  ($file);
    }

    public function getWidth(mdMagick $p, $file=''){
        list($width, $height, $type, $attr) = $this->getInfo($p, $file);
        return $width;
    }

    public function getHeight(mdMagick $p, $file=''){
        list($width, $height, $type, $attr)	 = $this->getInfo($p, $file);
        return $height;
    }


    public function getBits(mdMagick $p, $file=''){
        if ($file == '') $file = $p->getSource();
        $info =  getimagesize  ($file);
        return $info["bits"];
    }

    public function getMime(mdMagick $p, $file=''){
        if ($file == '') $file = $p->getSource();
        $info =  getimagesize  ($file);
        return $info["mime"];
    }
}
?>