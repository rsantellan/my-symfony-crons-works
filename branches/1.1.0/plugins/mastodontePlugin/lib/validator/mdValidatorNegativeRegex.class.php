<?php


/**
 * sfValidatorRegex validates a value with the negative of a regular expression.
 *
 * @package    mdBasicPlugin
 * @subpackage validator
 * @author     Rodrigo Santellan
 * @version    0.1
 */
class mdValidatorNegativeRegex extends sfValidatorString
{
  /**
   * Configures the current validator.
   *
   * Available options:
   *
   *  * pattern:    A regex pattern compatible with PCRE or {@link sfCallable} that returns one (required)
   *  * must_match: Whether the regex must match or not (true by default)
   *
   * @param array $options   An array of options
   * @param array $messages  An array of error messages
   *
   * @see sfValidatorString
   */
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);

    $this->addRequiredOption('pattern');
    $this->addOption('must_match', true);
  }

  /**
   * @see sfValidatorString
   */
  protected function doClean($value)
  {
    $clean = parent::doClean($value);

    $pattern = $this->getPattern();

    if (!(
      ($this->getOption('must_match') && !preg_match($pattern, $clean))
      ||
      (!$this->getOption('must_match') && preg_match($pattern, $clean))
    ))
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }

    return $clean;
  }

  /**
   * Returns the current validator's regular expression.
   *
   * @return string
   */
  public function getPattern()
  {
    $pattern = $this->getOption('pattern');

    return $pattern instanceof sfCallable ? $pattern->call() : $pattern;
  }
}
