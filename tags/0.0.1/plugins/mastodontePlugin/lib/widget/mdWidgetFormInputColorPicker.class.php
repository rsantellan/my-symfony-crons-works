<?php

/**
 * 
 * @author Rodrigo Santellan
 **/ 
class mdWidgetFormInputColorPicker extends sfWidgetFormInput
{
    public function configure($options = array(), $attributes = array())
    {
        $this->addOption('value');
        parent::configure($options, $attributes);
    }
    
    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        $value = ($this->getOption('value') !== false || !$value || is_array($value)) ? $this->getOption('value') : $value;
        return parent::render($name, $value, $attributes, $errors) . javascript_tag(
        "$('#".$this->generateId($name)."').ColorPicker({
          color: '#".$value."',
          onSubmit: function(hsb, hex, rgb, el) {
            $(el).val(hex);
            $(el).ColorPickerHide();
          },
          onBeforeShow: function () {
            $(this).ColorPickerSetColor(this.value);
          },
          onChange: function (hsb, hex, rgb) {
            $('#".$this->generateId($name)."').css('backgroundColor', '#' + hex);
          }
        })
        .bind('keyup', function(){
          $(this).ColorPickerSetColor(this.value);
        }); $('#".$this->generateId($name)."').css('backgroundColor', '#".$value."');"
        );
    }
}
?>
