<?
require('libs/config.inc.php');
if($_SESSION['username'] == '' or $_SESSION['flag'] < 40){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>个案管理与生成=>个案列表</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name=keywords content="个案管理与生成=>个案列表">
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
<td><table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0"  >
<tr>
<td width="5">&nbsp;</td>
<td width="201" valign="top" class="leftsty">

<table border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td width="17"><img src="images/icon09.jpg" width="9" height="13"></td>
<td width="146"><div class="title01">个案管理与生成 </div></td>
<td width="16"><img src="images/icon11.jpg"  border="0"></td>
<td width="7" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<? include('caseleft.php')?>
</td>
<td width="5" valign="middle"><img src="images/btnleft.jpg"  width="5" height="117" border="0"></td>
<td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td><div class="title01">个案列表</div></td>
<td width="28"><a href="#"><img src="images/icon12.jpg"  border="0"></a></td>
<td width="5" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rightcon">
<tr>
<td height="565" align="left" valign="top"><table border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td height="20">&nbsp;</td>
<td></td>
<td></td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="center">
<?
$gongchangid = $_GET['gongchangid'] + 0;
if($gongchangid > 0)
{
	$sql = 'select gongchangcode from gongchang where gongchangid=' . $gongchangid;
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	$gongchangcode = $row['gongchangcode'];
	$param = 'gongchangid=' . $gongchangid;
	$cond = 'where gongchangcode="' . $gongchangcode . '"';
}
else
{
	mysql_close($conn);
	echo '<center>没有相关案例</center>';
	exit;
}
/*
else if($_SESSION['flag'] > 90)
{
	$param = '';
	$cond = '';
}*/


?>
<input type="hidden" name="param" id="param" value="<? echo $param;?>" />
<table width="1000" align="center" border="1" cellpadding="3" cellspacing="0" class="datatable">
<tr height="30" align="center">
	<td class="b1 titsty">个案编号</td>
	<td class="b1 titsty">反映日期</td>
	<td class="b1 titsty">品牌名称</td>
	<td class="b1 titsty">品牌编码</td>
	<td class="b1 titsty">工厂名称</td>
	<td class="b1 titsty">工厂编码</td>
	<td class="b1 titsty">BAS分色</td>
	<td class="b1 titsty" width="15%">操作</td>
</tr>
<?
$kind = $_SESSION['kind'];
$sql1 = 'select count(caseid) from case_table ' . $cond;
if($kind <> 1){
	$sql1 = $sql1 . ' and pinpaicode="' . $_SESSION['pinpaicode'] . '"';
}

$rs = mysql_query($sql1);
$row = mysql_fetch_row($rs);
if($row[0] > 0)
{
	$total=$row[0];
	$pageSize=20;	//分页程序中每页显示数据的数量;
	$fenyeObj=new Fenye($param,$pageSize,$total);	//创建分页对象
	
	$sqlstr = 'select caseid,case_code,dateandtime,shijianleixing,pinpainame,pinpaicode,gongchangname,gongchangcode,add_date from case_table ' . $cond;
	if($kind == 1){
		$sql2 = $sqlstr . ' order by caseid desc limit ' . ($fenyeObj->page-1)*$pageSize.','.$pageSize;
	}else if($kind == 2){
		$sql2 = $sqlstr . ' and pinpaicode="' . $_SESSION['pinpaicode'] . '" order by caseid desc limit ' . ($fenyeObj->page-1)*$pageSize.','.$pageSize;
	}else if($kind == 3){
		$sql2 = $sqlstr . ' and pinpaicode="' . $_SESSION['pinpaicode'] . '" and gongchangcode="' . $_SESSION['gongchangcode'] . '" order by caseid desc limit ' . ($fenyeObj->page-1)*$pageSize.','.$pageSize;
	}
	$rs = mysql_query($sql2);
	while($row = mysql_fetch_array($rs,MYSQL_ASSOC))
	{
?>
<tr align="center" height="28">
<td align="left">&nbsp;&nbsp;<a href="case.php?caseid=<? echo $row['caseid'];?>" target="_blank"><? echo $row['case_code'];?></a><? if(($_SESSION['pinpaicode'] == $row['pinpaicode'] or $_SESSION['gongchangcode'] == $row['gongchangcode']) and $_SESSION['lastlogindate'] < $row['add_date']){?>&nbsp;<img src="images/new2.gif" alt="new" align="absbottom"><? }?></td>
<td><? echo date('Y-m-d',$row['dateandtime']);?></td>
<td><? echo $row['pinpainame'];?></td>
<td><? echo $row['pinpaicode'];?></td>
<td><? echo $row['gongchangname'];?></td>
<td><? echo $row['gongchangcode'];?></td>
<td><? echo get_color($row['shijianleixing']);?></td>
<td><a href="case.php?caseid=<? echo $row['caseid'];?>" target="_blank">查看</a><? if($_SESSION['flag'] > 91){?>&nbsp;&nbsp;<a href="editcase.php?caseid=<? echo $row['caseid'];?>">修改</a>&nbsp;&nbsp;<a href="case_adminsave.php?action=del&caseid=<? echo $row['caseid'];?>" onClick="if(confirm('确定删除吗?')==false){ return false;}">删除</a><? }?></td>
<?
	}mysql_free_result($rs);
?>
  <tr height="28" align="center">
  <td colspan="8"><? $fenyeObj->fenyeFoot();unset($fenyeObj);?></td>
  </tr>
<?
}else{ echo "<tr align='center' height='28'><td colspan='8'>没有相关案例</td></tr>";}
?>
</table>
<script type="text/javascript">
function pageTrans(p)
{
	var v = document.getElementById('param').value;
	if(v == ''){ location="?page="+p;}else{ location="?"+v+"&page="+p;}
}
</script>

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
