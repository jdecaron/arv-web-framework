<?
include '/var/www/find-spots.com/include/php/class/site.php';
include '/var/www/find-spots.com/include/php/class/user.php';
?>
<div style="margin-top:40px;width:700px;height:100%;background-color:white;">
<?
$image = $_REQUEST['image'];
if($image <= 0){
    $image = 0;
}

// Previous image button value.
if($image <= 0){
    $previousImage = 4;
}else{
    $previousImage = $image - 1;
}

// Next image button value.
if($image >= 4){
    $nextImage = 0;
}else{
    $nextImage = $image + 1;
}

?>
<a style="margin-left:20px;" <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=photos&image=' . $previousImage)))?>><img style="border-style:none;" src="img/arv/arrow_l.gif"></a>
<a style="margin-left:500px;" <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=photos&image=' . $nextImage)))?>><img style="border-style:none;" src="img/arv/arrow_r.gif"></a>

<div style="background-color:black;padding:5px;width:500px;margin-left:22px;"<img src="img/legrisak/<?=$image?>.jpg"></div>

</div>
