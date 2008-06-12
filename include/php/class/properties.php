<?

class siteProperties{

    private static $class_path = 'include/php/class/';
    private static $root_path = '/var/www/find-spots.com/';
    private static $script_path = 'sh/';

    static function getClassPath(){
        return self::getRootPath() . self::$class_path;
    }    

    static function getRootPath(){
        return self::$root_path;
    }    

    static function getScriptPath(){
        return self::getRootPath() . self::$script_path;
    }    

}

?>
