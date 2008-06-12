<?

class buildStructure{

    function getBlocksToLoad($arguments_array){

        foreach($arguments_array['structure'] as $index => $cell){

            // Recursively process all the childs from that
            // array.
            if(is_array($cell['childs'])){
                $blockToLoad_array = buildStructure::getBlocksToLoad(array('structure' => $cell['childs'], 'blocksToLoad' => $arguments_array['blocksToLoad']));
                $arguments_array['blocksToLoad'] = $blockToLoad_array['blocksToLoad'];
            }

            // Append the new block to the other
            // already retrieved blocks.
            if(array_key_exists('load', $cell)){
                $arguments_array['blocksToLoad'] = array_merge($arguments_array['blocksToLoad'], array($index => $cell['load']));
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
        $blocksToLoad_array = buildStructure::getBlocksToLoad(array('structure' => templateStructure::$page_array['template'](), 'blocksToLoad' => array()));

        // Replace the empty dynamic
        // blocks by the URL's of the pages
        // to be loaded.
        foreach($blocksToLoad_array['blocksToLoad'] as $index => $cell){
            if(is_numeric($cell)){
                $blocksToLoad_array['blocksToLoad'][$index] = $page_array['content'][$cell];
            }
        }

        $loadedBlocks_array = buildStructure::renderBlocks(array('blocksToLoad' => $blocksToLoad_array['blocksToLoad']));

        return buildStructure::renderHtmlStructure(array('loadedBlocks' => $loadedBlocks_array['loadedBlocks'], 'structure' => $blocksToLoad_array['structure']));
    }

    function renderHtmlStructure($arguments_array){

        foreach($arguments_array['structure'] as $index => $cell){
            if(is_array($cell)){
                if(array_key_exists('style', $cell)){
                    $style = ' style="' . $cell['style'] . '"';
                }

                $htmlRendered .= '<div id="' . $index . '" ' . $style . '>';
                if(array_key_exists($index, $arguments_array['loadedBlocks'])){
                    $htmlRendered .= $arguments_array['loadedBlocks'][$index];
                }
                $htmlRendered .= buildStructure::renderHtmlStructure(array('loadedBlocks' => $arguments_array['loadedBlocks'], 'structure' => $cell['childs']));
                $htmlRendered .= '</div>';
            }
        }

        return $htmlRendered;
    }

    private static $temporaryFolder = '/tmp/';
    private static $renderFilePrefix = null;
    function renderBlocks($arguments_array){

        // Create a unique file name to work with during
        // the render process.
        if(self::$renderFilePrefix == null){
            do{
                //
            }while(file_exists(self::$temporaryFolder . self::$renderFilePrefix = md5(microtime())));
            touch(self::$temporaryFolder . self::$renderFilePrefix);
        }

        // Render all the pages and put them in
        // separate files.
        foreach($arguments_array['blocksToLoad'] as $fileSuffix => $urlToRender){
            $blockToRender = escapeshellcmd($blockToRender);

            shell_exec(siteProperties::getScriptPath() . 'wgetd ' . $urlToRender . ' ' . self::$temporaryFolder . self::$renderFilePrefix . '_' . $fileSuffix . '>/dev/null 2>&1 &');
        }

        // Wait until all the files are
        // completely loaded.
        $renderCompleted = false;
        while(!$renderCompleted){

            $renderCompleted = true;
            foreach($arguments_array['blocksToLoad'] as $fileSuffix => $urlToRender){
                if(!file_exists(self::$temporaryFolder . self::$renderFilePrefix . '_' . $fileSuffix)){
                    $renderCompleted = false;
                }
            }

            usleep(20000);
        }

        // Return the array with
        // the loaded content.
        foreach($arguments_array['blocksToLoad'] as $fileSuffix => $urlToRender){
            $block_file = fopen(self::$temporaryFolder . self::$renderFilePrefix . '_' . $fileSuffix, "r");
            $arguments_array['blocksToLoad'][$fileSuffix] = fread($block_file, filesize(self::$temporaryFolder . self::$renderFilePrefix . '_' . $fileSuffix));
            fclose($block_file);

            // Delete the working files.
            unlink(self::$temporaryFolder . self::$renderFilePrefix . '_' . $fileSuffix);
        }
        // Delete the 
        unlink(self::$temporaryFolder . self::$renderFilePrefix);

        return array('loadedBlocks' => $arguments_array['blocksToLoad']);
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
                            'http://192.168.1.102/find-spots.com/include/tpl/test/page3.php'
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
                                    'load' => 0
                                )
                            ),
                'style' => 'clear:both',
                ),
        'title' => 'Find-Spots.com'
        );
    }
}

?>
