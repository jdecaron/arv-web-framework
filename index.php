<?session_start();?>
<script>
// Set the cookie variable that is used in
// the PHP loading module.
document.cookie = 'url=' + window.location.hash.toString().replace('#', '');
if(window.location.hash && typeof(window.actualTemplate_xml)=='undefined'){
    // Redirect for refreshes and direct
    // landing with urls that contain a hash.

    if(document.cookie.match('relocation=.*;') == null){
        // Unset the relocation cookie.
        document.cookie.replace('relocation=.*;', '');

        // Force the url redirection. Because a simple
        // hash redirection doesn't force the page to reload.
        if(window.location.toString().match('\\?')){
            document.cookie = 'relocation=1';
            window.location = '/find-spots.com/' + window.location.hash.toString();
        }else{
            document.cookie = 'relocation=1';
            window.location = '/find-spots.com/?' + window.location.hash.toString();
        }
    }
}
</script>

<!--AJAX navigation system.-->
<script src="include/js/ajax.js"></script>
<script src="include/js/navigation.js"></script>

<!--Prototype, hosted by Google.-->
<script type="text/javascript" src="include/js/prototype-1.6.0.2.js"></script>

<!--AJAX history management.-->
<script type="text/javascript" src="include/js/rsh.js"></script>
<script type="text/javascript">
window.dhtmlHistory.create({
    toJSON: function(o) {
        return Object.toJSON(o);
    }
    , fromJSON: function(s){
        return s.evalJSON();
    }
});

// This bool is set because when the template is loading
// the location hash is not immediately changed. So, the
// verify location change interfer with the loading of
// the page.
var rshListener = function(){
    document.cookie = 'url=' + window.location.hash.toString().replace('#', '');
    loadPage(window.location.hash.toString().replace('#', ''));
}

window.onload = function(){
    dhtmlHistory.initialize();
    dhtmlHistory.addListener(rshListener);
};
</script>

<?
include 'include/php/class/site.php';
include 'include/php/class/user.php';
include siteProperties::getClassPath() . 'structure.php';

// Set the default page to load with the template 
// system if the server variable is not set.
$pageToLoad = '';
foreach(explode('&', $_COOKIE['url']) as $urlVariable){
    if(eregi('^page=', $urlVariable)){
        $pageToLoad = str_replace('page=', '', $urlVariable);
    }
}
if($pageToLoad == ''){
    $pageToLoad = 'index';
}

$page_template =  buildStructure::html(array('page' => $pageToLoad));

echo '<a' .siteTools::generateAnchorAttributes(array('attributes' => array('style' => 'background-color:yellow;', 'href' => 'asdasd=asdasd&page=index&sauce=1'))) . '>asdasd</a>';
echo ' ';
echo '<a' .siteTools::generateAnchorAttributes(array('attributes' => array('style' => 'background-color:yellow;', 'href' => 'asdasd=asdasd&page=forum&sauce=2'))) . '>asdasd</a>';

echo $page_template;
?>

<!--Include the JavaScript file that contains
all the structure of the templates and of the pages.-->
<script>
<?=buildStructure::renderStructureAsJSObject(array('structureName' => 'page'));?>

<?=buildStructure::renderStructureAsJSObject(array('structureName' => 'template'));?>

window.actualUrlList_array = [];
window.actualTemplate_xml = page.<?=$pageToLoad?>();
processTemplateStructure(window.actualTemplate_xml, 'actual');
</script>
