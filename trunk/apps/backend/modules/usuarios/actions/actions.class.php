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
    $message = "No puede ser el mismo alumno.";
    $response = false;
    if($usuario_from != $usuario_to)
    {
      try
      {
        $response = hermanos::addHermano($usuario_from, $usuario_to);
      }catch(Exception $e){
        $message = $e->getMessage();
      }
    }
    
    return $this->renderText(mdBasicFunction::basic_json_response($response, array('message' => $message)));
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
  
  public function executeExportarExcel(sfWebRequest $request)
  {
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()
            ->setCreator("Rodrigo Santellan")
            ->setLastModifiedBy("Rodrigo Santellan")
            ->setTitle("Listado de alumnos")
            ->setSubject("Listado de alumnos")
            ->setDescription("Listado de alumnos.");      


    $objPHPExcel->setActiveSheetIndex(0);
    
    $query = $this->buildQuery()->limit(PHP_INT_MAX);
    
    $users = $query->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
    
    $data = array();
    foreach($users as $user)
    {
      $data[] = $user["id"];
    }
    //var_dump($data);
    unset($users);
    //var_dump(get_class($query));die;
    $sql = 'select usuario.id, usuario.nombre as u_nombre, usuario.apellido, usuario.fecha_nacimiento, usuario.anio_ingreso, usuario.sociedad, usuario.referencia_bancaria, usuario.emergencia_medica, usuario.horario, usuario.futuro_colegio, usuario.descuento, usuario.clase, progenitor.nombre as p_nombre, progenitor.direccion, progenitor.telefono, progenitor.celular, progenitor.mail from usuario left outer join usuario_progenitor on usuario.id = usuario_progenitor.usuario_id left join progenitor on progenitor.id = usuario_progenitor.progenitor_id ';
    $sql .= ' where usuario.id IN ('. implode(',', $data).')';
    $excel_data = array();
    if(count($data) > 0)
    {
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      $excel_data = $q->fetchAssoc($sql);
    }
    $index = 1;
    $letter = (string)(mdBasicFunction::retrieveLeters(0).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "Nombre");
    $letter = (string)(mdBasicFunction::retrieveLeters(1).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "Apellido");
    $letter = (string)(mdBasicFunction::retrieveLeters(2).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "Fecha de nacimiento");
    $letter = (string)(mdBasicFunction::retrieveLeters(3).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "Año de ingreso");
    $letter = (string)(mdBasicFunction::retrieveLeters(4).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "Sociedad");
    $letter = (string)(mdBasicFunction::retrieveLeters(5).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "Referencia bancaria");
    $letter = (string)(mdBasicFunction::retrieveLeters(6).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "Emergencia medica");
    $letter = (string)(mdBasicFunction::retrieveLeters(7).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "Horario");
    $letter = (string)(mdBasicFunction::retrieveLeters(8).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "Futuro colegio");
    $letter = (string)(mdBasicFunction::retrieveLeters(9).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "Descuento");
    $letter = (string)(mdBasicFunction::retrieveLeters(10).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "Clase");
    $letter = (string)(mdBasicFunction::retrieveLeters(11).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "Padre: nombre");
    $letter = (string)(mdBasicFunction::retrieveLeters(12).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "dirección");
    $letter = (string)(mdBasicFunction::retrieveLeters(13).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "telefono");
    $letter = (string)(mdBasicFunction::retrieveLeters(14).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "celular");
    $letter = (string)(mdBasicFunction::retrieveLeters(15).$index);
    $objPHPExcel->getActiveSheet()->setCellValue($letter, "mail");
    foreach($excel_data as $row)
    {
      $index ++;
      $letter = (string)(mdBasicFunction::retrieveLeters(0).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['u_nombre']);
      $letter = (string)(mdBasicFunction::retrieveLeters(1).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['apellido']);
      $letter = (string)(mdBasicFunction::retrieveLeters(2).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['fecha_nacimiento']);
      $letter = (string)(mdBasicFunction::retrieveLeters(3).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['anio_ingreso']);
      $letter = (string)(mdBasicFunction::retrieveLeters(4).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['sociedad']);
      $letter = (string)(mdBasicFunction::retrieveLeters(5).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['referencia_bancaria']);
      $letter = (string)(mdBasicFunction::retrieveLeters(6).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['emergencia_medica']);
      $letter = (string)(mdBasicFunction::retrieveLeters(7).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['horario']);
      $letter = (string)(mdBasicFunction::retrieveLeters(8).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['futuro_colegio']);
      $letter = (string)(mdBasicFunction::retrieveLeters(9).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['descuento']);
      $letter = (string)(mdBasicFunction::retrieveLeters(10).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['clase']);
      $letter = (string)(mdBasicFunction::retrieveLeters(11).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['p_nombre']);
      $letter = (string)(mdBasicFunction::retrieveLeters(12).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['direccion']);
      $letter = (string)(mdBasicFunction::retrieveLeters(13).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['telefono']);
      $letter = (string)(mdBasicFunction::retrieveLeters(14).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['celular']);
      $letter = (string)(mdBasicFunction::retrieveLeters(15).$index);
      $objPHPExcel->getActiveSheet()->setCellValue($letter, $row['mail']);
    }
    //var_dump($excel_data);
    //die;
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="alumnos'.date('dnY').'.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
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
