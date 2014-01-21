<?php
/**
 * Description of cronFunctions
 *
 * @author chugas
 */
class mdHelp 
{
  private static $month = array(null, 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');
  
  public static function month($number)
  {
    return self::$month[$number];
  }
}

?>
