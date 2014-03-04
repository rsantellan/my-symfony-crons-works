<?php

class mdFileCacheHandler {

	public static function getCacheFile($route, $options)
        {
            $cacheFileName = basename($route);

            $cachePath = sfConfig::get('sf_cache_dir') . '/images/web';

            $dirName = dirname($route);

            $cacheDir = str_replace(sfConfig::get ( 'sf_web_dir' ), $cachePath, $dirName);

            $codeName = '/' . $options['code'] . '_' . (isset($options['width']) ? $options['width'] : '') . 'X' . (isset($options['height']) ? $options['height'] : '');

            $cacheDir = MdFileHandler::checkDirectory($cacheDir . $codeName);

            return $cacheDir . $cacheFileName;
	}
	
	public static function removeCacheOfFile($route)
        {
            $cacheFileName = basename($route);

            $root = sfConfig::get ( 'sf_root_dir' ) . '/cache/images';

            $dirName = dirname($route);

            $cacheDir = str_replace(sfConfig::get ( 'sf_root_dir' ), $root, $dirName);

            $path = $cacheDir;

            self::findAndRemoveFile($path, $cacheFileName);
	}
	
	private static function findAndRemoveFile($path, $fileName)
        {
            if(is_dir($path))
            {
                //using the opendir function
                $dir_handle = @opendir($path) or die("Unable to open " . $path);

                //running the while loop
                while (false !== ($file = readdir($dir_handle)))
                {
                    if ($file != "." && $file != "..")
                    {
                        if (is_dir($path . '/' . $file))
                        {
                            self::findAndRemoveFile($path.'/'.$file, $fileName);
                        }
                        else
                        {
                            if($file == $fileName)
                            {
                                if (!unlink($path . '/' . $fileName))
                                {
                                    throw new Exception('image not deleted of cache', 150);
                                }
                            }
                        }
                    }
                }
                //closing the directory
                closedir($dir_handle);
            }
	}
}

