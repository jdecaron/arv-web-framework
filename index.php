<script>/*if(window.location.hash && typeof(window.actualTemplate_xml)=='undefined'){alert(3);}*/</script>

<!--AJAX navigation system.-->
<script src="include/js/ajax.js"></script>
<script src="include/js/navigation.js"></script>

<!--AJAX history management.-->
<script type="text/javascript" src="include/js/rsh.js"></script>

<!--Prototype, hosted by Google.-->
 <script type="text/javascript" src="include/js/prototype-1.6.0.2.js"></script>

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

$page_template =  buildStructure::html(array('page' => 'index'));

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
window.actualTemplate_xml = page.index();
processTemplateStructure(window.actualTemplate_xml, 'actual');
</script>
