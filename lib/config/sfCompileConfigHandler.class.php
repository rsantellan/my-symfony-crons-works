<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * (c) 2004-2006 Sean Kerr <sean@code-box.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfCompileConfigHandler gathers multiple files and puts them into a single file.
 * Upon creation of the new file, all comments and blank lines are removed.
 *
 * @package    symfony
 * @subpackage config
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Sean Kerr <sean@code-box.org>
 * @version    SVN: $Id$
 */
class sfCompileConfigHandler extends sfYamlConfigHandler
{
  /**
   * Executes this configuration handler.
   *
   * @param array $configFiles An array of absolute filesystem path to a configuration file
   *
   * @return string Data to be written to a cache file
   *
   * @throws sfConfigurationException If a requested configuration file does not exist or is not readable
   * @throws sfParseException If a requested configuration file is improperly formatted
   */
  public function execute($configFiles)
  {
    // parse the yaml
    $config = self::getConfiguration($configFiles);

    // init our data
    $data = '';

    // let's do our fancy work
    foreach ($config as $file)
    {
      if (!is_readable($file))
      {
        // file doesn't exist
        throw new sfParseException(sprintf('Configuration file "%s" specifies nonexistent or unreadable file "%s".', $configFiles[0], $file));
      }

      $contents = file_get_contents($file);

      // strip comments (not in debug mode)
      if (!sfConfig::get('sf_debug'))
      {
        $contents = sfToolkit::stripComments($contents);
      }

      // strip php tags
      $contents = sfToolkit::pregtr($contents, array('/^\s*<\?(php\s*)?/m' => '', '/^\s*\?>/m' => ''));

      // replace windows and mac format with unix format
      $contents = str_replace("\r", "\n", $contents);

      // replace multiple new lines with a single newline
      $contents = preg_replace(array('/\s+$/Sm', '/\n+/S'), "\n", $contents);

      // append file data
      $data .= "\n".$contents;
    }

    // compile data
    return sprintf("<?php\n".
                      "// auto-generated by sfCompileConfigHandler\n".
                      "// date: %s\n".
                      "%s\n",
                      date('Y/m/d H:i:s'), $data);
  }

  /**
   * @see sfConfigHandler
   */
  static public function getConfiguration(array $configFiles)
  {
    $config = array();
    foreach ($configFiles as $configFile)
    {
      $config = array_merge($config, self::parseYaml($configFile));
    }

    return self::replacePath(self::replaceConstants($config));
  }
}
