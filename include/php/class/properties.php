<?

class siteProperties{

    private static $root_path = '/var/www/find-spots.com/';
    private static $class_path = 'inlude/php/class/';

    static function getRootPath(){
        return self::$root;
    }    

    static function getClassPath(){
        return self::$root_path . self::$class_path;
    }    

}

?>
