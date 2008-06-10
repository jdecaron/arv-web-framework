<?

class siteProperties{

    private static $root_path = '/var/www/find-spots.com/';
    private static $class_path = 'include/php/class/';

    static function getRootPath(){
        return self::$root_path;
    }    

    static function getClassPath(){
        return self::getRootPath() . self::$class_path;
    }    

}

?>
