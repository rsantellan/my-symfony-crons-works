<?php
 
class mdMediaContentBehavior extends Doctrine_Template
{
    public function setTableDefinition()
    {
        $this->addListener(new MdMediaContentBehaviorListener());
    }

    /**
     * Identificador del usuario, utilizado para relacionarlo con el mdUser
     * nota: el mdMediaContent actAs mdContentBehaviuor
     * @var <integer>
     */
    private $mdUserIdTmp = 0;

    public function getMdUserIdTmp(){
        return $this->getInvoker()->mdUserIdTmp;
    }

    public function setMdUserIdTmp($id){
        $this->getInvoker()->mdUserIdTmp = $id;
    }

    /**
     * Devuelve la ruta del objeto concreto
     * uso: $src = $object->getSource()
     * @return <string>
     */
    public function getSource(){
    	return $this->getInvoker()->getObjectSource();
    }

    public function getUrl($options = array('width' => 46,'height' => 46))
    {
        //solucion temporal hasta que se generen avatares para los videos
        return $this->getInvoker()->getObjectUrl($options);
    }

    /**
     * Devuelve el mdMediaContent del objeto concreto
     * uso: $mdMediaContent = $object->retreiveMdMediaContent();
     * @return <mdMediaContent>
     */
    public function retrieveMdMediaContent()
    {
        return Doctrine::getTable('mdMediaContent')->retrieveByObject($this->getInvoker());
    }

    /**
     * Elimina el archivo de la base y fisicamente
     */
    public function removeContent()
    {
        //Elimina el archivo de la base de datos
        if($this->getInvoker()->delete())
        {
            //Elimina el archivo fisicamente
            try
            {
                MdFileHandler::delete($this->getInvoker()->getPath() . $this->getInvoker()->getFilename());
            }
            catch(Exception $e)
            {
                //Logueo el error
            }
        }
    }

    public function savePriority($value)
    {
        $this->getInvoker()->priority = $value;
    }

    public function retrievePriority()
    {
        return $this->getInvoker()->priority;
    }

}

