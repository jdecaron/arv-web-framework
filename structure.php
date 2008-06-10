<?

class buildStructure{
    var $temporaryFolder = '/var/www/find-spots.com/tmp/template/';
    var $renderFilePrefix = null;

    function javaScript($arguments_array){
        var_dump(siteProperties::getRoot());
    }

    function html(){
        pageStructure::template0();
    }

    function renderPage($arguments_array){
        // Clean the array from any potential shell attack.
        $arguments_array = array_map('escapeshellcmd', $arguments_array);

        // Create a unique file name to work with during
        // the render process.
        if($this->renderFilePrefix == null){
            do{
                //
            }while(file_exists($this->temporaryFolder . $this->renderFilePrefix = md5(microtime())));
            touch($this->temporaryFolder . $this->renderFilePrefix);
        }

        foreach($arguments_array as $argument){
            shell_exec('sleep 20 >/dev/null 2>&1 &');
        }
        echo 'render1';
    }
}

class blockStructure{

    function news($arguments_array){
        return array(
            'load' => 'http://whatismyip.org/',
            'position' => $arguments_array['position']
        );
    }

    function rails($arguments_array){
        return array(
            'load' => 'http://whatismyip.org/',
            'position' => $arguments_array['position']
        );
    }

}

class page{

    function index(){
        return array(
            'template' => 'template0',
            'blocks' => array(
                            array(
                                'load' => '/test/test1.php',
                                'position' => 'a0_b1'
                            )
                        )
        );
    }

}

class templateStructure{
    static function template0(){
        return array(
        'a0' => array(
                'childs' => array(
                            'a0_b0' => blockStructure::news(array('position' => 'a0_b0')),
                            'a0_b1' => blockStructure::rails(array('position' => 'a0_b1'))
                            ),
                'style' => 'clear:both',
                ),
        'title' => 'Find-Spots.com'
        );
    }
}

include 'include/php/class/properties.php';
$structure = new buildStructure();
$structure->javaScript('');

?>
