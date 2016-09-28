<?
require('libs/config.inc.php');
if($_SESSION['username'] == '')
{
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag'] < 98)
{
	mysql_close($conn);
	echo '您权限不足，请使用有权限的用户名称进行登录';
	exit;
}
?>
<html>
<HEAD>
<TITLE>查询系统管理=>用户管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="查询系统管理=>用户管理">
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
<td width="146"><div class="title01">系统管理 </div></td>
<td width="16"><img src="images/icon11.jpg"  border="0"></td>
<td width="7" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<? include('adminleft.php')?>
</td>
<td width="5" valign="middle"><img src="images/btnleft.jpg"  width="5" height="117" border="0"></td>
<td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td><div class="title01">用户管理</div></td>
<td width="28"><a href="#"><img src="images/icon12.jpg"  border="0"></a></td>
<td width="5" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rightcon">
<tr>
<td height="565" align="left" valign="top"><table border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td width="10">&nbsp;</td>
<td>&nbsp;</td>
<td width="10">&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="center">
<a href="adduser.php">添加新用户</a>
<br><br>
<table width="600" align="center" border="1" bordercolor="#dedfe0"  cellpadding="0" cellspacing="0" class="datatable">
  <tr height="30" align="center" >
   <td class="b1 titsty">用户名称</td>
   <td class="b1 titsty">用户密码</td>
   <td class="b1 titsty">在职状态</td>
   <td class="b1 titsty">权限</td>
   <td class="b1 titsty" width="15%">操作</td>
  </tr>
<?
$rs = mysql_query("select count(userid) from user");
$row = mysql_fetch_row($rs);
if($row[0] > 0)
{
	$total=$row[0];
	$pageSize=20;	//分页程序中每页显示数据的数量;
	$fenyeObj=new Fenye('',$pageSize,$total);	//创建分页对象
	$rs = mysql_query("select userid,username,userpass,flag,work from user order by userid asc limit ".($fenyeObj->page-1)*$pageSize.','.$pageSize."");
	while($row = mysql_fetch_array($rs,MYSQL_ASSOC))
	{
?>
  <tr height="28" align="center">
   <td><? echo $row['username'];?></td>
   <td><? echo $row['userpass'];?></td>
   <td><? if($row['work'] == 1){ echo '在职';}else{ echo '离职';}?></td>
   <td><? echo $row['flag'];?></td>
   <td><a href="edituser.php?userid=<? echo $row['userid'];?>&page=<? echo $fenyeObj->page;?>">修改</a>&nbsp;&nbsp;<a href="adminusersave.php?action=del&userid=<? echo $row['userid'];?>&page=<? echo $fenyeObj->page;?>" onClick="if(confirm('确定删除吗?')==false){ return false;}">删除</a></td>
  </tr>
<?
	}mysql_free_result($rs);
?>
  <tr height="28" align="center" bgcolor="#fafafa">
  <td colspan="5"><? $fenyeObj->fenyeFoot();unset($fenyeObj);?></td>
  </tr>
<?
}else{ echo "<tr align='center' height='28'><td colspan='5'>".$tip."</td></tr>";}
?>
</table>
<script type="text/javascript">
function pageTrans(p)
{
	location="?page="+p;
}
</script>
<br><br>
说明：权限值定义为：99为最高的系统管理员权限，98为程序员或测试员权限，95为映诺主管权限，91为映诺普通员工权限，50为品牌权限，40为工厂权限.<br>
某个用户不用的时候，设置成离职就行的，尽量不要去删除用户，离职状态的用户将不能再登陆系统;用户admin将不能被删除。
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

  