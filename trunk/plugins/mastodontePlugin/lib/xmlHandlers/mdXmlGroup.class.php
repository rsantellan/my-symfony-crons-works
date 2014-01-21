<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mdXmlGroup
 *
 * @author rodrigo
 */
class mdXmlGroup {

    private $id;

    private $name;

    private $requiered;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getRequiered() {
        return $this->requiered;
    }

    public function setRequiered($requiered) {
        $this->requiered = $requiered;
    }

}
