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
?>
<html>
<HEAD>
<TITLE>留言=>附件表</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="留言=>附件表">
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
<? include('messageleft.php');?>
</td>
<td width="5" valign="middle"><img src="images/btnleft.jpg" width="5" height="117" border="0"></td>
<td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td><div class="title01">附件表</div></td>
<td width="28"><img src="images/icon12.jpg"  border="0"></td>
<td width="5" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>



<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rightcon">
<tr>
<td height="565" align="left" valign="top">



<table border="0" cellspacing="0" cellpadding="0" align="center">
<tr height="10"><td></td></tr>
<tr>
	<td><a href="addmessage.php"><img src="images/btnnew.jpg" width="70" height="24" alt="新增" title="新增留言"></a></td>
</tr>
<tr height="10"><td></td></tr>
<tr>
<td align="left">
<?
$k=isset($_GET['k']) ? $_GET['k']+0 : '';

if($_SESSION['kind']==1){
	$condit1='';
}else if($_SESSION['kind']==2){
	$condit1=" and (( q_uid=$userid or r_uid=$userid ) or ( q_kind=3 and q_pinpai='$pinpaicode' ) or ( r_kind=3 and r_pinpai='$pinpaicode' ))";
}else if($_SESSION['kind']==3){
	$condit1=" and ( q_uid=$userid or r_uid=$userid )";
}
	
if($_GET['mid']){
	$mid=$_GET['mid']+0;
	$condit2='mid='.$mid;
	$title='留言标题';
	$class=1;
}else if($_GET['rid']){
	$rid=$_GET['rid']+0;
	$condit2='rid='.$rid;
	$title='回复内容';
	$class=2;
}
$condit=$condit2.$condit1;
?>
<table width="1000" align="center" border="1" bordercolor="#dedfe0"  cellpadding="0" cellspacing="0" class="datatable">
  <tr height="30" align="left" >
   <td class="b1 titsty">&nbsp;ID</td>
   <td class="b1 titsty" width="330">&nbsp;<? echo $title;?></td>
   <td class="b1 titsty">&nbsp;文件名</td>
   <td class="b1 titsty">&nbsp;url</td>
   <td class="b1 titsty">&nbsp;文件大小</td>
  </tr>
<?
$rs=mysql_query("select count(fid) from additional_table where $condit");
$row=mysql_fetch_row($rs);
if($row[0]>0)
{
	$rs=mysql_query("select * from additional_table where $condit");
	while($row=mysql_fetch_array($rs,MYSQL_ASSOC))
	{
		if($class==1){
			$mid=$row['mid'];
			$sql2="select mid,q_title from message_table where mid=$mid";
		}else if($class==2){
			$rid=$row['rid'];
			$sql2="select mid,reply_content from reply_table where rid=$rid";
		}
		
		$rs2=mysql_query($sql2);
		$row2=mysql_fetch_array($rs2,MYSQL_ASSOC);
?>
  <tr height="28" align="left">
   <td bgcolor="<? echo $color;?>">&nbsp;<? echo $row['fid'];?></td>
   <? if($class==1){?>
   <td bgcolor="<? echo $color;?>">&nbsp;<a href="messageShow.php?k=<? echo $k;?>&sort=all&mid=<? echo $row2['mid'];?>" title="<? echo $row2['q_title'];?>"><? if(strlen($row2['q_title'])>50){ echo mid_str($row2['q_title'],0,50); }else{ echo $row2['q_title'];}?></a></td>
   <? }else if($class==2){?>
   <td bgcolor="<? echo $color;?>">&nbsp;<a href="messageShow.php?k=<? echo $k;?>&sort=<? echo $sort;?>&mid=<? echo $row2['mid'];?>" title="<? echo $row2['reply_content'];?>"><? if(strlen($row2['reply_content'])>50){ echo mid_str($row2['reply_content'],0,50); }else{ echo $row2['reply_content'];}?></a></td>
   <? }?>
   <td bgcolor="<? echo $color;?>">&nbsp;<img src="<? echo showfilepic($row['type']);?>" />&nbsp;<a href="<? echo $row['url'];?>" target="_blank"><? echo $row['filename'];?></a></td>
   <td bgcolor="<? echo $color;?>">&nbsp;<? echo $row['url'];?></td>
   <td bgcolor="<? echo $color;?>">&nbsp;<? echo $row['size'].'KB';?></td>
  </tr>
<?
	}
	
	
}
else
{
?>
	<tr height="30" align="center"><td bgcolor="#fafafa" colspan="5">没有找到相关附件</td></tr>
<?
}
?>
</table>

</td>
<td></td>
</tr>
</table>

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
<td><? include('foot.php');?></td>
</tr>
</table>
</body>
</html>