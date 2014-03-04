<?php

class mdBasicFunction {

  /**
   *
   * @param sfWebResponse $response
   * @param array $metas
   * @return 
   */
  public static function setMetaTags($response, $metas) {
    $lang = sfContext::getInstance()->getI18N();
    foreach ($metas as $key => $value) {
      if (gettype($value) == 'array') {
        $lang_key = $value[0];
        $params = $value[1];
      } else {
        $lang_key = $value;
        $params = null;
      }
      if ($lang->__($lang_key) != $lang_key) {
        if ($key == 'title') {
          $response->setTitle($lang->__($lang_key, $params));
        } else {
          $response->addMeta($key, $lang->__($lang_key, $params));
        }
      }
    }
  }

  /**
   *
   * @param boolean $response
   * @param array $options
   * @return json response
   */
  public static function basic_json_response($response, $options) {
    return json_encode(array(
      "response" => ($response ? "OK" : "ERROR"),
      "options" => $options
    ));
  }

  /**
   * Function to turn a mysql datetime (YYYY-MM-DD HH:MM:SS) into a unix timestamp
   * @param str
   * The string to be formatted
   * @author Rodrigo Santellan
   */
  public static function convert_datetime($str) {

    list ( $date, $time ) = explode(' ', $str);
    list ( $year, $month, $day ) = explode('-', $date);
    list ( $hour, $minute, $second ) = explode(':', $time);

    $timestamp = mktime($hour, $minute, $second, $month, $day, $year);

    return $timestamp;
  }

  /**
   * retorna la url del request actual
   *
   * @param bool $absolute	false
   * @return string
   * @author maui .-
   */
  static public function getCurrentURL($absolute = false) {
    $context = sfContext::getInstance();
    $routing = $context->getRouting();
    $uri = $routing->getCurrentInternalUri();
    $url = $context->getController()->genUrl($uri, $absolute);
    return $url;
  }

  /**
   * Checks if a partial exists
   *
   * @param string $templateName		the partial's name, with or without the module ('module/partial')
   *
   * @return bool
   */
  public static function partialExists($templateName) {
    $context = sfContext::getInstance();

    // is the partial in another module?
    if (false !== $sep = strpos($templateName, '/')) {
      $moduleName = substr($templateName, 0, $sep);
      $templateName = substr($templateName, $sep + 1);
    } else {
      $moduleName = $context->getActionStack()->getLastEntry()->getModuleName();
    }

    //We need to fetch the module's configuration to know which View class to use,
    // then we'll have access to information such as the extension
    $config = sfConfig::get('mod_' . strtolower($moduleName) . '_partial_view_class');
    if (empty($config)) {
      require($context->getConfigCache()->checkConfig('modules/' . $moduleName . '/config/module.yml', true));
      $config = sfConfig::get('mod_' . strtolower($moduleName) . '_partial_view_class', 'sf');
    }
    $class = $config . 'PartialView';
    $view = new $class($context, $moduleName, $templateName, '');

    $templateName = '_' . $templateName . $view->getExtension();

    //We now check if the file exists and is readable
    $directory = $context->getConfiguration()->getTemplateDir($moduleName, $templateName);

    if ($directory) {
      return true;
    }

    return false;
  }

