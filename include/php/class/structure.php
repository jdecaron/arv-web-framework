<?
/*
MIT License
Copyright (c) 2008 Jean-Denis Caron
jean-denis@paralines.net

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

class buildStructure{

    function getBlocksToLoad($arguments_array){

        foreach($arguments_array['structure'] as $index => $cell){

            // Recursively process all the childs from that
            // array.
            if(is_array($cell['childs'])){
                $blockToLoad_array = buildStructure::getBlocksToLoad(array('structure' => $cell['childs'], 'blocksToLoad' => $arguments_array['blocksToLoad']));
                $arguments_array['blocksToLoad'] = $blockToLoad_array['blocksToLoad'];
            }

            // Append the new block to the others
            // already retrieved blocks.
            if(array_key_exists('load', $cell)){
                $arguments_array['blocksToLoad'] = array_merge($arguments_array['blocksToLoad'], array($index => $cell['load']));
            }
        }

        return $arguments_array;
    }

    function html($arguments_array){

        // Get the content to load and on which
        // template it has to be done.
        $page_array = page::$arguments_array['page']();
        $template_array = template::$page_array['template']();
        $blocksToLoad_array = buildStructure::getBlocksToLoad(array('structure' => $template_array['childs'], 'blocksToLoad' => array()));

        foreach($blocksToLoad_array['blocksToLoad'] as $index => $cell){
            if(is_numeric($cell)){
                // Replace the empty dynamic blocks
                // with the URL of the pages to be loaded.
                $blocksToLoad_array['blocksToLoad'][$index] = buildStructure::urlMerge(array('pagePath' => $page_array['content'][$cell]));
            }else{
                // Append the url variables to the page to load.
                $blocksToLoad_array['blocksToLoad'][$index] = buildStructure::urlMerge(array('pagePath' => $cell));
            }
        }

        $loadedBlocks_array = buildStructure::renderBlocks(array('blocksToLoad' => $blocksToLoad_array['blocksToLoad']));

        return buildStructure::renderHtmlStructure(array('loadedBlocks' => $loadedBlocks_array['loadedBlocks'], 'structure' => $blocksToLoad_array['structure']));
    }

    function urlMerge($arguments_array){
        $urlArguments_array = explode('&', $_COOKIE['hash']);
        foreach($urlArguments_array as $index => $urlArgument){
                if(eregi('phpsessionid', $urlArgument)){
                    // Check if the URL argument list
                    // contains the 'sessionid' variable. If
                    // true : set a flag variable to update the 
                    // argument later.
                    $urlContainsSessionId = true;
                }
        }
        
        if(session_id()){
            // Set the session ID in the argument lists so 
            // it later appears in every dynamic block loading
            // via HTTP requests.
            if(!$urlContainsSessionId){
                $urlArguments_array[] = 'PHPSESSIONID=' . session_id();
            }
        }

        if(count($urlArguments_array)){
            // Format the argument list for the HTTP request
            // if there are arguments in the array.
            $urlArguments = implode('&', $urlArguments_array);
            if(ereg('^&.*', $urlArguments)){
                $urlArguments = substr($urlArguments, 1);
            }
            $urlArguments = '?' . $urlArguments;
        }
        return $arguments_array['pagePath'] . $urlArguments;
    }

    function renderHtmlStructure($arguments_array){
    // Create a "<div>" for every childs
    // array of the template structure.
        foreach($arguments_array['structure'] as $index => $cell){
            if(is_array($cell)){
                // Set the style of this "<div>".
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

            shell_exec(siteProperties::getScriptPath() . 'wgetd "' . $urlToRender . '" "' . self::$temporaryFolder . self::$renderFilePrefix . '_' . $fileSuffix . '" > /dev/null 2>&1 &');
        }

        // Wait until all the files are
        // completely loaded.
        $renderCompleted = false;
$stopthat = 0;
        while(!$renderCompleted && $stopthat < 20){

            $renderCompleted = true;
            foreach($arguments_array['blocksToLoad'] as $fileSuffix => $urlToRender){
                if(!file_exists(self::$temporaryFolder . self::$renderFilePrefix . '_' . $fileSuffix)){
                    $renderCompleted = false;
                }
            }

$stopthat++;
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
        // Delete the file that is used
        // to flag that this file name is
        // in use.
        unlink(self::$temporaryFolder . self::$renderFilePrefix);

        return array('loadedBlocks' => $arguments_array['blocksToLoad']);
    }

    function renderStructureAsJSObject($arguments_array){
    // Render the structure of the elements as
    // JavaScript objects which contains functions
    // that returns XML based on the same structure
    // of the PHP arrays.
        $pageNames_array = get_class_methods($arguments_array['structureName']);

        // Build a window variable that holds the page
        // object which contains the template to load and
        // the block as well.
        $structure = "window.{$arguments_array[structureName]} = {";

        $counter = 0;
        foreach($pageNames_array as $cell){
            if($counter > 0){
                $structure .= ',';
            }
            $structure .= $cell . ': function(){' . 'return returnStructure("' . siteTools::arrayToXml(array('elements' => call_user_func(array($arguments_array['structureName'], $cell)), 'rootElement' => 'structure')) . '");' . '}';
            $counter++;
        }

        return $structure .= '}';
    }
}

class block{
// Class that define all the small blocks
// used in the main templates.

    function advertisement(){
        return 'http://arv.dyndns.org:520/include/tpl/arv/advertisement.php';
    }
    function blogs(){
        return 'http://arv.dyndns.org:520/include/tpl/test/blogs.php';
    }

    function rails(){
        return 'http://arv.dyndns.org:520/include/tpl/test/page1.php';
    }

    function page3(){
        return 'http://arv.dyndns.org:520/include/tpl/test/page3.php';
    }

    function page4(){
        return 'http://arv.dyndns.org:520/include/tpl/test/page4.php';
    }

    function page5(){
        return 'http://arv.dyndns.org:520/include/tpl/test/page5.php';
    }

    function page7(){
        return 'http://arv.dyndns.org:520/include/tpl/test/page4.php';
    }

    function page8(){
        return 'http://arv.dyndns.org:520/include/tpl/test/page4.php';
    }

    // 
    function headerBlock(){
        return 'http://arv.dyndns.org:520/include/tpl/arv/header.php';
    }
    function footer(){
        return 'http://arv.dyndns.org:520/include/tpl/arv/footer.php';
    }
    function navigationMenu(){
        return 'http://arv.dyndns.org:520/include/tpl/arv/menu.php';
    }

    function blogList(){
        return 'http://arv.dyndns.org:520/include/tpl/arv/blog_list.php';
    }
    function featuredArticles(){
        return 'http://arv.dyndns.org:520/include/tpl/arv/featured_articles.php';
    }
    function news(){
        return 'http://arv.dyndns.org:520/include/tpl/arv/news.php';
    }
    function screencast(){
        return 'http://arv.dyndns.org:520/include/tpl/arv/screencast.php';
    }
}

class page{
// Class that define the site pages
// and the place of that content in the
// structure of the template system.

    /*function reference(){
        return array(
            'template' => 'template0',
            'content' => array(
                            0 => 'http://example.com/include/page0.php',
                            1 => 'http://example.com/include/page1.php',
                            2 => 'http://example.com/include/page2.php'
                        )
        );
    }*/

    function index(){
        return array(
            'template' => 'index'
        );
    }

    function photos(){
        return array(
            'template' => 'content',
            'content' => array(
                            0 => 'http://arv.dyndns.org:520/include/tpl/arv/photos.php'
                        )
        );
    }

    function testpage(){
        return array(
            'template' => 'content',
            'content' => array(
                            0 => 'http://arv.dyndns.org:520/include/tpl/arv/testpage.php'
                        )
        );
    }

    function videos(){
        return array(
            'template' => 'content',
            'content' => array(
                            0 => 'http://arv.dyndns.org:520/include/tpl/arv/videos.php'
                        )
        );
    }
}

