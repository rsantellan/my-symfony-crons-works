<?php

/**
 * actividades form.
 *
 * @package    jardin
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class actividadesForm extends BaseactividadesForm
{
  public function configure()
  {
    parent::configure();
    unset($this['usuarios_list'], $this['md_news_letter_group_id']);
  }
}