  /**
   * The letter l (lowercase L) and the number 1
   * have been removed, as they can be mistaken
   * for each other.
   * @author Rodrigo Santellan
   */
  public static function createRandomPassword() {
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double) microtime() * 1000000);
    $i = 0;
    $pass = '';
    while ($i <= 7) {
      $num = rand() % 33;
      $tmp = substr($chars, $num, 1);
      $pass = $pass . $tmp;
      $i++;
    }
    return $pass;
  }

  /**
   * 		Validate an email address.
   * 		Provide email address (raw input)
   * 	 Returns true if the email address has the email
   * 	 address format and the domain exists.
   * 	 Para el siguiente caso se saco la comprobacion del dominio.
   *   @author: http://www.linuxjournal.com/article/9585?page=0,3
   */
  public static function validEmail($email) {
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
      $isValid = false;
    } else {
      $domain = substr($email, $atIndex + 1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64) {
        // local part length exceeded
        $isValid = false;
      } else if ($domainLen < 1 || $domainLen > 255) {
        // domain part length exceeded
        $isValid = false;
      } else if ($local [0] == '.' || $local [$localLen - 1] == '.') {
        // local part starts or ends with '.'
        $isValid = false;
      } else if (preg_match('/\\.\\./', $local)) {
        // local part has two consecutive dots
        $isValid = false;
      } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
        // character not valid in domain part
        $isValid = false;
      } else if (preg_match('/\\.\\./', $domain)) {
        // domain part has two consecutive dots
        $isValid = false;
      } else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
        // character not valid in local part unless
        // local part is quoted
        if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
          $isValid = false;
        }
      }
      /* if ($isValid && ! (checkdnsrr ( $domain, "MX" ) || checkdnsrr ( $domain, "A" ))) {
        // domain not found in DNS
        $isValid = false;
        } */
    }
    return $isValid;
  }

  static public function str_hex($string) {
    $hex = '';
    for ($i = 0; $i < strlen($string); $i++) {
      $hex .= dechex(ord($string[$i]));
    }
    return $hex;
  }

  static public function hex_str($hex) {
    $string = '';
    for ($i = 0; $i < strlen($hex) - 1; $i+=2) {
      $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
    }
    return $string;
  }

  static public function i18n_value_replace($value, $culture = 'en') {
    if (is_numeric($value)) {
      switch ($culture) {
        case 'es': $format = number_format($value, 2, ',', '');
          break;
        default: $format = number_format($value, 2, '.', '');
          break;
      }
    } else {
      $format = $value;
    }

    return $format;
  }

  /**
   *
   * @author Rodrigo Santellan
   * @author maui .- le di soporte para caracteres en español
   * */
  static public function slugify($text, $separator = 'dash', $lowercase = TRUE) {
    $text = strip_tags($text);
    $text = preg_replace("`\[.*\]`U", "", $text);
    $text = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $text);
    $text = htmlentities($text, ENT_COMPAT, 'utf-8');
    $text = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i", "\\1", $text);
    $text = preg_replace(array("`[^a-z0-9]`i", "`[-]+`"), "-", $text);

    if ($lowercase === TRUE) {
      $text = strtolower($text);
    }

    if ($separator != 'dash') {
      $text = str_replace('-', '_', $text);
      $separator = '_';
    } else {
      $separator = '-';
    }

    return trim($text, $separator);
  }

  /**
   *
   * @author Rodrigo Santellan
   * */
  static function get_file_extension($file_name) {
    return substr(strrchr($file_name, '.'), 1);
  }

  /**
   *
   * @author Rodrigo Santellan
   * */
  static function get_file_name($file_name) {
    return substr($file_name, 0, strrpos($file_name, '.'));
    //return substr(strrchr($file_name,'.'),0);
  }

  /**
   *
   * @author Rodrigo Santellan
   * */
  static function addDayToDate($date, $days) {
    $date = strtotime(date('Y-m-d H:i:s', strtotime($date)) . " +" . $days . " day");
    return $date;
  }

  /**
   *
   * @author Rodrigo Santellan
   * */
  static function addWeekToDate($date, $weeks) {
    $date = strtotime(date('Y-m-d H:i:s', strtotime($date)) . " +" . $weeks . " week");
    return $date;
  }

  /**
   *
   * @author Rodrigo Santellan
   * */
  static function addMonthToDate($date, $months) {
    $date = strtotime(date('Y-m-d H:i:s', strtotime($date)) . " +" . $months . " month");
    return $date;
  }

  public static function emptyForm($values) {
    $return = true;
    if (!is_array($values)) {
      return true;
    }
    foreach ($values as $key => $val) {
      if ($key !== '_csrf_token') {
        if (is_array($val)) {
          $return = $return && mdBasicFunction::emptyForm($val);
        } else {
          if ($val != "" || $val != 0) {
            $return = false;
          }
        }
      }
    }
    return $return;
  }

  public static function retrieveAllCountriesArray($addEmptyOne = false, $country = null, $useCulture = false, $culture = 'es') {
    $culture = sfContext::getInstance()->getUser()->getCulture();

    $countries = sfCultureInfo::getInstance($culture)->getCountries($country);

    $list = array();
    if ($addEmptyOne) {

      $list[""] = "";
      foreach ($countries as $key => $val) {
        $list[$key] = $val;
      }
      return $list;
    } else {
      return $countries;
    }

    print_r($countries);
  }

  public static function retrieveLeters($index) {
    $abc = array();
    $abc[0] = "A";
    $abc[1] = "B";
    $abc[2] = "C";
    $abc[3] = "D";
    $abc[4] = "E";
    $abc[5] = "F";
    $abc[6] = "G";
    $abc[7] = "H";
    $abc[8] = "I";
    $abc[9] = "J";
    $abc[10] = "K";
    $abc[11] = "L";
    $abc[12] = "M";
    $abc[13] = "N";
    $abc[14] = "O";
    $abc[15] = "P";
    $abc[16] = "Q";
    $abc[17] = "R";
    $abc[18] = "S";
    $abc[19] = "T";
    $abc[20] = "U";
    $abc[21] = "V";
    $abc[22] = "W";
    $abc[23] = "Y";
    $abc[24] = "X";
    $abc[25] = "Z";
    while ($index > 25) {
      $index = $index - 25;
    }
    return $abc[$index];
  }

  /**
   * Calcula la edad dado un string.
   * El string tiene que tener el siguiente formato dd-mm-yyyy o dd/mm/yyyy
   * @param String $string
   */
  public static function calculateAge($string, $inverso = true) {
    $dia = date("j");
    $mes = date("n");
    $anno = date("Y");
    //fecha_nac ="1973/06/01";
    if ($inverso) {
      $anno_nac = substr($string, 0, 4);
      $mes_nac = substr($string, 5, 2);
      $dia_nac = substr($string, 8, 2);
    } else {
      $dia_nac = substr($string, 0, 2);
      $mes_nac = substr($string, 3, 2);
      $anno_nac = substr($string, 6, 4);
    }

    if ($mes_nac > $mes) {
      $calc_edad = $anno - $anno_nac - 1;
    } else {
      if ($mes == $mes_nac AND $dia_nac > $dia) {
        $calc_edad = $anno - $anno_nac - 1;
      } else {
        $calc_edad = $anno - $anno_nac;
      }
    }
    return $calc_edad;
  }

  /**
   * Compara dos fechas y devuelve:
   * 0 en caso de ser iguales,
   * 1 si fecha1 es menor que fecha2
   * -1 si fecha1 es mayor que fecha2
   *
   * @param <Date> Formato: 2011-03-21 17:01:00 $fecha1
   * @param <Date> Formato: 2011-03-21 17:01:00 $fecha2
   */
  public static function compareDates($fecha1, $fecha2) {
    try {
      //Obtenemos los valores de la fecha por separado
      $fecha1 = new DateTime($fecha1);
      $day = $fecha1->format('d');
      $month = $fecha1->format('m');
      $year = $fecha1->format('Y');
      $hour = $fecha1->format('H');
      $minute = $fecha1->format('i');
      $second = $fecha1->format('s');
      $date_1 = mktime($hour, $minute, $second, $month, $day, $year);

      $fecha2 = new DateTime($fecha2);
      $day = $fecha2->format('d');
      $month = $fecha2->format('m');
      $year = $fecha2->format('Y');
      $hour = $fecha2->format('H');
      $minute = $fecha2->format('i');
      $second = $fecha2->format('s');
      $date_2 = mktime($hour, $minute, $second, $month, $day, $year);

      if ($date_1 == $date_2)
        return 0;
      if ($date_1 > $date_2)
        return -1;
      if ($date_1 < $date_2)
        return 1;
    } catch (Exception $e) {

      return false;
    }
  }

  /**
   * Devuelve la diferencia de segundos que hay entre $fecha1 y $fecha2
   * sino devuelve -1
   * pre: $fecha2 debe ser mayor que $fecha1
   *
   *
   * @param <Date> Formato: 2011-03-21 17:01:00 $fecha1
   * @param <Date> Formato: 2011-03-21 17:01:00 $fecha2
   * @return <int>
   */
  public static function time_difference($fecha1, $fecha2) {
    try {

      //Obtenemos los valores de la fecha1 por separado
      $fecha1 = new DateTime($fecha1);
      $day = $fecha1->format('d');
      $month = $fecha1->format('m');
      $year = $fecha1->format('Y');
      $hour = $fecha1->format('H');
      $minute = $fecha1->format('i');
      $second = $fecha1->format('s');

      //Obtenemos la cantidad de segundos para esa fecha
      $date_1 = mktime($hour, $minute, $second, $month, $day, $year);

      //Obtenemos los valores de la fecha2 por separado
      $fecha2 = new DateTime($fecha2);
      $day = $fecha2->format('d');
      $month = $fecha2->format('m');
      $year = $fecha2->format('Y');
      $hour = $fecha2->format('H');
      $minute = $fecha2->format('i');
      $second = $fecha2->format('s');

      //Obtenemos la cantidad de segundos para esa fecha
      $date_2 = mktime($hour, $minute, $second, $month, $day, $year);

      if ($date_2 >= $date_1)
        return $date_2 - $date_1;
      return -1;
    } catch (Exception $e) {

      return false;
    }
  }

  /**
   * Encodea un string para ser usado en XML
   * @param <string> $str
   * @return <string>
   */
  public static function xmlEntities($str) {
    $xml = array('&#34;', '&#38;', '&#38;', '&#60;', '&#62;', '&#160;', '&#161;', '&#162;', '&#163;', '&#164;', '&#165;', '&#166;', '&#167;', '&#168;', '&#169;', '&#170;', '&#171;', '&#172;', '&#173;', '&#174;', '&#175;', '&#176;', '&#177;', '&#178;', '&#179;', '&#180;', '&#181;', '&#182;', '&#183;', '&#184;', '&#185;', '&#186;', '&#187;', '&#188;', '&#189;', '&#190;', '&#191;', '&#192;', '&#193;', '&#194;', '&#195;', '&#196;', '&#197;', '&#198;', '&#199;', '&#200;', '&#201;', '&#202;', '&#203;', '&#204;', '&#205;', '&#206;', '&#207;', '&#208;', '&#209;', '&#210;', '&#211;', '&#212;', '&#213;', '&#214;', '&#215;', '&#216;', '&#217;', '&#218;', '&#219;', '&#220;', '&#221;', '&#222;', '&#223;', '&#224;', '&#225;', '&#226;', '&#227;', '&#228;', '&#229;', '&#230;', '&#231;', '&#232;', '&#233;', '&#234;', '&#235;', '&#236;', '&#237;', '&#238;', '&#239;', '&#240;', '&#241;', '&#242;', '&#243;', '&#244;', '&#245;', '&#246;', '&#247;', '&#248;', '&#249;', '&#250;', '&#251;', '&#252;', '&#253;', '&#254;', '&#255;');
    $html = array('&quot;', '&amp;', '&amp;', '&lt;', '&gt;', '&nbsp;', '&iexcl;', '&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&shy;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;', '&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;');
    $str = str_replace($html, $xml, $str);
    //$str = str_ireplace($html,$xml,$str);
    return $str;
  }

  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

  public static function mdTruncateText($string, $limit, $break=" ", $pad="...") {
    // return with no change if string is shorter than $limit
    if (strlen($string) <= $limit)
      return $string;

    $string = substr($string, 0, $limit);
    if (false !== ($breakpoint = strrpos($string, $break))) {
      $string = substr($string, 0, $breakpoint);
    }

    return $string . $pad;
  }

  public static function objectToArray($d) {
    if (is_object($d)) {
      // Gets the properties of the given object
      // with get_object_vars function
      $d = get_object_vars($d);
    }

    if (is_array($d)) {
      /*
       * Return array converted to object
       * Using __FUNCTION__ (Magic constant)
       * for recursive call
       */
      return array_map(array('mdBasicFunction', __FUNCTION__), $d);
    } else {
      // Return array
      return $d;
    }
  }

  public static function arrayToObject($d) {
    if (is_array($d)) {
      /*
       * Return array converted to object
       * Using __FUNCTION__ (Magic constant)
       * for recursive call
       */
      return (object) array_map(array('mdBasicFunction', __FUNCTION__), $d);
    } else {
      // Return object
      return $d;
    }
  }

  public static function getdomain($url) {

    preg_match(
      "/^(http:\/\/|https:\/\/)?([^\/]+)/i", $url, $matches
    );

    $host = $matches[2];

    preg_match(
      "/[^\.\/]+\.[^\.\/]+$/", $host, $matches
    );
    if (!isset($matches[0]))
      return "";
    return strtolower("{$matches[0]}");
  }

  public static function generateTrivialPassword($len = 6) {
    $pass = '';
    for ($i = 0; $i < $len; $i++) {
      $pass.= chr(rand(0, 25) + ord('a'));
    }
    return $pass;
  }

  /**
   * Suma o resta $meses a la fecha actual
   * 
   * @param int (negativo | positivo) $months
   * @return date
   */
  public static function calculateDate($months) {
    $calculo = strtotime("$months months");
    return date("Y-m-d", $calculo);
  }

  public static function size($path, $formated = true, $retstring = null) {
    if (!is_dir($path) || !is_readable($path)) {
      if (is_file($path) || file_exists($path)) {
        $size = filesize($path);
      } else {
        return false;
      }
    } else {
      $path_stack[] = $path;
      $size = 0;

      do {
        $path = array_shift($path_stack);
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
          if ($file != '.' && $file != '..' && is_readable($path . DIRECTORY_SEPARATOR . $file)) {
            if (is_dir($path . DIRECTORY_SEPARATOR . $file)) {
              $path_stack[] = $path . DIRECTORY_SEPARATOR . $file;
            }
            $size += filesize($path . DIRECTORY_SEPARATOR . $file);
          }
        }
        closedir($handle);
      } while (count($path_stack) > 0);
    }

    if ($formated) {
      $sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
      if ($retstring == null) {
        $retstring = '%01.2f %s';
      }
      $lastsizestring = end($sizes);
      foreach ($sizes as $sizestring) {
        if ($size < 1024) {
          break;
        }
        if ($sizestring != $lastsizestring) {
          $size /= 1024;
        }
      }
      if ($sizestring == $sizes[0]) {
        $retstring = '%01d %s';
      } // los Bytes normalmente no son fraccionales
      $size = sprintf($retstring, $size, $sizestring);
    }
    return $size;
  }

  static public function makeDayArray($startDate, $endDate) {
    // Just to be sure - feel free to drop these is your sure of the input
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    // New Variables
    $currDate = $startDate;
    $dayArray = array();

    // Loop until we have the Array
    do {
      $dayArray[] = date('Y-m-d', $currDate);
      $currDate = strtotime('+1 day', $currDate);
    } while ($currDate <= $endDate);

    // Return the Array
    return $dayArray;
  }

}
