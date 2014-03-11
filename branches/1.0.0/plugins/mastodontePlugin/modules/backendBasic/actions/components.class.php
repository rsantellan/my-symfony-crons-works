<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of backendBasicComponents
 *
 * @author pablo
 */
class backendBasicComponents extends sfComponents
{
    public function executeBackendTemplate(sfWebRequest $request){
        $this->module = (isset($this->module))? $this->module : 'backendBasic';
    }


}
