<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of actionsclass
 *
 * @author pablo
 */
class backendBasicActions extends sfActions
{

    public function executeIndex(sfWebRequest $request){
        
    }

    public function executeOpenBox(sfWebRequest $request){
        return $this->renderText(json_encode(array("content" => $this->getPartial('open_box'))));
    }

    public function executeAddBox(sfWebRequest $request){
        $header = $this->getPartial('closed_box');
        $content = $this->getPartial('open_box');

        return $this->renderText(json_encode(array('closed' => $header, 'open' => $content)));
    }

}