<?php

sfApplicationConfiguration::getActive()->loadHelpers('Url');

class mdWidgetSelectAndAddMultipleChoices extends sfWidgetFormChoice {

    public function configure($options = array(), $attributes = array()){
        parent::configure($options, $attributes);
    }


    public function render($name, $value = null, $attributes = array(), $errors = array()){
        $response = sfContext::getInstance()->getResponse();
        $response->addJavascript('/mastodontePlugin/js/jquery.multiSelect-1.2.2/jquery.bgiframe.min.js');
        $response->addJavascript('/mastodontePlugin/js/jquery.multiSelect-1.2.2/jquery.multiSelect.js');
				$response->addJavascript('/mdAttributeDoctrinePlugin/js/mdWidgetSelectAndAddMultipleChoices.js');
        $response->addStylesheet('/mastodontePlugin/js/jquery.multiSelect-1.2.2/jquery.multiSelect.css');

        if(isset($attributes['class']))
        {
          $attributes['class'] = $attributes['class']." multiSelect";
        }
        else
        {
          $attributes['class'] = "multiSelect";
        }
				$js = '<script language="javascript"> if(typeof multiselectExistsAndIsUsable == "function"){multiselectExistsAndIsUsable();};</script>';

        return parent::render($name, $value, $attributes, $errors) . $js;
    }
}
