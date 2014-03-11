<?php

class mdValidatorEmail extends sfValidatorBase
{

    protected function configure($options = array(), $messages = array())
    {
        $this->addOption('duplicated');

        $this->addMessage('duplicated', 'email exist');
    }

    /**
    * @see sfValidatorBase
    */
    protected function doClean($value)
    {
      $response = Doctrine::getTable('mdUser')->findByEmail($value);

      if ($response->count() > 0)
      {
          throw new sfValidatorError($this, 'duplicated', array('value' => $value));
      }

      return true;
    }
}