<?php
class sfWidgetCaptchaGD extends sfWidgetForm
{
  protected function configure($options = array(), $attributes = array())
  {
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $context = sfContext::getInstance();
    $url = $context->getRouting()->generate("sf_captchagd");
    $value = $context->getRequest()->getPostParameter('captcha');
    $attributes = array_merge($attributes, array('class' => 'captcha'));
    $src = $url . "?" . time();
    $srcReload = "'" . $url . "?r= ' + Math.random() + '&reload=1'";
        
    return sprintf('
        <div id="md_captcha">
            <div class="imagen">
                <a href="" onclick="return false" title="%s"><img border="0" src="%s" onclick="this.src=%s" class="captcha"></a>
            </div>
            <div class="ingresodecodigo">
                <b>' . __("Captcha_Ingrese el código de la imagen") . '</b><br>' . __("Captcha_Si no lo entiende haga click sobre ella") . '
            </div>', __("Captcha_Reload image"), $src, $srcReload) . $this->renderTag('input', array_merge(array('type' => 'text', 'name' => $name, 'value' => $value), $attributes)) .
        '</div>';
  }
}
