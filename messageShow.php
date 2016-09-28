<?
	require('libs/config.inc.php');
	if($_SESSION['username']==''){
		mysql_close($conn);
		header('location:login.php');
		exit;
	}
	if($_SESSION['flag']<40 or $_SESSION['flag'] == 91){
		mysql_close($conn);
		echo '您权限不足，请使用有权限的用户名称进行登录';
		exit;
	}
	$userid = $_SESSION['userid'];
	$username = $_SESSION['username'];
	$kind = $_SESSION['kind'];
	$pinpaicode = $_SESSION['pinpaicode'];
	$gongchangcode = $_SESSION['gongchangcode'];
	$pinpainame = $_SESSION['pinpainame'];
	$gongchangname = $_SESSION['gongchangname'];
	$id = intval($_GET["id"]);
	if($id == 0){
		header("Location:/message.php");
		exit();
	}
	$sql = "SELECT m.from_id,m.to_id,c.title,c.content,c.attachment,c.is_solve,c.solvetime,c.createtime,u.username,u2.username as 2username FROM `message_map` AS m INNER JOIN message_content AS c ON m.content_id = c.id INNER JOIN user AS u ON m.from_id = u.userid INNER JOIN user AS u2 ON m.to_id = u2.userid WHERE content_id = '{$id}'";
	$query = mysql_query($sql);
	$message = array();
	while($row = mysql_fetch_assoc($query)){
		$message["from_id"] = $row["from_id"];
		$message['title'] = $row["title"];
		$message["content"] = $row["content"];
		$message['username'] = $row['username'];
		$to_username[] = $row["2username"];
		$message["to_username"][] = $row["2username"];
		$message["createtime"] = $row["createtime"];
		$message["is_solve"] = $row["is_solve"];
		$message["attachment"] = $row["attachment"];
	}
?>
<html>
<HEAD>
<TITLE>留言=>查看留言</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="留言=>查看留言">
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td bgcolor="#F28202"><? include('head.php');?></td>
</tr>
<tr>
<td height="5"></td>
</tr>
<tr><td>
<table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="5">&nbsp;</td>
<td width="201" valign="top" class="leftsty">
<table border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td width="17"><img src="images/icon09.jpg" width="9" height="13"></td>
<td width="146"><div class="title01">留言 </div></td>
<td width="16"><img src="images/icon11.jpg"  border="0"></td>
<td width="7" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<? include('messageleft.php');?></td>
<td width="5" valign="middle"><img src="images/btnleft.jpg" width="5" height="117" border="0"></td>
<td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td><div class="title01">查看留言</div></td>
<td width="28"><img src="images/icon12.jpg"  border="0"></td>
<td width="5" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rightcon">
<tr>
<td height="565" align="left" valign="top">

<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
<tr height="10"><td></td></tr>
<tr>
	<td><a href="addmessage.php"><img src="images/btnnew.jpg" width="70" height="24" alt="新增" title="新增留言"></a></td>
