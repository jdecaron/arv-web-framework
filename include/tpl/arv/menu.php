<?
include '/var/www/arv/include/php/class/site.php';
include '/var/www/arv/include/php/class/user.php';
?>
<div style="background-color:black;width:1000px;font-size:18px;">
<div style="height:33px;padding-top:9px;margin-left:22px;!height:37px;">
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
<div style="background-color:#547da1;color:white;width:1000px;font-size:18px;"><div style="width:700px;font-size:16px;31px;margin-left:22px;padding-top:11px;padding-bottom:11px;">
*It appear that there are some bugs remaining. Like deep linking for Konqueror and Midori. Otherwise you can test pretty much everything on this site.
</div></div>
</div>
