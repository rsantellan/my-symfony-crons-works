<?php

/**
 * default actions.
 *
 * @package    demo
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions
{
    /**
    * Executes index action
    *
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request)
    {

    }

    public function executeSymfonyClearCache(sfWebRequest $request)
    {

        chdir(sfConfig::get('sf_root_dir')); // Trick plugin into thinking you are in a project directory

        $task = new sfCacheClearTask($this->dispatcher, new sfFormatter());
        $task->run(array(), array('app' => "backend"));
        $task->run(array(), array('app' => "frontend"));
        return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
    }

}