</tr>
<tr height="10"><td></td></tr>
<tr>
<td align="center">
<div id="msgwrap">
	<div class="msghead">
		<div class="title"><strong><? echo $_GET["id"];?></strong>.<font class="msgfont"><? echo $message["username"];?></font> 于 <? echo date('Y-m-d H:i:s',$message['createtime']);?>添加的留言<? if($message['is_read']=='N'){ ?>&nbsp;<img src="images/new2.gif" alt="new" align="absbottom"><? }?></div>
		<span class="martop" id="is_solve"><? if($message['is_solve']=='Y'){ echo "<font class='msgcolor3'>已解决</font>";}else{ if($message["from_id"] == $userid){?>[<font class="msgcolor2"><a href="javascript:void(0)" class="msglink" onClick="if(confirm('确定设为已解决吗?')==false){ return false;}else{ msgAjax(<?php echo $_GET['id'];?>);}">点击设为已解决</a></font>]<? }else{ echo '<font class="msgcolor2">待解决</font>';}}?></span>
		<span><a href="/model/<?php echo $message["attachment"];?>" target="_blank"><img src="images/addi.jpg" alt="附件表" title="附件表" class="imgstyle"></a></span>
		<span><img src="images/reply.png" alt=""/>&nbsp;[<a href="#q_reply" onclick="changeInput();$('#content').focus();">回复</a>]</span>
	</div>
	<div class="msgtitle"><strong>收件人：</strong><font><? echo implode(",",$message["to_username"]);?></font></div>
	<div class="msgtitle"><strong>标题：</strong><font><? echo $message['title'];?></font></div>
	<div class="msgcontent"><strong>内容：</strong><? echo $message['content'];?></div>
	<?php 
		$sql = "SELECT m.from_id,m.content_id,c.createtime,c.title,c.content,c.attachment,u.username FROM message_map AS m INNER JOIN message_content AS c ON m.content_id = c.id INNER JOIN user AS u ON m.from_id = u.userid WHERE parent_id = {$id} GROUP BY content_id ORDER BY c.createtime DESC ";
		$query = mysql_query($sql);
		while($row = mysql_fetch_assoc($query)){
	?>
	<div class="reply">
		<div class="replyhead">
			<div class="title"><strong><? echo $row['username'];?>（<?php echo $row["title"]?>）：</strong><? echo date('Y-m-d H:i:s',$row['createtime']); if($row['is_read']=='N'){ ?>&nbsp;<img src="images/new2.gif" alt="new" align="absbottom"><? }?></div>
			<span><a href="msgadditional.php?k=<? echo $k;?>&sort=all&rid=<? echo $row['rid'];?>" target="_blank"><img src="images/addi.jpg" alt="附件表" title="附件表" class="imgstyle"></a></span>
		</div>
		<div class="replycontent"><? echo $row['content'];?></div>
	</div>
	<?php 	
		}
	?>
	<div class="vBlock"></div>
</div>
<div style="margin-top:15px;" id="q_reply">
<input type="text" value="快速回复。。。" style="width:1000px;" onclick="changeInput();" />
</div>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
var sendObj = '<?php echo implode(";",$message["to_username"]);?>';
var title = '回复：<?php echo $message['title'];?>';
var parent_id = '<?php echo $_GET["id"];?>';
function changeInput(){
	var content = 
		'<form name="" method="post" action="/model/message.php?action=addmsg" enctype="multipart/form-data">'+
			'<p style="text-align:left;">标题：<input type="text" name="title" value="'+title+'" style="width:800px;"/></p>'+
			'<textarea style="width:1000px;height:90px;" id="content" name="content"></textarea>'+
			'<p style="text-align:left;">附件：<input type="file" name="file" /></p>'+
			'<input type="hidden" value="'+sendObj+'" name="sendObj" />'+
			'<input type="hidden" value="'+parent_id+'" name="parent_id" />'+
			'<p style="text-align:left;"><input type="submit" value="回复" /></p>'+
		'</form>';
	$("#q_reply").html(content);
	$("#content").focus();
}
function msgAjax(id){
	$.ajax({
			url:"/model/message.php?action=setSolve",
			data:"id="+id,
			type:"GET",
			dataType:"json",
			success:function(data){
				if(data["result"]>0){
					$("#is_solve").html("<font class='msgcolor3'>已解决</font>");
				}else{
					alert("设置失败，请重试。");
					windown.location.href=windown.location.href;
				}
			}
		})
}
</script>
</td></tr></table>
</td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/rightbbg.jpg">
<tr>
<td width="5" align="left"><img src="images/rightbleft.jpg" width="5" height="22"></td>
<td width="10">&nbsp;</td>
<td>&nbsp;</td>
<td width="28">&nbsp;</td>
<td width="5" align="right"><img src="images/rightbright.jpg" width="5" height="22"></td>
</tr>
</table></td>
<td width="5">&nbsp;</td>
</tr>
</table></td>
</tr>
<tr>
<td><? 
	##设为已读
	$q = mysql_query("UPDATE message_map SET is_read = 'Y',readtime = '".time()."' WHERE to_id = '{$userid}' AND (content_id = '{$id}' OR parent_id = '{$id}')");
	include('foot.php');
?></td>
</tr>
</table>
</body>
</html>