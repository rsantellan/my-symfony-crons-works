<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sfWidgetDatepicker
 *
 * Necesitamos incluir el javascript para el idioma que usamos:
 * mastodontePlugin/web/js/jquery-ui-1.8.4/development-bundle/ui/i18n/jquery.ui.datepicker-es.js'
 *
 * @author pablo
 */
class  sfWidgetFormInputDatepicker extends sfWidgetFormInput
{
    public function configure($options = array(), $attributes = array())
    {
        $this->addOption('culture', sfContext::getInstance()->getUser()->getCulture());
        $this->addOption('time', array());
        $this->addOption('useTimeWidget', false);
        $this->addOption('value');
        $this->addOption('dateFormat', "yy-mm-dd");
        $this->addOption('calendar', "/mastodontePlugin/images/calendar.gif");
        parent::configure($options, $attributes);
    }

    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        $attributes['class'] = 'datepicker widget_datepicker_size';

        $js = '<script>
                $(function(){
                    $( ".datepicker" ).datepicker({
                        showOn: "button",
                        buttonImage: "'.$this->getOption('calendar').'",
                        buttonImageOnly: true,
                        dateFormat: "'.$this->getOption('dateFormat').'"
                    });
                });
               </script>';
        if(is_null($value) && !is_null($this->getOption('value')))
        {
            $value = $this->getOption('value');
        }
        $value_date = '';
        //print_r($value);
        //print_r("<br/>");
        if (is_array($value))
        {
            $value_date = $value['date'];
        }
        elseif(!is_null($value) && $value != '')
        {
            $value_date = (string) $value == (string) (integer) $value ? (integer) $value : strtotime($value);
            //print_r($value_date);
            //print_r("<br/>");
            //print_r(date('Y-m-d', $value_date));
            //print_r("<br/>");
            //$value_date = format_date(date('Y-m-d', $value_date), $this->getOption('dateFormat'));
            $value_date = date('Y-m-d', $value_date);
            //print_r($value_date);
        }


        $timeWidget = '';
        if($this->getOption('useTimeWidget')){
            $timeWidget = $this->getTimeWidget($attributes)->render($name, $value);
        }

        return parent::render($name . '[date]', $value_date, $attributes, $errors).' ' .$timeWidget . $js;
    }

    protected function getTimeWidget($attributes = array())
    {
        return new sfWidgetFormI18nTime(array_merge(array('culture' => $this->getOption('culture')), $this->getOptionsFor('time')), $this->getAttributesFor('time', $attributes));
    }

    protected function getOptionsFor($type)
    {
        $options = $this->getOption($type);
        if (!is_array($options))
        {
            throw new InvalidArgumentException(sprintf('You must pass an array for the %s option.', $type));
        }

        return $options;
    }

    protected function getAttributesFor($type, $attributes)
    {
        $defaults = isset($this->attributes[$type]) ? $this->attributes[$type] : array();

        return isset($attributes[$type]) ? array_merge($defaults, $attributes[$type]) : $defaults;
    }

}