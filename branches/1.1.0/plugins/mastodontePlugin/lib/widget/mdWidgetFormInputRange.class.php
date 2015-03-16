<?php

class mdWidgetFormInputRange extends sfWidgetForm
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('from_value');
    $this->addRequiredOption('to_value');

    $this->addOption('template', 'from %from_value% to %to_value%');
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $values = array_merge(array('from' => '', 'to' => '', 'is_empty' => ''), is_array($value) ? $value : array());

    return strtr($this->translate($this->getOption('template')), array(
      '%from_value%'      => $this->getOption('from_value')->render($name.'[from]', $value['from']),
      '%to_value%'        => $this->getOption('to_value')->render($name.'[to]', $value['to']),
    ));
  }

  public function getStylesheets()
  {
    return array_unique(array_merge($this->getOption('from_value')->getStylesheets(), $this->getOption('to_value')->getStylesheets()));
  }

  public function getJavaScripts()
  {
    return array_unique(array_merge($this->getOption('from_value')->getJavaScripts(), $this->getOption('to_value')->getJavaScripts()));
  }
}