class template{

    function index(){
        return array(
        'childs' => array(
                    'a0' => array(
                            'load' => block::headerBlock(),
                            'dynamic' => 0,
                            'style' => 'clear:both'
                            ),
                    'a1' => array(
                            'load' => block::featuredArticles(),
                            'dynamic' => 0,
                            'style' => 'clear:both'
                            ),
                    'a2' => array(
                            'load' => block::navigationMenu(),
                            'dynamic' => 0,
                            'style' => 'clear:both'
                            ),
                    'a3' => array(
                            'childs' => array(
                                        'a3_b0' => array(
                                                        'childs' => array(
                                                                        'a3_b0_c0' => array(
                                                                                        'load' => block::news(),
                                                                                        'dynamic' => 0,
                                                                                        'style' => 'clear:both'
                                                                                        )
                                                                    ),
                                                        'style' => 'float:left'
                                                    ),
                                        'a3_b1' => array(
                                                        'childs' => array(
                                                                        'a3_b1_c0' => array(
                                                                                            'load' => block::advertisement(),
                                                                                            'dynamic' => 1
                                                                                        ),
                                                                        'a3_b1_c1' => array(
                                                                                            'load' => block::screencast(),
                                                                                            'dynamic' => 0,
                                                                                            'style' => 'clear:both;',
                                                                                        )
                                                                    ),
                                                        'style' => 'float:left;width:300px;'
                                                    )
                                        ),
                            'style' => 'clear:both'
                            ),
                    'a4' => array(
                            'load' => block::footer(),
                            'dynamic' => 0,
                            'style' => 'clear:both'
                            ),
        )
        );
    }

