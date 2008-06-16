<?
include 'include/php/class/site.php';
include 'include/php/class/user.php';
include siteProperties::getClassPath() . 'structure.php';

$structure = new buildStructure();
$page_template =  $structure->html(array('page' => 'index'));

echo '<a' .siteTools::generateAnchorAttributes(array('attributes' => array('style' => 'background-color:yellow;', 'href' => 'asdasd=asdasd&page=forum&sauce=1'))) . '>asdasd</a>';

echo <<<EOT

{$page_template}
<textnode>asdas</textnode>
<script>
textnode_array = document.getElementsByTagName('textnode');
alert(textnode_array[0].innerHTML);
</script>
EOT;
?>
