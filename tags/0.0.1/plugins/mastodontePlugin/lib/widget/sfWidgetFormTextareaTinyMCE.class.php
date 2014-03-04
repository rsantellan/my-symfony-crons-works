<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormTextareaTinyMCE represents a Tiny MCE widget.
 *
 * You must include the Tiny MCE JavaScript file by yourself.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormTextareaTinyMCE.class.php 17192 2009-04-10 07:58:29Z fabien $
 */
class sfWidgetFormTextareaTinyMCE extends sfWidgetFormTextarea
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * theme:  The Tiny MCE theme
   *  * width:  Width
   *  * height: Height
   *  * config: The javascript configuration
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('theme', 'advanced');
    $this->addOption('width');
    $this->addOption('height');
    $this->addOption('config', '');
    $this->addOption("showTiny");
    
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $showTiny = $this->getOption('showTiny');
    if($this->getOption('showTiny') !== null and $this->getOption('showTiny') !== false)
    {
      $showTiny = true;
    }
    else
    {
      $showTiny = false;
    }
    if(isset($attributes['showTiny']))
    {
        $showTiny = true;
    }
    if(!$showTiny)
    {
        $showTiny = sfConfig::get( 'sf_plugins_always_auto_launch_tiny_mce', false );
    }
    $attributes['showTiny'] = $showTiny;

    $textarea = parent::render($name, $value, $attributes, $errors);

    $id = $this->generateId($name);

    if( $showTiny )
    {
    $js = sprintf(<<<EOF
<script type="text/javascript">
  tinyMCE.init({
    mode:                              "exact",
    elements:                          "%s",
    theme:                             "%s",
    %s
    %s
    theme_advanced_toolbar_location:   "top",
    forced_root_block : "",
    theme_advanced_toolbar_align:      "left",
    theme_advanced_statusbar_location: "bottom",
    relative_urls : false,
    theme_advanced_resizing:           true
    %s
  });
</script>
EOF
    ,
      $this->generateId($name),
      $this->getOption('theme'),
      $this->getOption('width')  ? sprintf('width:                             "%spx",', $this->getOption('width')) : '',
      $this->getOption('height') ? sprintf('height:                            "%spx",', $this->getOption('height')) : '',
      $this->getOption('config') ? ",\n".$this->getOption('config') : ''
    );
    return $textarea.$js;
    
    }
    else
    {

    $js = sprintf(<<<EOF
<script type="text/javascript">
  function initTinyMCE$id(){
  tinyMCE.init({
    mode:                              "exact",
    elements:                          "%s",
    theme:                             "%s",
    %s
    %s
    theme_advanced_toolbar_location:   "top",
    forced_root_block : "",
    theme_advanced_toolbar_align:      "left",
    init_instance_callback:            "myCustomInitInstance",
    theme_advanced_statusbar_location: "bottom",
    relative_urls : false,
    theme_advanced_resizing:           true
    %s
  });
  }
function myCustomInitInstance(inst) {
        mdHideLoading();
}
</script>
EOF
    ,
      $this->generateId($name),
      $this->getOption('theme'),
      $this->getOption('width')  ? sprintf('width:                             "%spx",', $this->getOption('width')) : '',
      $this->getOption('height') ? sprintf('height:                            "%spx",', $this->getOption('height')) : '',
      $this->getOption('config') ? ",\n".$this->getOption('config') : ''
    );
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
    $texto = __("tinymce_agregar formato");
    $launcher = "<label id='".$id."_show_label' style='color: gray; font-size:10px!important'>".$texto."</label>";
    $launcher .= "<a href='javascript:void(0)' id='".$id."_show_editor' onclick='initTinyMCE$id();mdShowLoading();$(\"#".$id."_show_label\").hide();$(this).hide();$(\"#".$id."_remove_label\").show();$(\"#".$id."_remove_editor\").show();'> <image src='/mastodontePlugin/images/application_edit.png' alt='start tinyMCE'/></a>";
    $texto = __("tinymce_sacar formato");
    $launcher .= "<label id='".$id."_remove_label' style='display:none;color: gray; font-size:10px!important'>".$texto."</label>";    
    $launcher .= "<a href='javascript:void(0)' id='".$id."_remove_editor' onclick='tinyMCE.execCommand(\"mceRemoveControl\", true, \"$id\");$(\"#".$id."_show_label\").show();$(this).hide();$(\"#".$id."_remove_label\").hide();$(\"#".$id."_show_editor\").show();' style='display:none'> <image src='/mastodontePlugin/images/application_edit.png' alt='start tinyMCE'/></a><div class='clear'></div>";
    return $launcher.$textarea.$js;

    }

  }
}
