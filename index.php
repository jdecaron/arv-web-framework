<script src="include/js/navigation.js"></script>
<?
include 'include/php/class/site.php';
include 'include/php/class/user.php';
include siteProperties::getClassPath() . 'structure.php';

$structure = new buildStructure();
$page_template =  $structure->html(array('page' => 'index'));

echo '<a' .siteTools::generateAnchorAttributes(array('attributes' => array('style' => 'background-color:yellow;', 'href' => 'asdasd=asdasd&page=forum&sauce=1'))) . '>asdasd</a>';

echo <<<EOT

{$page_template}
<abbr><a href="#">asdas</a></abbr>
<script>
abbr_array = document.getElementsByTagName('abbr');
alert(abbr_array[0].innerHTML);
</script>
EOT;
?>
