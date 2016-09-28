<?
require('libs/config.inc.php');
if($_SESSION['username']=='' or $_SESSION['flag']<40){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['kind'] == 2 or $_SESSION['kind'] == 3)
{
	mysql_close($conn);
	header('location:message.php');
	exit;
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>映诺热线数据库查询系统</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td bgcolor="#F28202">
<? include('head.php');?>
</td>
</tr>
<tr>
<td height="5"></td>
</tr>
<tr>
<td><table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="5">&nbsp;</td>
<td width="201" valign="top"  class="leftsty"><table border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td width="17"><img src="images/icon09.jpg" width="9" height="13"></td>
<td width="146"><div class="title01">电话脚本 </div></td>
<td width="16"><img src="images/icon11.jpg" border="0"></td>
<td width="7" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="450" background="images/leftbg.jpg">
<tr>
<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="10"></td>
</tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="leftsub">
<tr>
<td width="93%" height="25">·<a href="index.php">工作准备</a></td>
</tr>
<tr>
<td width="93%" height="25">·<a href="index.php?leixing=1">电话脚本</a></td>
</tr>
<tr>
<td width="93%" height="25">·<a href="index.php?leixing=2">沟通问题</a></td>
</tr>
<tr>
<td width="93%" height="25">·<a href="index.php?leixing=3">咨询映诺</a></td>
</tr>
<tr>
<td width="93%" height="25">·<a href="index.php?leixing=4">申诉咨询</a></td>
</tr>
<tr>
<td width="93%" height="25">·<a href="index.php?leixing=5">心理适用</a></td>
</tr>
<tr>
<td width="93%" height="25">·<a href="index.php?leixing=6">求助映诺</a></td>
</tr>
</table>
</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</table></td>
<td width="5" valign="middle"><img src="images/btnleft.jpg" width="5" height="117" border="0"></td>
<td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td><div class="title01">电话脚本</div></td>
<td width="28"><img src="images/icon12.jpg"  border="0"></td>
<td width="5" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rightcon">
<tr>
<td height="565" align="left" valign="top">

	<table border="0" cellspacing="0" cellpadding="0">
<?
	if($_SESSION['flag'] > 95){
?>	
	<tr>
	<td width="10">&nbsp;</td>
	<td>&nbsp;</td>
	<td width="10">&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td>

<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="70"><a href="addtitle.php"><img src="images/btnnew.jpg" width="70" height="24"></a></td>
<td width="70"><a href="admintitle.php"><img src="images/btnedit.jpg" width="70" height="24"></a></td>
<td width="143" align="right">&nbsp; </td>
<td width="352">&nbsp; </td>
<td width="71">&nbsp; </td>
</tr>
</table>

</td>
<td></td>
</tr>
<?	}?>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td></td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="left">
<?
if(intval($_GET['leixing']) < 1){
?>
<table width="1000" border="0" cellpadding="6" cellspacing="0" class="datatable">
<tr>
<td width="100" height="32" align="center" background="images/line03.jpg"><strong>工作准备</strong></td>
<td background="images/line03.jpg"><strong></strong></td>
</tr><?
	$count = 1;
	$rs = mysql_query("select title from title where xianshi=1 and leixing=0 order by titleid asc");
	while($row = mysql_fetch_array($rs, MYSQL_ASSOC))
	{
?>
<tr>
<td <? if(intval($count/2) == $count/2){?>class="graybg"<? }?>  height="28" align="left"  colspan='2' style="line-height:160%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $row['title'];?></td>
</tr>
<?
    	$count = $count + 1;
	}mysql_free_result($rs);
?>
</table>
<?	}else{?>
<table width="1000" border="0" cellpadding="6" cellspacing="0" class="datatable">
<tr>
<td width="100" height="32" align="center" background="images/line03.jpg"><strong><? if(intval($_GET['leixing']) == 1){ ?>电话脚本<? }else if(intval($_GET['leixing']) == 2){?>沟通问题<? }else if(intval($_GET['leixing']) == 3 ){ ?>咨询映诺<? }else if(intval($_GET['leixing']) == 4){ ?>申诉咨询<? }else if(intval($_GET['leixing']) == 5){?>心理适用<? }else if(intval($_GET['leixing']) == 6){?>求助映诺<? }?></strong></td>
<td  background="images/line03.jpg"><strong></strong></td>
</tr>
<?
	$count = $count + 1;
	$sql = 'select title from title where xianshi=1 and leixing=' . intval($_GET['leixing']) . ' order by titleid asc';
	$rs = mysql_query($sql);
	while($row = mysql_fetch_array($rs, MYSQL_ASSOC))
	{
?>
<tr>
<td <? if(intval($count/2) == $count/2){?>class="graybg"<? }?>  height="28" align="left"  colspan='2' style="line-height:160%;"><? echo htmlspecialchars_decode($row['title']);?></td>
</tr>
<?
    	$count = $count + 1;
	}
?>
</table>
<?	}?>
</td>
<td></td>
</tr>
</table></td>
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
<td>
<? include('foot.php');?>
</td>
</tr>
</table>
</body>
</html>
