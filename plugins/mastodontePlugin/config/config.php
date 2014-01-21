<?php
//if (sfConfig::get('app_sfCaptchaGDPlugin_routes_register', true) && in_array('sfCaptchaGD', sfConfig::get('sf_enabled_modules')))
if (sfConfig::get('app_sfCaptchaGDPlugin_routes_register', true) && sfConfig::get('sf_plugins_captcha_available', false))
{
  $this->dispatcher->connect('routing.load_configuration', array('sfCaptchaGDRouting', 'listenToRoutingLoadConfigurationEvent'));
}
