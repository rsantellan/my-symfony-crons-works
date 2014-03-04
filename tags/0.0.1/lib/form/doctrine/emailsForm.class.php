<?php

/**
 * emails form.
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class emailsForm extends BaseemailsForm
{
  public function configure()
  {
    $this->widgetSchema['type'] = new sfWidgetFormInputHidden();
  }
}
