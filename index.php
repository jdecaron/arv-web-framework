<?
include 'include/php/class/properties.php';
include siteProperties::getClassPath() . 'structure.php';

$structure = new buildStructure();
$structure->html(array('page' => 'index'));
?>
