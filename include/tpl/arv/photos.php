<?
include '/var/www/find-spots.com/include/php/class/site.php';
include '/var/www/find-spots.com/include/php/class/user.php';
?>

<div style="margin-top:40px;width:700px;padding-bottom:35px;background-color:white;">
<?
$image = $_REQUEST['id'];
if($image <= 1){
    $image = 1;
}

// Previous image button value.
if($image <= 1){
    $previousImage = 9;
}else{
    $previousImage = $image - 1;
}

// Next image button value.
if($image >= 9){
    $nextImage = 1;
}else{
    $nextImage = $image + 1;
}

?>

<?$sizes = getimagesize("/var/www/find-spots.com/img/legrisak/".$image.".jpg");?>
<div style="width:<?=$sizes[0]?>px;margin-left:22px;background-image:url(img/legrisak/<?=$image?>.jpg);">
<a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=photos&id=' . $previousImage)))?>><img style="border-style:none;" src="img/arv/spacer.gif" width="<?=$sizes[0] / 2;?>" height="<?=$sizes[1];?>"></a>
<a style="position:absolute;" <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=photos&id=' . $nextImage)))?>><img style="border-style:none;" src="img/arv/spacer.gif" width="<?=$sizes[0] / 2;?>" height="<?=$sizes[1];?>"></a>
</div>
</div>

<?
$lorem = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Cras gravida. In pellentesque condimentum justo. Maecenas tincidunt eleifend nulla. Curabitur aliquam lacus eget felis. Nunc nulla felis, ullamcorper et, aliquet id, euismod vitae, lorem. Curabitur erat ipsum, condimentum eu, facilisis sit amet, consequat a, nunc. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque cursus velit at sem. Fusce id elit. Aliquam erat volutpat. Aliquam erat volutpat. Pellentesque in nisi. Nam semper interdum orci. Integer ac nisl. Suspendisse cursus dolor adipiscing turpis. Vivamus suscipit, massa ut sollicitudin tristique, sapien dolor luctus tortor, vel commodo turpis quam eu ipsum. Donec eu diam. Suspendisse sodales. Donec semper, magna ac auctor laoreet, est erat hendrerit est, non commodo diam eros non arcu. Sed urna quam, egestas sit amet, laoreet sed, interdum sit amet, orci. Sed iaculis, libero sit amet fermentum dignissim, quam lorem egestas elit, a auctor lacus risus eleifend quam. Nulla facilisi. Nullam nibh nibh, porttitor eu, vulputate quis, dapibus non, purus. Cras interdum. Nulla quis pede. Aenean ut magna quis augue elementum dignissim. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse blandit risus vel pede. Proin pretium, leo at pharetra tincidunt, lectus tellus laoreet elit, nec tempor dolor nisi vestibulum diam. Curabitur tellus leo, lacinia eget, rutrum nec, tincidunt vel, neque. Cras eleifend accumsan felis. Integer vitae sem. Sed posuere mi ut felis. Etiam libero. Sed bibendum, nibh in scelerisque placerat, massa justo lobortis metus, vitae tempor nibh nulla ac augue. Nullam nec enim. Proin accumsan ligula in pede. Vestibulum lectus lorem, vehicula laoreet, porta sit amet, ullamcorper dictum, nisl. Curabitur ante justo, sollicitudin non, convallis sit amet, porttitor eget, diam. Suspendisse blandit semper lacus. Cras id nunc vel nisi volutpat feugiat. Maecenas et risus. Phasellus ornare, massa in porttitor imperdiet, elit nibh accumsan dui, ut ultrices diam erat eu urna. Donec lobortis risus vitae quam facilisis adipiscing. Phasellus a magna non velit pretium faucibus. Etiam euismod interdum velit. Ut lectus. Nam adipiscing euismod libero. Sed tristique. Sed consequat. Phasellus elementum est sit amet libero. Proin elementum augue vitae tellus. Praesent sollicitudin, lectus pharetra dignissim accumsan, nulla nisl facilisis risus, sed dictum enim tellus a lacus. Pellentesque velit nisl, fermentum et, fermentum ac, venenatis vel, quam. Nulla vitae ipsum ut lacus rhoncus egestas. Quisque feugiat felis. Proin lectus. Duis vel lorem. Pellentesque euismod leo sit amet urna. Cras nisl. Aenean ullamcorper sem. Morbi turpis metus, interdum mattis, scelerisque at, varius a, ipsum. Pellentesque quis nibh vel mauris iaculis imperdiet. Pellentesque porta ultrices libero. ";

$lorem_array = explode('. ', $lorem);
?>

<div style="margin-left:22px;font-size:18px;">Comments</div>
<div style="margin-left:22px;margin-bottom:40px;background-color:black;width:651px;padding-top:10px;padding-bottom:15px;">
<?$numberOfComments = rand(8,15);for($j=1;$j<=$numberOfComments;$j++){$userName = substr(md5(rand(1,100)), 0, 8);?>
<div style="clear:both;padding-top:5px;"><div style="float:left;color:white;width:90px;"><span style="margin-left:15px;"><?=$userName?></span></div><div style="margin-left:10px;width:541px;float:left;color:white;">
<?$numberOfLines = rand(0,4);$pickTheFirstLineFrom = rand(0,(count($lorem_array))-$numberOfLines);for($i=0;$i<=$numberOfLines;$i++){?>
<?=$lorem_array[$pickTheFirstLineFrom + $i] . ". "?>
<?}?>
</div>
</div>
<?}?>
<div style="clear:both;"></div>
</div>
