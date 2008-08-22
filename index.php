<?
session_start();

if (strstr(strtoupper($_SERVER['HTTP_USER_AGENT']), 'MSIE')) {

    $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
        preg_replace('/;.*$/', '', $_SERVER['HTTP_IF_MODIFIED_SINCE']) : '';

    $file_last_modified = filemtime($_SERVER['SCRIPT_FILENAME']);
    $gmdate_modified = gmdate('D, d M Y H:i:s', $file_last_modified) . ' GMT';

    if ($if_modified_since == $gmdate_modified) {
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
// Extract the cookie value for the variable "hash".
lastRequestedUrl = document.cookie.toString();
lastRequestedUrl = lastRequestedUrl.substr(lastRequestedUrl.search('hash='), lastRequestedUrl.length);
lastRequestedUrl = lastRequestedUrl.substr(0, lastRequestedUrl.search(';')).replace('hash=', '');
actualUrl = window.location.hash.toString();
actualUrl = actualUrl.substr(2, actualUrl.length);
// Compare the old "hash" from the cookie with 
// the new one in the actual window location bar.
if(actualUrl != lastRequestedUrl){
    // Set the cookie variable with the new  value
    // and reload the page so the cookie value is set
    // for the PHP script later in the page.
    document.cookie = 'hash=' + actualUrl;
    window.location.reload(true);
}else{
    // Set a variable to force the loading of IE
    // at the bottom of the page.
    //window.reloadIE = true;
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
function historyChange(historyStatus)
{
    loadPage(historyStatus.value.toString().replace('/', ''));
    //SWFAddress.setTitle('11');
}

SWFAddress.addEventListener(SWFAddressEvent.CHANGE, historyChange);
</script>

<?
include 'include/php/class/site.php';
include 'include/php/class/user.php';
include siteProperties::getClassPath() . 'structure.php';

// Set the default page to load with the template 
// system if the server variable is not set.
$pageToLoad = '';
foreach(explode('&', $_COOKIE['hash']) as $hashVariable){
    if(eregi('^page=', $hashVariable)){
        $pageToLoad = str_replace('page=', '', $hashVariable);
    }
}
if($pageToLoad == ''){
    if($_REQUEST['page'] != ''){
        $pageToLoad = $_REQUEST['page'];
    }else{
        $pageToLoad = 'index';
    }
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

// Reload the page for IE to counter the "304 Not Modified"
// effect we use in the hack to avoid loosing the history stack.
if(window.reloadIE == true){
    loadPage(actualUrl);
}
</script>
