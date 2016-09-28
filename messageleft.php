<?php 
##已读数
$sql = "SELECT count(`id`) AS count FROM `message_map` WHERE to_id = {$userid} AND is_read = 'Y' ";
$haveRead = mysql_fetch_assoc(mysql_query($sql));
##未读数
$sql = "SELECT count(`id`) AS count FROM `message_map` WHERE to_id = {$userid} AND is_read = 'N' ";
$noRead = mysql_fetch_assoc(mysql_query($sql));
##已解决数
$sql = "SELECT count(id) AS count FROM (SELECT m.id,is_solve FROM `message_map` AS m INNER JOIN message_content AS c ON m.content_id = c.id WHERE m.from_id = {$userid} AND is_solve = 'Y' GROUP BY content_id ) T";
$solve = mysql_fetch_assoc(mysql_query($sql));
##未解决数
$sql = "SELECT count(id) AS count FROM (SELECT m.id,is_solve FROM `message_map` AS m INNER JOIN message_content AS c ON m.content_id = c.id WHERE m.from_id = {$userid} AND is_solve = 'N' GROUP BY content_id ) T";
$noSolve = mysql_fetch_assoc(mysql_query($sql));
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="450" background="images/leftbg.jpg">
<tr>
<td valign="top">
<div id="nav">
	<div class="title"><img src="images/close.gif" id='pic1' alt="" onClick="msgchange(1)">&nbsp;<a href="message.php" onClick="msgchange(1)">收件箱</a></div>
	<ul id="ul1">
		<li><img src="images/dot.gif" alt="">&nbsp;<a href="message.php?todo=from&type=Y">已读（<?php echo intval($haveRead["count"]);?>）</a></li>
		<li><img src="images/dot.gif" alt="">&nbsp;<a href="message.php?todo=from&type=N">未读（<?php echo intval($noRead["count"]);?>）</a></li>
	</ul>
	<div class="title"><img src="images/close.gif" id='pic2' alt="" onClick="msgchange(2)">&nbsp;<a href="message.php?todo=send" onClick="msgchange(2)">发件箱</a></div>
	<ul id="ul2">
		<li><img src="images/dot.gif" alt="">&nbsp;<a href="message.php?todo=send&type=Y">已解决（<?php echo intval($solve["count"]);?>）</a></li>
		<li><img src="images/dot.gif" alt="">&nbsp;<a href="message.php?todo=send&type=N">未解决（<?php echo intval($noSolve["count"]);?>）</a></li>
	</ul>
	
</div>
</td></tr>
</table>
<script>
function msgchange(n)
{
	for(i=1;i<3;i++)
	{
		if(i==n){
			if(document.getElementById("ul"+i).className=='display1'){
				document.getElementById('pic'+i).src='images/close.gif';
				document.getElementById("ul"+i).className='display2';
				for(j=1;j<3;j++){
					if(j!=i){
						if(document.getElementById('pic'+j)){
							document.getElementById('pic'+j).src='images/open2.gif';
							document.getElementById("ul"+j).className='display1';
						}else{ continue;}
					}
				}
			}else if(document.getElementById("ul"+i).className=='display2'){
				document.getElementById('pic'+i).src='images/open2.gif';
				document.getElementById("ul"+i).className='display1';
			}
		}
	}
}
</script>