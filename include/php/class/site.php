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


class siteTools{

    function generateAnchorAttributes($arguments_array){
        
        if(array_key_exists('href', $arguments_array['attributes'])){
            // Set the URL accordingly to the
            // type of navigation the user has
            // chosen.
            if(userSettings::getNavigationType() == 'ajax'){
                // Add the AJAX page navigation function
                // to the "onclick" event.
                $arguments_array['attributes']['onclick'] .= 'userLinkClick(\'' . $arguments_array['attributes']['href'] . '\', \'ajax\');';
                $arguments_array['attributes']['href'] = '#' . $arguments_array['attributes']['href'];
            }else{
                $arguments_array['attributes']['href'] = '?' . $arguments_array['attributes']['href'];
            }
        }

        return self::generateMLAttributes(array('attributes' => $arguments_array['attributes']));
    }

    function generateMLAttributes($arguments_array){
    // Generate all the attributes for any
    // markup language from an array.
        $attributes = '';
        foreach($arguments_array['attributes'] as $attributeName => $attributeValue){
            $attributes .= ' ' . str_replace('"', '', $attributeName) . '="' . str_replace('"', '', $attributeValue) . '"';
        }

        return $attributes;
    }
}

?>
