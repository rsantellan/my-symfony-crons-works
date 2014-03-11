<?php

/**
 * Description of mdImageMagickHandler
 *
 * @author rodrigo
 */
class mdImageMagickHandler {

    //put your code here

    private $width = 0;
    private $height = 0;
    private $crop = false;
    private $rz_strict = false;
    private $perspective = false;
    private $imageSource = "";
    private $fileDestination = "";
    private $convertPath = "convert";

    /**
     *
     * @param <String> $imageSource
     * @param <String> $folderDestination
     * @param <int> $width
     * @param <int> $height
     * @param <boolean> $crop
     */
    public function __construct($imageSource, $fileDestination, $options = array()) {
        $this->width  = (isset($options['width']) ? $options['width'] : NULL); // ancho
        $this->height = (isset($options['height']) ? $options['height'] : NULL); //alto
        $this->crop   = (isset($options['crop']) ? $options['crop'] : false); //hace crop de la imagen segun el tamaño dado
        $this->rz_strict   = (isset($options['rz_strict']) ? $options['rz_strict'] : false); //hace crop de la imagen segun el tamaño dado
        $this->perspective   = (isset($options['perspective']) ? $options['perspective'] : false); //genera una perspectiva

        $this->imageSource = $imageSource;
        $this->fileDestination = $fileDestination;// MdFileHandler::checkDirectory($fileDestination);
    	$this->convertPath = sfConfig::get('app_mdImageMagick_path') . $this->convertPath;
    }

    private function fileGenerate() {
        if (!$this->fileExist($this->imageSource)) {
            throw new Exception("No image has been given", 8181);
        }

        $fileSrc = $this->imageSource;
        $fileDsc = $this->fileDestination;

        $imageDetails = getimagesize($fileSrc);
        //foreach($imageDetails as $key => $detail){
            //sfContext::getInstance()->getLogger()->err('Key is: '.$key.' Value is: '.$detail);
        //}
        if($this->crop){

            $command = $this->getConvertCropCommand($this->width, $this->height);
        }else{
            $command = ' -resize ' . $this->width . 'x' . $this->height;
            if($this->rz_strict == true) $command .= '!';
        }
        $imageType = substr($imageDetails['mime'], 6);// trim($imageDetails['mime'], 'image/');

        if($imageType == "gif") $command .= ' -format ' . $imageType . ' -quality 85%';
        else $command .= ' -interlace line -format ' . $imageType . ' -quality 85%';

        if($this->perspective != false){

            //valores de los puntos iniciales SOLO FUNCIONA CON IMAGEN DE PROPORCION EXACTA AL ANCHO Y ALTO
            $i_tl = '0,0';
            $i_bl = '0,' . $this->height;
            $i_tr = $this->width . ',0';
            $i_br = $this->width . ',' . $this->height;

            list($tl, $bl, $tr, $br) = explode('*',$this->perspective);

            if($tl == 'null') $tl = $i_tl;
            if($bl == 'null') $bl = $i_bl;
            if($tr == 'null') $tr = $i_tr;
            if($br == 'null') $br = $i_br;

            $proy_params = $i_tl . ',' . $tl; //izquierda superior
            $proy_params .= ' ' . $i_bl . ',' . $bl;
            $proy_params .= ' ' . $i_tr . ',' . $tr;
            $proy_params .= ' ' . $i_br . ',' . $br;


            $command .= ' -virtual-pixel transparent -matte -distort Perspective "' . $proy_params . '"';

        }

        $exec = $this->convertPath . " $command $fileSrc $fileDsc";
        sfContext::getInstance()->getLogger()->info("COMANDO IMAGE - " . $exec);
        exec($exec);

        if (is_readable($fileDsc)) {
            chmod($fileDsc, 0775);
        }
       
    }

    private function fileExist($file) {
        return file_exists($file);
    }

    private function getConvertCropCommand($width, $height=null) {
        $commands = "";
        if ($height === null)
            $height = $width;

        // get size of the original
        $imginfo = getimagesize($this->imageSource);
        $orig_w = $imginfo[0];
        $orig_h = $imginfo[1];
        // resize image to match either the new width
        // or the new height
        // if original width / original height is greater
        // than new width / new height
        if ($orig_w / $orig_h > $width / $height) {
            // then resize to the new height...
            $commands .= ' -resize "x' . $height . '"';
            // ... and get the middle part of the new image
            // what is the resized width?
            $resized_w = ($height / $orig_h) * $orig_w;
            // crop
            $commands .= ' -crop "' . $width . 'x' . $height .
                    '+' . round(($resized_w - $width) / 2) . '+0"';
        } else {
            // or else resize to the new width
            $commands .= ' -resize "' . $width . '"';
            // ... and get the middle part of the new image
            // what is the resized height?
            $resized_h = ($width / $orig_w) * $orig_h;
            // crop
            $commands .= ' -crop "' . $width . 'x' . $height .
                    '+0+' . round(($resized_h - $height) / 2) . '"';
        }

        return $commands;
    }

    public function getImage(){
        if($this->fileExist($this->fileDestination)){
            return file_get_contents($this->fileDestination);
        }else{
            if($this->fileExist($this->imageSource)){
                $this->fileGenerate();
                return file_get_contents($this->fileDestination);
            }else{
                throw new Exception("No image has been given", 150);
            }
        }
    }
}

