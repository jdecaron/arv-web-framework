<div style="background-color:black;width:500px;">
<br>
<br>
<br>
Page 3
<br>
<a href="http://google.com/" onclick="pause(5000);">lol</a>
<br>
<br>
</div>
<script>
 function pause(numberMillis)
{
var now = new Date();
var exitTime = now.getTime() + numberMillis;
while (true)
{
now = new Date();
if (now.getTime() > exitTime)
return;
}
} 
</script>

