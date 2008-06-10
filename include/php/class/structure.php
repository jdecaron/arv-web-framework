<?

class buildStructure{
    var $temporaryFolder = '/var/www/find-spots.com/tmp/template/';
    var $renderFilePrefix = null;

    function getBlocksToLoad($arguments_array){

   var_dump($arguments_array);
        foreach($arguments_array['structure'] as $index => $row){
            if(is_array($row['childs'])){
                $this->getBlocksToLoad(array('structure' => $row['childs'], 'blocksToLoad' => $arguments_array['blocksToLoad']));
            }

            if(array_key_exists('load', $row)){
                $arguments_array['blocksToLoad'] = array_merge($arguments_array['blocksToLoad'], array($index => $row['load']));
            }

            if(array_key_exists('content', $row)){
                $arguments_array['blocksToLoad'] = array_merge($arguments_array['blocksToLoad'], array($index => $row['content']));
            }
        }

        return $arguments_array;
    }

    function javaScript($arguments_array){
        //var_dump(siteProperties::getRootPath());
    }

    function html($arguments_array){

        // Get the content to load and on which
        // template it has to be done.
        $page_array = page::$arguments_array['page']();
        $blocksToLoad = $this->getBlocksToLoad(array('structure' => templateStructure::$page_array['template'](), 'blocksToLoad' => array()));
        //var_dump($blocksToLoad);
        // replace
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
// Class that define all the small blocks
// used in the main templates.

    function news(){
        return 'http://192.168.1.102/find-spots.com/include/tpl/test/page2.php';
    }

    function rails(){
        return 'http://192.168.1.102/find-spots.com/include/tpl/test/page1.php';
    }

}

class page{
// Class that define the site pages
// and the place of that content in the
// structure of the template system.

    function index(){
        return array(
            'template' => 'template0',
            'content' => array(
                            'load' => '/test/test1.php'
                        )
        );
    }

}

class templateStructure{
    function template0(){
        return array(
        'a0' => array(
                'childs' => array(
                            'a0_b0' => array(
                                        'load' => blockStructure::news(),
                                        'style' => 'float:left;'
                                       ),
                            'a0_b1' => array(
                                        'load' => blockStructure::rails(),
                                        'style' => 'float:left;'
                                       )
                            ),
                'style' => 'clear:both',
                ),
        'a1' => array(
                'childs' => array(
                                'a1_b0' => array(
                                    'content' => 0,
                                )
                            ),
                'style' => 'clear:both',
                ),
        'title' => 'Find-Spots.com'
        );
    }
}

?>
