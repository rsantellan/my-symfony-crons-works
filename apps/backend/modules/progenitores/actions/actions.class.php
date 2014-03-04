<?php

require_once dirname(__FILE__).'/../lib/progenitoresGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/progenitoresGeneratorHelper.class.php';

/**
 * progenitores actions.
 *
 * @package    jardin
 * @subpackage padres
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class progenitoresActions extends autoProgenitoresActions
{
  public function executeAddProgenitor(sfWebRequest $request)
  {
    $usuario_from = $request->getParameter('usuario_id');
    $usuario_to = $request->getParameter('progenitor_id');

    $response = usuario_progenitor::addPadre($usuario_from, $usuario_to);
    
    return $this->renderText(mdBasicFunction::basic_json_response($response, array()));    
  }
  
  public function executeRemoveProgenitor(sfWebRequest $request)
  {
    $usuario_from = $request->getParameter('usuario_id');
    $usuario_to = $request->getParameter('progenitor_id');
    
    usuario_progenitor::removePadre($usuario_from, $usuario_to);
    
    return $this->renderText(mdBasicFunction::basic_json_response(true, array()));    
  }
  
  public function executeGetProgenitores(sfWebRequest $request)
  {
    $result = array();
    $items = array();
    $result['usuarios'] = array();
    $this->getContext()->getConfiguration()->loadHelpers("Url");
    
    $datas = Doctrine::getTable('progenitor')->findAll(Doctrine_Core::HYDRATE_ARRAY);

    foreach($datas as $data)
    {
      $items[] = array("value" => $data['id'], "name" => $data['nombre'] . ' - ' . $data['mail'], "link" => url_for('@progenitor_edit?id=' . $data['id']));
    }
    
    $result['usuarios'] = $items;    
    
    return $this->renderText(mdBasicFunction::basic_json_response(true, $result));
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      $is_new = ($form->getObject()->isNew());
      
      try {
        $progenitor = $form->save();
        if($is_new && $request->hasParameter('usuario_id'))
        {
            usuario_progenitor::addPadre($request->getParameter('usuario_id'), $progenitor->getId());
        }
      } catch (Doctrine_Validator_Exception $e) {

        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
            $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $progenitor)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        if($is_new && $request->hasParameter('usuario_id')){
            $this->redirect('@progenitor_new' . '?usuario_id=' . $request->getParameter('usuario_id'));
        }else{
            $this->redirect('@progenitor_new');
        }
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        if($is_new && $request->hasParameter('usuario_id')){
            $this->redirect('@usuario_edit' . '?id=' . $request->getParameter('usuario_id'));
        }else{
            $this->redirect(array('sf_route' => 'progenitor_edit', 'sf_subject' => $progenitor));            
        }

      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }
    
}