    function content(){
        return array(
        'childs' => array(
                    'a0' => array(
                            'load' => block::headerBlock(),
                            'dynamic' => 0,
                            'style' => 'clear:both'
                            ),
                    'a1' => array(
                            'load' => block::navigationMenu(),
                            'dynamic' => 0,
                            'style' => 'clear:both'
                            ),
                    'a2' => array(
                            'childs' => array(
                                        'a2_b0' => array(
                                                        'childs' => array(
                                                                    'a2_b0_c0' => array(
                                                                                    'load' => 0,
                                                                                    'dynamic' => 1,
                                                                                    'style' => 'clear:both'
                                                                                    )
                                                                    ),
                                                        'style' => 'float:left'
                                                    ),
                                        'a2_b1' => array(
                                                    'load' => block::advertisement(),
                                                    'dynamic' => 1,
                                                    'style' => 'float:left;',
                                                    )
                                        ),
                            'style' => 'clear:both;'
                            ),
                    'a3' => array(
                            'load' => block::footer(),
                            'dynamic' => 0,
                            'style' => 'clear:both'
                            ),
        )
        );
    }

    /*function template0(){
        return array(
        'childs' => array(
                    'a0' => array(
                            'load' => 545,
                            'dynamic' => 1,
                            'style' => 'clear:both'
                            ),
                    'a1' => array(
                            'childs' => array(
                                        'a1_b0' => array(
                                                    'load' => 440,
                                                    'dynamic' => 1,
                                                    'style' => 'float:left;width:140px;'
                                                   ),
                                        'a1_b1' => array(
                                                    'load' => 330,
                                                    'dynamic' => 1,
                                                    'style' => 'float:left;'
                                                   ),
                                        'a1_b2' => array(
                                                    'childs' => array(
                                                        'a1_b2_c0' => array(
                                                                        'load' => block::quickLinks(),
                                                                        'dynamic' => 0,
                                                                        'style' => 'width:170px;'
                                                                    )
                                                    ),
                                                    'style' => 'float:left;width:170px;'
                                                   )
                                        ),
                            'style' => 'clear:both',
                            ),
                    'a2' => array(
                            'load' => block::footer(),
                            'style' => 'clear:both'
                            )
        ),
        'title' => 'Find-Spots.com'
        );
    }*/

    function template1(){
        return array(
        'childs' => array(
                    'a0' => array(
                            'childs' => array(
                                        'a0_b0' => array(
                                                    'load' => block::news(),
                                                    'dynamic' => 0,
                                                    'style' => 'float:left;'
                                                   ),
                                        'a0_b1' => array(
                                                    'load' => block::page4(),
                                                    'dynamic' => 1,
                                                    'style' => 'float:left;'
                                                   )
                                        ),
                            'style' => 'clear:both',
                            ),
                    'a1' => array(
                            'childs' => array(
                                            'a1_b0' => array(
                                                'load' => 0,
                                                'dynamic' => 1,
                                                'style' => 'float:left;width:200px;'
                                            ),
                                            'a1_b1' => array(
                                                'childs' => array(
                                                                'a1_b1_c0' => array(
                                                                                'load' => block::page5(),
                                                                                'dynamic' => 0,
                                                                                'style' => 'float:left;'
                                                                )
                                                            ),
                                                'style' => 'float:left;'
                                            )
                                        ),
                            'style' => 'clear:both',
                            )
                    ),
        'title' => 'Find-Spots.com'
        );
    }

}
?>
