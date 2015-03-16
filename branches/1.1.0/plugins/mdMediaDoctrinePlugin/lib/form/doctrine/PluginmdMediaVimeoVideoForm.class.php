<?php

/**
 * PluginmdMediaVimeoVideo form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdMediaVimeoVideoForm extends BasemdMediaVimeoVideoForm
{
  public function setup()
  {
      parent::setup();
      unset($this['title'], $this['src'], $this['duration'], $this['description'], $this['avatar'], $this['avatar_width'], $this['avatar_height'], $this['author_name'], $this['author_url']);
  }
}
