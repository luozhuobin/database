<?
	require('libs/config.inc.php');
	if($_SESSION['username']==''){
		mysql_close($conn);
		header('location:login.php');
		exit;
	}
	if($_SESSION['flag']<91){
		mysql_close($conn);
		echo '您权限不足，请使用有权限的用户名称进行登录';
		exit;
	}
?>
<html>
<HEAD>
<TITLE>查看品牌</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="查看品牌">
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<br>
<br>
<?
$pinpai_id=$_GET['pinpai_id']+0;
$page = $_GET['page'] + 0;
$sql='select * from pinpai where pinpai_id='.$pinpai_id;
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs, MYSQL_ASSOC);
if($row)
{
	mysql_free_result($rs);
?>
<table width="600" border="1" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0" class="datatable">
<tr height="30">
	<td width="25%" align="right" class="b1">品牌名称：</td>
	<td align="left">&nbsp;<? echo $row['pinpainame'];?></td>
</tr>
<tr height="30">
	<td  align="right" class="b1">所在城市：</td>
	<td align="left">&nbsp;<? echo $row['cityname'];?></td>
</tr>
<tr height="30">
	<td  align="right" class="b1">品牌编码：</td>
	<td align="left">&nbsp;<? echo $row['pinpaicode'];?></td>
</tr>
<tr height="30">
	<td  align="right" class="b1">品牌地址：</td>
	<td align="left">&nbsp;<? echo $row['pinpaidizhi'];?></td>
</tr>
<tr height="30">
	<td  align="right" class="b1">联系电话：</td>
	<td align="left">&nbsp;<? echo $row['pinpaidianhua'];?></td>
</tr>
<tr height="30">
	<td  align="right" class="b1">联系人：</td>
	<td align="left">&nbsp;<? echo $row['lianxiren'];?></td>
</tr>
<? if($_SESSION['flag']>95){ ?>
<tr height="30">
	<td  align="right" class="b1">管理选项：</td>
	<td align="left">&nbsp;<a href="editpinpai.php?pinpai_id=<? echo $row['pinpai_id'];?>&page=<? echo $page;?>" target="_top">修改</a> </td>
</tr>
<?	}?>
</table>
<?
}else{ echo '找不到相关数据或您没有相关权限查看';}
mysql_close($conn);
?>

</body>
</html>