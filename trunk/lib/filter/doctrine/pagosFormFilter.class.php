<?php

/**
 * pagos filter form.
 *
 * @package    jardin
 * @subpackage filter
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pagosFormFilter extends BasepagosFormFilter {

  private $dates = array();

  public function setup() {
    parent::setup();

    for ($i = 1980; $i <= (date('Y') + 5); $i++) {
      $this->dates[$i] = $i;
    }
  }

  public function configure() {
    parent::configure();
    
    $this->widgetSchema['referencia_bancaria'] = new sfWidgetFormFilterInput(array('with_empty' => false, 'label' => 'REF. BANCARIA'));    

    $this->widgetSchema['mes'] = new sfWidgetFormChoice(array('choices' => array('' => '', 1 => mdHelp::month(1), 2 => mdHelp::month(2), 3 => mdHelp::month(3), 4 => mdHelp::month(4), 5 => mdHelp::month(5), 6 => mdHelp::month(6), 7 => mdHelp::month(7), 8 => mdHelp::month(8), 9 => mdHelp::month(9), 10 => mdHelp::month(10), 11 => mdHelp::month(11), 12 => mdHelp::month(12))));
    //$this->validatorSchema['mes'] = new sfValidatorChoice(array('choices' => array(0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12), 'required' => false));    

    $this->widgetSchema['fecha'] = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(array('can_be_empty' => true, 'years' => $this->dates, 'format' => '%day%/%month%/%year%')), 'to_date' => new sfWidgetFormDate(array('can_be_empty' => true, 'years' => $this->dates, 'format' => '%day%/%month%/%year%')), 'with_empty' => false));

    $this->widgetSchema['price'] = new sfWidgetFormFilterInput(array('with_empty' => false, 'label' => 'Precio'));

    $this->widgetSchema['out_of_date'] = new sfWidgetFormChoice(array('choices' => array('' => 'si o no', 1 => 'si', 0 => 'no')));
    
    $this->validatorSchema['referencia_bancaria'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));
//new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => '%day%/%month%/%year%')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => '%day%/%month%/%year%')))),    
//$this->validatorSchema['fecha'] = new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59'))));
  }

  public function addReferenciaBancariaColumnQuery($query, $field, $value) {
    $value = $value['text'];
    $alias = $query->getRootAlias();
    if ($value != '')
      $query = $query->leftJoin($alias . ".usuario u")->addWhere("u.referencia_bancaria = '" . $value . "'");
    
    return $query;
  }

  public function getFields() {
    $fields = parent::getFields();
    $fields['referencia_bancaria'] = 'custom';
    return $fields;
  }

}
