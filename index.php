<!--AJAX navigation system.-->
<script src="include/js/ajax.js"></script>
<script src="include/js/navigation.js"></script>

<!--AJAX history management.-->
<script type="text/javascript" src="include/js/json2007.js"></script>
<script type="text/javascript" src="include/js/rsh.js"></script>
<script type="text/javascript">
window.dhtmlHistory.create();

var yourListener = function(newLocation, historyData) {
    //alert('aaaa');
}

window.onload = function() {
    dhtmlHistory.initialize();
    dhtmlHistory.addListener(yourListener);
};
</script>


<?
include 'include/php/class/site.php';
include 'include/php/class/user.php';
include siteProperties::getClassPath() . 'structure.php';

$structure = new buildStructure();
$page_template =  $structure->html(array('page' => 'index'));

echo '<a' .siteTools::generateAnchorAttributes(array('attributes' => array('style' => 'background-color:yellow;', 'href' => 'asdasd=asdasd&page=forum&sauce=1'))) . '>asdasd</a>';
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
<?var_dump(siteTools::arrayToXml(array('elements' => templateStructure::template0(), 'rootElement' => 'template')))?>
<?//var_dump(get_class_methods('templateStructure'));?>
<script>
window.templateStructure = {
/* convert php array to a javascript array */
    windowAlert: function(){
        var arrayVar = new Object();
        arrayVar.sauce = 'aaaaaaaa';
        return arrayVar.sauce;
    }
}
alert(templateStructure.windowAlert());
</script>
