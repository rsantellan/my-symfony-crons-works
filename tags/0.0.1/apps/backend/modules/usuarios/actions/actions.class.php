<?php

require_once dirname(__FILE__).'/../lib/usuariosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/usuariosGeneratorHelper.class.php';

/**
 * usuarios actions.
 *
 * @package    jardin
 * @subpackage usuarios
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usuariosActions extends autoUsuariosActions
{
  public function executeAddHermano(sfWebRequest $request)
  {
    $usuario_from = $request->getParameter('usuario_from');
    $usuario_to = $request->getParameter('usuario_to');
    
    $response = hermanos::addHermano($usuario_from, $usuario_to);
    
    return $this->renderText(mdBasicFunction::basic_json_response($response, array()));    
  }
  
  public function executeRemoveHermano(sfWebRequest $request)
  {
    $usuario_from = $request->getParameter('usuario_from');
    $usuario_to = $request->getParameter('usuario_to');
    
    hermanos::removeHermano($usuario_from, $usuario_to);
    
    return $this->renderText(mdBasicFunction::basic_json_response(true, array()));    
  }
  
  public function executeGetUsuarios(sfWebRequest $request)
  {
    $result = array();
    $items = array();
    $result['usuarios'] = array();
    $this->getContext()->getConfiguration()->loadHelpers("Url");
    
    $datas = Doctrine::getTable('usuario')->findAll(Doctrine_Core::HYDRATE_ARRAY);

    foreach($datas as $data)
    {
      $items[] = array("value" => $data['id'], "name" => $data['nombre'] . " " . $data['apellido'], "link" => url_for('@usuario_edit?id=' . $data['id']));
    }
    
    $result['usuarios'] = $items;    
    
    return $this->renderText(mdBasicFunction::basic_json_response(true, $result));
  }
  
  public function executeGetUsuarios2(sfWebRequest $request)
  {
    $items = array();
    $this->getContext()->getConfiguration()->loadHelpers("Url");
    
    $datas = Doctrine::getTable('usuario')->createQuery('u')
      ->where('u.nombre LIKE ?', '%' . $request->getParameter('q') . '%')
      ->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

    foreach($datas as $data)
    {
      $items[] = array("value" => $data['id'], "name" => $data['nombre'] . " " . $data['apellido'], "link" => url_for('@usuario_edit?id=' . $data['id']));
    }

    return $this->renderText(json_encode($items));
  }  
  
  public function executeExportar(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->executeBatchExportar($request);
    
    $this->redirect('@usuario');
  }

  public function executePrintSave(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    
    $this->getUser()->setAttribute('usuario.ids', serialize($ids), 'admin_module');
    
    return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
  }
  
  public function executePrint(sfWebRequest $request)
  {
    $ids = unserialize($this->getUser()->getAttribute('usuario.ids', null, 'admin_module'));
    
    if(!is_null($ids))
    {
      $query = Doctrine::getTable('usuario')->createQuery('u')->whereIn('u.id', $ids);
    }else{
      $query = $this->buildQuery();
    }
    
    $pager = $this->configuration->getPager('usuario');
    $pager->setQuery($query);
    $pager->setMaxPerPage(10000);
    $pager->init();
    $this->pager = $pager;

    $this->setLayout(false);
  }

  protected function executeBatchExportar(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    
    if (count($ids) > 100)
    {
      $this->getUser()->setFlash('error', 'No puedes exportar mas de 100 alumnos en un solo archivo pdf.');
      $this->redirect('@usuario');
    }
    
    usuario::exportar($ids);
  }  
  
  public function executeBunnys(sfWebRequest $request)
  {
    $this->setLayout(false);
    $this->usuario = Doctrine::getTable('usuario')->find(24);
  }
  
  public function executeEnviar(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    
    if(!is_null($ids))
    {
      $query = Doctrine::getTable('usuario')->createQuery('u')->whereIn('u.id', $ids);
    }else{
      $query = $this->buildQuery();
    }

    usuario::enviar($query);
    
    return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      try {
        $usuario = $form->save();
        $usuario->updateNewsletter();
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

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $usuario)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@usuario_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'usuario_edit', 'sf_subject' => $usuario));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }  
}
