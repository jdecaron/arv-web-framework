<?
session_start();

if (strstr(strtoupper($_SERVER['HTTP_USER_AGENT']), 'MSIE')) {

    $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
        preg_replace('/;.*$/', '', $_SERVER['HTTP_IF_MODIFIED_SINCE']) : '';

    $file_last_modified = filemtime($_SERVER['SCRIPT_FILENAME']);
    $gmdate_modified = gmdate('D, d M Y H:i:s', $file_last_modified) . ' GMT';

    if ($if_modified_since == $gmdate_modified) {
        setcookie('ieGotRefreshed', '1');
        if (php_sapi_name() == 'cgi') {
            header('Status: 304 Not Modified');
        } else {
            header('HTTP/1.1 304 Not Modified');
        }
        exit();
    }

    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
    header('Last-Modified: ' . $gmdate_modified);
    header('Cache-control: max-age=' . 86400);
}
?>

<script>
window.onbeforeunload = function(){
    document.cookie = 'hash=' + window.location.hash.toString().substr(2, window.location.hash.toString().length);
}

if(document.cookie.toString().search('hash=*' + window.location.hash.toString().substr(2, window.location.hash.toString().length) + ';') == -1){
    // Reload the page to make the cookie variable visible
    // from PHP. And the cookie value for the hash is updated
    // during the body "onunload" state.
    window.location.reload(true);
}
</script>

<!--AJAX navigation system.-->
<script src="include/js/ajax.js"></script>
<script src="include/js/navigation.js"></script>

<!--Prototype, hosted by Google.-->
<script type="text/javascript" src="include/js/prototype-1.6.0.2.js"></script>

<!--AJAX history management.-->
<script type="text/javascript" src="include/js/swfaddress.js"></script>
<script type="text/javascript">
window.loadWithHistoryListener = false;
function historyChange(historyStatus)
{
window.loadWithHistoryListener
    if(window.loadWithHistoryListener == true){
        loadPage(historyStatus.value.toString().replace('/', ''));
    }else{
        window.loadWithHistoryListener = true; 
    }
}
SWFAddress.addEventListener(SWFAddressEvent.CHANGE, historyChange);
</script>
<?
include 'include/php/class/site.php';
include 'include/php/class/user.php';
include siteProperties::getClassPath() . 'structure.php';

$pageToLoad = 'index';
var_dump($_COOKIE);
if($_COOKIE['hash'] != ''){
    foreach(explode('&', $_COOKIE['hash']) as $hashVariable){
        if(eregi('^page=', $hashVariable)){
            $pageToLoad = str_replace('page=', '', $hashVariable);
        }
    }
}else if(isset($_REQUEST['page'])){
    $_COOKIE['hash'] = $_SERVER['QUERY_STRING'];
    $pageToLoad = $_REQUEST['page'];
}

$page_template =  buildStructure::html(array('page' => $pageToLoad));

echo '<a' .siteTools::generateAnchorAttributes(array('attributes' => array('style' => 'background-color:yellow;', 'href' => 'asdasd=asdasd&page=index&sauce=a'))) . '>color blocks a</a>';
echo ' ';
echo '<a' .siteTools::generateAnchorAttributes(array('attributes' => array('style' => 'background-color:yellow;', 'href' => 'asdasd=asdasd&page=index&sauce=b'))) . '>color blocks b</a>';
echo '&nbsp;&nbsp;&nbsp;&nbsp; ';
echo '<a' .siteTools::generateAnchorAttributes(array('attributes' => array('style' => 'background-color:yellow;', 'href' => 'asdasd=asdasd&page=forum&sauce=2'))) . '>ns layout</a>';

echo '<div id="page" style="width:1000px;">' . $page_template . '</div>';
?>
<!--Include the JavaScript file that contains
all the structure of the templates and of the pages.-->
<script>
<?=buildStructure::renderStructureAsJSObject(array('structureName' => 'page'));?>

<?=buildStructure::renderStructureAsJSObject(array('structureName' => 'template'));?>

window.actualUrlList_array = [];
window.actualTemplate_xml = page.<?=$pageToLoad?>();
processTemplateStructure(window.actualTemplate_xml, 'actual');

// Reload the page for IE because the page is not refreshed from the server
// since a header "304 Not Modified" has been sent. This hack is done to avoid 
// loosing the history stack.
if(document.cookie.toString().search('ieGotRefreshed=1') != -1){
    document.cookie = 'ieGotRefreshed='; // Unset the cookie value to differienciate the refreses from direct access.
    loadPage(window.location.hash.toString().substr(2, window.location.hash.toString().length));
}
</script>
