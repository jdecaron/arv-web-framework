<?
include 'include/php/class/properties.php';
include siteProperties::getClassPath() . 'structure.php';

$structure = new buildStructure();
var_dump($structure->html(array('page' => 'index')));
?>
