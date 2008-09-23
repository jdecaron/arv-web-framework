<?
include '/var/www/find-spots.com/include/php/class/site.php';
include '/var/www/find-spots.com/include/php/class/user.php';
?>

<div style="width:700px;background-color:white;">
<?
if(isset($_REQUEST['id'])){
echo <<<EOT
<div style="margin-left:23px;padding-top:40px;"><object width="400" height="300">   <param name="allowfullscreen" value="true" />   <param name="allowscriptaccess" value="always" />   <param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id={$_REQUEST['id']}&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" />   <embed src="http://vimeo.com/moogaloop.swf?clip_id={$_REQUEST['id']}&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="400" height="300"></embed></object></div>
EOT;
}
?>
<table width="677px" border="0" cellspacing="0" cellpadding="0" style="margin-left:23px;margin-top:20px;margin-bottom:40px;">
  <tr>
    <td style="padding-top:20px;"><a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=videos&id=1188206')))?>><img alt="thumbnail" style="width: 200px;border-style:none; height: 150px;" src="http://images.vimeo.com/82/27/43/82274374/82274374_200x150.jpg"/></a><br>MF-Episode17</td>
    <td style="padding-top:20px;"><a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=videos&id=1187907')))?>><img alt="thumbnail" style="width: 200px;border-style:none; height: 150px;" src="http://images.vimeo.com/82/24/10/82241063/82241063_200x150.jpg"/></a><br>MF-Episode16</td>
    <td style="padding-top:20px;"><a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=videos&id=1187537')))?>><img alt="thumbnail" style="width: 200px;border-style:none; height: 150px;" src="http://images.vimeo.com/82/23/50/82235046/82235046_200x150.jpg"/></a><br>MF-Episode15</td>
  </tr>
  <tr>
    <td style="padding-top:20px;"><a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=videos&id=1187207')))?>><img alt="thumbnail" style="width: 200px;border-style:none; height: 150px;" src="http://images.vimeo.com/82/17/09/82170920/82170920_200x150.jpg"/></a><br>MF-Episode14</td>
    <td style="padding-top:20px;"><a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=videos&id=1187075')))?>><img alt="thumbnail" style="width: 200px;border-style:none; height: 150px;" src="http://images.vimeo.com/82/16/07/82160796/82160796_200x150.jpg"/></a><br>MF-Episode13</td>
    <td style="padding-top:20px;"><a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=videos&id=1182591')))?>><img alt="thumbnail" style="width: 200px;border-style:none; height: 150px;" src="http://images.vimeo.com/81/69/88/81698812/81698812_200x150.jpg"/></a><br>MF-Episode12</td>
  </tr>
  <tr>
    <td style="padding-top:20px;"><a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=videos&id=1181872')))?>><img alt="thumbnail" style="width: 200px;border-style:none; height: 150px;" src="http://images.vimeo.com/81/66/84/81668447/81668447_200x150.jpg"/></a><br>MF-Episode11</td>
    <td style="padding-top:20px;"><a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=videos&id=1181451')))?>><img alt="thumbnail" style="width: 200px;border-style:none; height: 150px;" src="http://images.vimeo.com/81/58/17/81581763/81581763_200x150.jpg"/></a><br>MF-Episode10</td>
    <td style="padding-top:20px;"><a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=videos&id=1181350')))?>><img alt="thumbnail" style="width: 200px;border-style:none; height: 150px;" src="http://images.vimeo.com/81/56/60/81566027/81566027_200x150.jpg"/></a><br>MF-Episode09</td>
  </tr>
</table>
</div>
