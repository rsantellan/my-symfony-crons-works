<?php


/**
 * mdValidatorNotEmail validates that is not a emails.
 *
 * @package    mdBasicPlugin
 * @subpackage validator
 * @author     Rodrigo Santellan
 * @version    0.1
 */
class mdValidatorNotEmail extends mdValidatorNegativeRegex
{
  const REGEX_EMAIL = '/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i';

  /**
   * @see sfValidatorRegex
   */
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);

    $this->setOption('pattern', self::REGEX_EMAIL);
  }
}
