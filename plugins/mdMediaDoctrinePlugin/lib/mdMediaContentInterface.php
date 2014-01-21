<?php
/**
 * mdMediaContentInterface
 * Interface que implemente todos los tipos de media.
 * 
 */
interface mdMediaContentInterface
{
  /**
   * isVideo
   *
   * Retorna si la media es de tipo video.
   * @return boolean
   */
  public function isVideo();
  
  /**
   * getObjectUrl
   *
   * @param array $options = array()
   * @return url (local o completa) de la imagen pedida del objecto
   */
  public function getObjectUrl($options = array());
  
  /**
     * Devuelve la ruta del objeto concreto
     * uso: $src = $object->getSource()
     * @return <string>
   */
  public function getObjectSource();
}
