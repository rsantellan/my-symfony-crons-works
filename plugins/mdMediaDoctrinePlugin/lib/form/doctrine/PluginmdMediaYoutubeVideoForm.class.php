<?php

/**
 * PluginmdMediaYouTubeVideo form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdMediaYoutubeVideoForm extends BasemdMediaYoutubeVideoForm
{
  public function setup()
  {
      parent::setup();
      unset($this['code'], $this['duration'], $this['name'], $this['path'], $this['avatar']);

      $this->widgetSchema ['description'] = new sfWidgetFormTextarea();
  }
}
