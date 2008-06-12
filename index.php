<?
include 'include/php/class/properties.php';
include siteProperties::getClassPath() . 'structure.php';

$structure = new buildStructure();
echo $structure->html(array('page' => 'index'));
?>
