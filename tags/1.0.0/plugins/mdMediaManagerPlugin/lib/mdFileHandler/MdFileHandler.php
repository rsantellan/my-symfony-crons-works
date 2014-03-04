<?php

define('LOCAL_PATH', sfConfig::get('app_mdImageFileHandler_path', sfConfig::get('sf_upload_dir')));

class MdFileHandler {

    public static function getUrl($image, $width = NULL, $height = NULL){

        return url_for('@Images?file=' . $image . '&width=' . $width . '&height=' . $height);

    }

    public static $whiteList = array ('jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docx', 'xls', 'ppt', 'xlsx', 'pptx', 'flv', 'mpg', 'avi');
    
    /**
     * Sube una nueva imagen al servidor y devuelve el nombre de la misma
     *  maui: agrego funcionamiento. Si $kee_real_name, hace overwrite
     * @param <array> $FILES
     * @param <string> $path
     * @return <string>
     */
    public static function upload($FILES, $path = LOCAL_PATH, $keep_real_name = false){

        $POST_MAX_SIZE = ini_get ( 'post_max_size' );
        $unit = strtoupper ( substr ( $POST_MAX_SIZE, - 1 ) );
        $multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));
        
        if (( int ) $_SERVER ['CONTENT_LENGTH'] > $multiplier * ( int ) $POST_MAX_SIZE && $POST_MAX_SIZE) {

            throw new Exception('POST exceeded maximum allowed size.');

        }
        
        // Settings
        $save_path = self::checkPathFormat($path); //The path were we will save the file (getcwd() may not be reliable and should be tested in your environment)
        $upload_name = "upload";
        $max_file_size_in_bytes = 2147483647; // 2GB in bytes
        $extension_whitelist = self::$whiteList; // Allowed file extensions
        $valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-'; // Characters allowed in the file name (in a Regular Expression format)

        // Other variables
        $MAX_FILENAME_LENGTH = 260;
        $file_name = "";
        $file_extension = "";
        $uploadErrors = array (
                0 => "There is no error, the file uploaded with success",
                1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
                2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
                3 => "The uploaded file was only partially uploaded",
                4 => "No file was uploaded",
                6 => "Missing a temporary folder" );

        // Validate the upload
        if (! isset ( $FILES [$upload_name] )) {
            throw new Exception('No upload found in \$FILES for ' . $upload_name);
        } else if (isset ( $FILES [$upload_name] ["error"] ) && $FILES [$upload_name] ["error"] != 0) {
            throw new Exception($uploadErrors [$FILES[$upload_name]["error"]]);
        } else if (! isset ( $FILES [$upload_name] ["tmp_name"] ) || ! @is_uploaded_file ( $FILES [$upload_name] ["tmp_name"] )) {
            throw new Exception('Upload failed is_uploaded_file test.');
        } else if (! isset ( $FILES [$upload_name] ['name'] )) {
            throw new Exception('File has no name.');
        }

        // Validate the file size (Warning: the largest files supported by this code is 2GB)
        $file_size = @filesize ( $FILES [$upload_name] ["tmp_name"] );
        if (! $file_size || $file_size > $max_file_size_in_bytes) {
            throw new Exception('File exceeds the maximum allowed size');
        }

        if ($file_size <= 0) {
            throw new Exception('File size outside allowed lower bound');
        }

        // Validate file name (for our purposes we'll just remove invalid characters)
        $file_name = preg_replace ( '/[^' . $valid_chars_regex . ']|\.+$/i', "", basename ( $FILES [$upload_name] ['name'] ) );
        if (strlen ( $file_name ) == 0 || strlen ( $file_name ) > $MAX_FILENAME_LENGTH) {
            throw new Exception('Invalid file name');
        }

        // Validate that we won't over-write an existing file
        if (!$keep_real_name and file_exists ( $save_path . $file_name )) {
            throw new Exception('File with this name already exists');
        }

        // Validate file extension
        $path_info = pathinfo ( $FILES [$upload_name] ['name'] );
        $file_extension = $path_info ["extension"];
        $name = $FILES[$upload_name]['name'];
        //$path_info_file_name = $FILES[$upload_name]['filename'];
        if(!in_array(strtolower($file_extension), $extension_whitelist)){

            throw new Exception('Invalid file extension');

        }
        $file_name = $name;
        if(!$keep_real_name)
        {
            $randName = md5(rand() * time());
            $file_name = $randName . "." . $file_extension;
        }
        

        if (! @move_uploaded_file ( $FILES [$upload_name] ["tmp_name"], $save_path . $file_name )) {

            throw new Exception('File could not be saved.');

        }

        return $file_name;

    }

    public static function delete($filename,$path = LOCAL_PATH){
        if (!@unlink($path . $filename)){
        	throw new Exception('image not deleted');
        }else{
        	mdFileCacheHandler::removeCacheOfFile($path . $filename);
        }
    }

    /**
     *
     * @param <String> $image_name
     * @return <ImageInfo> array
     */
    public static function getListByName($path = LOCAL_PATH){
        if(is_null($path)){ throw new Exception('path is null or LOCAL_PATH in app.yml is null'); }
        $pics = self::getList($path);
        usort($pics,'cmpName');
        return $pics;
    }
    
    public static function getListByDate($path = LOCAL_PATH){
        if(is_null($path)){ throw new Exception('path is null or LOCAL_PATH in app.yml is null'); }
        $pics = self::getList($path);
        //print_r($pics);
        usort($pics,'cmpDate');
        //print_r('<hr/>');
        //print_r($pics);
        //die;
        return $pics;
    }

    public static function getFolders($path = LOCAL_PATH){
        $array = array();
        $path = self::checkPathFormat($path);
        if (is_dir($path)) {
            if ($dh = opendir($path)) {
                while (($file = readdir($dh)) !== false) {
                    if(is_dir($path . $file) AND $file != '.' AND $file != '..' AND $file != '.svn'){
                        array_push($array, $file);
                    }
                }
            }
        }
        return $array;
    }

    public static function getList($path = LOCAL_PATH){
        $array = array();
        $path = self::checkPathFormat($path);
        if (is_dir($path)) {
            if ($dh = opendir($path)) {
                while (($file = readdir($dh)) !== false) {

                    //echo '<br>Nombre de archivo:' . $file . ' : Es un: ' . filetype($path . $file);

                    if (is_dir($path . $file) AND $file != '.' AND $file != '..' AND $file != '.svn'){

                       //echo '<br>Directorio:' . $path . $file;
                       self::getList($path . $file . "/");

                    }else {

                        if($file != '.' AND $file != '..' AND $file != '.svn'){
                            
                            $mdFile = mdFileFactory::retrieveMdFile($path , $file);
                            if(!is_null($mdFile))
                            {
                              array_push($array, $mdFile);
                            }
                        }

                    }
                }
                closedir($dh);
            }
        }else{

            throw new Exception('invalid source');

        }
        return $array;
    }


    static public function checkPathFormat($path){
    	return self::checkDirectory($path);
    }
    
	public static function checkDirectory($path){
		if (is_dir($path)) {
            $last = $path[strlen($path)-1];
            if($last == '/'){
                return $path;
            }
			return $path.'/';
		}
        $cacheDir = sfConfig::get('sf_cache_dir');
        $rootDir = sfConfig::get('sf_root_dir');
        $webDir = sfConfig::get('sf_web_dir');
		$folders = $pieces = explode("/", $path);
		$smallPath = "/";
		foreach($folders as $key => $folder){
			$smallPath .= $folder;
            try{
                if (!is_dir($smallPath)) {
                    if(!mkdir($smallPath)) {
                        if (!is_dir($smallPath)) {
                            throw new Exception('Unable to create format directory');
                        }
                    }
                    chmod($smallPath,0775);
                }
            }catch(Exception $e){
                if(strlen($smallPath) > strlen($cacheDir) && strlen($smallPath) > strlen($rootDir) && strlen($smallPath) > strlen($webDir) ){
                    throw $e;
                }
            }

            $smallPath .= '/';

            
			
		}
		return $path.'/';
	}

}



function cmpDate($a, $b){
    if ($a->getLastModification() == $b->getLastModification()) {
        return 0;
    }
    
    if(sfConfig::get( 'sf_image_order_ascending', false ))
    {
        return ($a->getLastModification() < $b->getLastModification()) ? 1 : -1;
    }
    return ($a->getLastModification() < $b->getLastModification()) ? -1 : 1;

}

function cmpName($a, $b){

    if (strtoupper($a->getName()) == strtoupper($b->getName())) {
        return 0;
    }

    return (strtoupper($a->getName()) < strtoupper($b->getName())) ? -1 : 1;

}
