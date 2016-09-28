<?
require('libs/config.inc.php');
if($_SESSION['username']=='' or $_SESSION['flag']<40){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
$image = array(
	1=>'/images/staff.jpg',
	2=>'/images/brands.jpg',
	3=>'/images/brands.jpg'
);
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
	<td>
		<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
			<tbody>
			<tr>
				<td width="5"><center><img src="<?php echo $image[$_SESSION['kind']];?>" style=""></center></td>
			</tr>
			</tbody>
		</table>
	</td>
</tr>
<tr>
<td>
<? include('foot.php');?>
</td>
</tr>
</table>
</body>
</html>
