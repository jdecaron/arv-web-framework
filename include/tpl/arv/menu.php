<?
include '/var/www/arv/include/php/class/site.php';
include '/var/www/arv/include/php/class/user.php';
?>
<div style="background-color:black;width:1000px;height:42px;font-size:18px;">
<div style="padding-top:9px;padding-left:21px;">
<a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=index', 'style' => 'text-decoration:none;color:white;')))?>>Home</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=photos', 'style' => 'text-decoration:none;color:white;')))?>>Photos</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=videos', 'style' => 'text-decoration:none;color:white;')))?>>Videos</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="http://github.com/550/arv-web-framework/tree" style="color:white;text-decoration:none;">Download</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<!--<a <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=contact', 'style' => 'text-decoration:none;color:white;')))?>>Contact</a>-->
</div>
</div>
