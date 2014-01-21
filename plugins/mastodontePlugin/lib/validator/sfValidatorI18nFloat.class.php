<?php

/**
 * Validate a number format input depending on its culture, ie:
 * fr_FR: 19,50 ==> 19.50
 * @author Simon Hostelet
 * @version 2009-09-16
 */
class sfValidatorI18nFloat extends sfValidatorBase
{
  protected function configure($options = array(), $messages = array())
  {
    $this->addMessage('max', '"%value%" must be less than %max%.');
    $this->addMessage('min', '"%value%" must be greater than %min%.');

    $this->setMessage('invalid', '"%value%" is not a valid float.');

    $this->addOption('min');
    $this->addOption('max');
  }

  protected function doClean($value)
  {
	$clean = self::I18nNumberToPhpNumber($value, sfContext::getInstance()->getUser()->getCulture());
	
    if(!is_numeric($clean))
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }

    if ($this->hasOption('max') && $clean > $this->getOption('max'))
    {
      throw new sfValidatorError($this, 'max', array('value' => $value, 'max' => $this->getOption('max')));
    }

    if ($this->hasOption('min') && $clean < $this->getOption('min'))
    {
      throw new sfValidatorError($this, 'min', array('value' => $value, 'min' => $this->getOption('min')));
    }

    return $clean;
  }

  /**
   * Check what are the decimal and thousand separators for the current culture.
   * Replace these separators with PHP compatible ones.
   * @param $number float
   * @param $culture  string
   * @return float PHP-cleaned
   */
  static public function I18nNumberToPhpNumber($number, $culture = 'en')
  {
    $numberFormatInfo = sfNumberFormatInfo::getInstance($culture);
    
    $number = str_replace($numberFormatInfo->getGroupSeparator(), '', $number);
    $number = str_replace($numberFormatInfo->getDecimalSeparator(), '.', $number);
	return $number;
  }
}
