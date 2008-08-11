<script>/*if(window.location.hash && typeof(window.actualTemplate_xml)=='undefined'){alert(3);}*/</script>

<!--AJAX navigation system.-->
<script src="include/js/ajax.js"></script>
<script src="include/js/navigation.js"></script>

<!--Prototype, hosted by Google.-->
<script type="text/javascript" src="include/js/prototype-1.6.0.2.js"></script>

<script>
window.actualLocation = window.location.toString();
function verifyLocationChange(){
    if(window.location != window.actualLocation){
        window.actualLocation = window.location.toString();
        loadPage(window.location.hash.toString().replace('#', ''));
    }
}
locationListener = window.setInterval(verifyLocationChange, 100);
</script>

<?
include 'include/php/class/site.php';
include 'include/php/class/user.php';
include siteProperties::getClassPath() . 'structure.php';

$page_template =  buildStructure::html(array('page' => 'index'));

echo '<a' .siteTools::generateAnchorAttributes(array('attributes' => array('style' => 'background-color:yellow;', 'href' => 'asdasd=asdasd&page=index&sauce=1'))) . '>asdasd</a>';
echo ' ';
echo '<a' .siteTools::generateAnchorAttributes(array('attributes' => array('style' => 'background-color:yellow;', 'href' => 'asdasd=asdasd&page=forum&sauce=2'))) . '>asdasd</a>';

echo <<<EOT

{$page_template}
<abbr><a href="#">asdas</a></abbr>
<script>
//abbr_array = document.getElementsByTagName('abbr');
//alert(abbr_array[0].innerHTML);
</script>
EOT;


?>
<!--Include the JavaScript file that contains
all the structure of the templates and of the pages.-->
<script>
<?=buildStructure::renderStructureAsJSObject(array('structureName' => 'page'));?>

<?=buildStructure::renderStructureAsJSObject(array('structureName' => 'template'));?>

window.actualUrlList_array = [];
window.actualTemplate_xml = page.index();
processTemplateStructure(window.actualTemplate_xml, 'actual');
</script>
