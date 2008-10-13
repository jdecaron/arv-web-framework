<?
include '/var/www/arv/include/php/class/site.php';
include '/var/www/arv/include/php/class/user.php';
?>

<div style="width:650px;height:300px;margin-left:20px;">
<h1>Test Page</h1>
<a style="color:green;" <?=siteTools::generateAnchorAttributes(array('attributes' => array('href' => 'page=photos')))?>>this link to the photo page</a>
<br><br>
<a <?=siteTools::generateAnchorAttributes(array('attributes' => array('style' => 'color:red;', 'href' => 'page=testpage&testvar=333&var33=123echo&othervar=value')))?>>redirect self</a>
<pre><?print_r($_GET)?></pre>
</div>
