<?
if($_COOKIE['deleteHashCookie'] !== 'false'){
    unset($_COOKIE['hash']);
}
unset($_COOKIE['deleteHashCookie']);

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
    if(window.location.toString().search('#') != -1 && window.location.toString().split('#')[1].length > 0){
        hashValue = window.location.toString().split('#')[1].substr(1);
        document.cookie = 'hash=' + hashValue + ';';
        document.cookie = 'deleteHashCookie=false;';
    }
}

if(window.location.toString().search('#') != -1 && window.location.toString().split('#') > 1){
    // Process the hash string comparison with the cookie
    // because the hash is set in the URL.
    hashValue = window.location.toString().split('#')[1].substr(1);
    if(document.cookie.toString().match('hash=' + hashValue + ';|hash=' + hashValue + '?') == null){
        // Reload the page to make the cookie variable visible
        // from PHP. And the cookie value for the hash is updated
        // during the body "onunload" state.
        document.cookie = 'hash=' + hashValue + ';';
        document.cookie = 'deleteHashCookie=false;';
        window.location.reload(true);
    }
}
</script>

<!--AJAX navigation system.-->
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

echo '<title>ARV Web Framework</title><html><body style="background-image:url(img/arv/background4.jpg);background-position:fixed;text-align:center;background-color:grey;font-family:sans-serif;margin-left:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;"><div id="loading" style="visibility:hidden;position:absolute;width:100%;height:26px;"><span style="padding-top:3px;padding-bottom:5px;padding-left:20px;padding-right:20px;color:white;width:150px;background-color:#a1545c;">Loading...</span></div><div id="page" style="text-align:left;margin:auto;width:1000px;background-color:white;">' . $page_template . '</div>';
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
</body>
</html>
