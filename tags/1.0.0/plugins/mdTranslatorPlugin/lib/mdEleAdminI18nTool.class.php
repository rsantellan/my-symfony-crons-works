<?php
/**
 * mdEleAdminI18nTool
 * 
 * Se rescrible la clase sfEleAdminI18nTool de symfony para administrar los archivos con los nombres deseados.
 *
 *
 * @subpackage mdTraductor
 * @author     Rodrigo
 */
class mdEleAdminI18nTool {

  /**
   * Get module, action and caption of the message from its key
   *
   * @param string $key Key of the message item
   * @return array module, action, caption
   */

  public static function getModActFromKey($key)
  {
    $separator = sfConfig::get('app_sfEleAdminI18n_separator', '_');

    $items = explode($separator, $key, 3);

    // error - key does not include all params (action, module, caption)
    if (count($items) < 3) return false;

    return array('module' => $items[0], 'action' => $items[1], 'caption' => $items[2]);
  }

  /**
   * Make filename for xml catalogue
   *
   * @param string $lang Language
   * @param string $catalogue Catalogue
   * @return string Filename of the catalogue
   */
  public static function getFileForCatalogue($lang = false, $catalogue = 'messages')
  {
    if (!$lang) $lang = sfConfig::get('sf_i18n_default_culture');
    return $lang.'/'.$catalogue.'.xml';
  }

  public static function getErrorId($error)
  {
    if (is_array($error)) return $error['id'];

    return $error;
  }

  public static function getErrorArgs($error)
  {
    if (is_array($error))
    {
      unset($error['id']);
      return $error;
    }

    return null;
  }
} // class end
