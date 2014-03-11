<?php
/**
 * Variables de configuracion utilizadas:
 * sfConfig::get('app_support')
 * sfConfig::get('sf_root_dir')
 */
class Md_TaskManager
{

    private static function getLocalPath(){
        return sfConfig::get('sf_root_dir') . '/cache/task_manager/';
    }
    
    public static function lockTask($taskName) {
        @mkdir(self::getLocalPath(), 0777, true);

        $log = fopen(self::getLocalPath() . $taskName . '.log', 'a+');
        fwrite($log, date('Y-m-d H:i:s') . ' - BEGIN WORK' . PHP_EOL);
        fclose($log);

        return file_put_contents(self::getLocalPath() . $taskName . '.lock', time());
    }
    
    public static function unlockTask($taskName) {
        $log = fopen(self::getLocalPath() . $taskName . '.log', 'a+');
        fwrite($log, date('Y-m-d H:i:s') . ' - END WORK' . PHP_EOL);
        fclose($log);
        
        return unlink(self::getLocalPath() . $taskName . '.lock');
    }
    
    public static function forceReleaseLock($taskName) {
        $lockTime = (integer) file_get_contents(self::getLocalPath() . $taskName . '.lock', time());
        
        // Task is Locked for a Looong time
        if ((time() - $lockTime) > 1800) {
            mail(sfConfig::get('app_support'), 'MASTODONTE LOCK', $taskName . ' is locked');
            return false;
        } else {
            return true;
        }
    }
    
    public static function log($taskName, $logText) {
        $log = fopen(self::getLocalPath() . $taskName . '.log', 'a+');
        fwrite($log, date('Y-m-d H:i:s') . ' - ' . $logText . PHP_EOL);
        fclose($log);        
    }
    
    public static function isTaskLocked($taskName) {
        $lockExists = false;
        
        if (file_exists(self::getLocalPath() . $taskName . '.lock')) {
            $lockExists = self::forceReleaseLock($taskName);
        }
        
        return $lockExists;
    }
}
