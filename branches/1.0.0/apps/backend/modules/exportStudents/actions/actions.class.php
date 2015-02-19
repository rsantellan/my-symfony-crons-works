<?php

/**
 * exportStudents actions.
 *
 * @package    jardin
 * @subpackage exportStudents
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class exportStudentsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new exportarUsuariosForm();
    $this->headers = array();
    $this->data = array();
    if ($request->isMethod('post'))
    {
        $parameters = $request->getParameter($this->form->getName());
        $this->form->bind($parameters);
        //var_dump($parameters);
        $data = $this->generateData($parameters);
        $this->headers = $data['headers'];
        $this->data = $data['data'];
    }
  }
  
  private function generateData($parameters)
  {
      $alumnos = $this->alumnosData($parameters['clase'], $parameters['horario']);
      $returnData = array();
      $useAllHeaders = false;
      $headers = $this->fullHeaders();
      if(!isset($parameters['alumnos']) && !isset($parameters['padres']))
      {
          $useAllHeaders = true;
      }
      else
      {
          $auxHeaders = array();
          if(isset($parameters['alumnos']))
          {
              foreach($parameters['alumnos'] as $headerAlumno)
              {
                  $auxHeaders[$headerAlumno] = $headers[$headerAlumno];
              }
          }
          if(isset($parameters['padres']))
          {
              foreach($parameters['padres'] as $headerPadre)
              {
                  $auxHeaders[$headerPadre] = $headers[$headerPadre];
              }
          }
          $headers = $auxHeaders;
      }
      
      foreach($alumnos as $alumno)
      {
          $fullData = array_merge($alumno, $this->parentData($alumno['id']));
          if(!$useAllHeaders)
          {
              $aux = array();
              foreach($headers as $key => $value)
              {
                  $aux[$key] = $fullData[$key];
              }
              $fullData = $aux;
          }
          $returnData[$alumno['id']] = $fullData;
      }
      if($parameters['exportar'] == "1")
      {
          $fileName = 'alumnos-'.date('d-m-Y').'.csv';
          header("Content-disposition: attachment; filename=".$fileName);
          header("Content-Type: text/csv");
          $out = fopen('php://output', 'w');
          fputcsv($out, $headers);
          foreach($returnData as $alumno)
          {
              //var_dump($alumno);
                fputcsv($out, $alumno);
          }
          
          fclose($out);
          die;
      }
      else
      {
          return array(
            'headers' => $headers,
            'data' => $returnData,
            );
      }
      
      //var_dump($returnData);
  }
  
  private function fullHeaders()
  {
      return array(
        'nombre' => 'Nombre',
        'apellido' => 'Apellido',
        'fecha_nacimiento' => 'Fecha Nacimiento',
        'anio_ingreso' => 'Año de ingreso',
        'sociedad' => 'Sociedad',
        'referencia_bancaria' => 'Referencia',
        'emergencia_medica' => 'Emergencia Medica',
        'horario' => 'Horario',
        'futuro_colegio' => 'Futuro Colegio',
        'clase' => 'clase',
        'padre' => 'padre',
        'direccion' => 'Dirección',
        'telefono' => 'Teléfono',
        'celular' => 'Celular',
        'mail' => 'Correo Electronico',
      );
  }
  
  private function alumnosData($clase = '', $horario = '')
  {
      $sqlBasico = 'select id, nombre, apellido, fecha_nacimiento, anio_ingreso, sociedad, referencia_bancaria, emergencia_medica ,horario ,futuro_colegio ,clase from usuario where egresado = 0';
      $parameters = array();
      if($clase != '')
      {
          $sqlBasico .= ' and clase = ?';
          $parameters[] = $clase;
      }
      if($horario != '')
      {
          $sqlBasico .= ' and horario = ?';
          $parameters[] = $horario;
      }
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      return $q->fetchAssoc($sqlBasico, $parameters);
  }
  
  private function parentData($alumnoId)
  {
      $sql = 'select nombre as padre, direccion, telefono, celular, mail from progenitor left join usuario_progenitor on progenitor_id = id where usuario_id = ?';
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      $parents = $q->fetchAssoc($sql, array($alumnoId));
      $returnData = array();
      foreach($parents as $parent)
      {
          foreach($parent as $key => $value)
          {
              if(isset($returnData[$key]))
              {
                  $returnData[$key] = $returnData[$key] . ', ' . $value;
              }
              else
              {
                  $returnData[$key] = $value;
              }    
          }
          
      }
      return $returnData;
  }
}
