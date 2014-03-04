<?php
/**
* sfExtraValidatorDatepickerTime validate datepicker time
*
* @author   David Zeller <zellerda01@gmail.com>
*/
class sfExtraValidatorDatepickerTime extends sfValidatorBase
{
    protected function configure($options = array(), $messages = array())
    {
        $this->addMessage('invalid', 'Date format not valid');
        $this->addMessage('max', 'The date must be before %max%.');
        $this->addMessage('min', 'The date must be after %min%.');

        $this->addOption('date_format', null);
        $this->addOption('with_time', true);
        $this->addOption('date_output', 'Y-m-d');
        $this->addOption('datetime_output', 'Y-m-d H:i:s');
        $this->addOption('date_format_error');
        $this->addOption('min', null);
        $this->addOption('max', null);
        $this->addOption('date_format_range_error', 'd/m/Y H:i:s');
    }

    /**
    * @see sfValidatorBase
    */
    protected function doClean($value)
    {
        if($value['hour'] == '')
        {
            $value['hour'] = '00';
        }
        
        if($value['minute'] == '')
        {
            $value['minute'] = '00';
        }
        
        $clean = strtotime($value['date'] . ' ' . $value['hour'] . ':' . $value['minute']);
        
        if($clean == '')
        {
            throw new sfValidatorError($this, 'invalid', array('value' => $value));
        }
        
        if ($this->hasOption('max') && $clean > $this->getOption('max'))
        {
            throw new sfValidatorError($this, 'max', array('value' => $value, 'max' => date($this->getOption('date_format_range_error'), $this->getOption('max'))));
        }

        if ($this->hasOption('min') && $clean < $this->getOption('min'))
        {
            throw new sfValidatorError($this, 'min', array('value' => $value, 'min' => date($this->getOption('date_format_range_error'), $this->getOption('min'))));
        }

        return $clean === $this->getEmptyValue() ? $clean : date($this->getOption('with_time') ? $this->getOption('datetime_output') : $this->getOption('date_output'), $clean);
    }
    
    protected function isEmpty($value)
    {
        if (is_array($value))
        {
            $filtered = array_filter($value);

            return empty($filtered);
        }

        return parent::isEmpty($value);
    }
}