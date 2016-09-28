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
<TITLE>查询系统管理=>邮件管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="查询系统管理=>邮件管理">
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
<td width="146"><div class="title01">邮件管理 </div></td>
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
<td><div class="title01">邮件管理</div></td>
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
<?
$rs = mysql_query("select * from email where id=1");
$row = mysql_fetch_array($rs,MYSQL_ASSOC);
if($row)
{
?>
<form method="post" name="myform" action="adminmailsave.php?action=edit&id=<? echo $row['id'];?>" onSubmit="return FormCheck(myform)">
<table width="600" border="1" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0" class="datatable">
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa" width="25%">发件人名称：</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="title"  size="30" value="<? echo $row['title'];?>"></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa" width="25%">发件人邮件账号：</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="username"  size="30" value="<? echo $row['username'];?>"></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa">发件人邮件密码：</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="passwd"  size="30" value="<? echo $row['passwd'];?>"></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa">SMTP地址：</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="smtp"  size="30" value="<? echo $row['smtp'];?>">
	</td>
  </tr>
  <tr height="28" align="center">
   <td class="b1">&nbsp;</td>
   <td align="left">&nbsp;<INPUT type="submit" class="inBg3" value=" 修改 "  name="Submit" ></td>
  </tr>
</table>
</form>
<?
}else{ echo '<center>',$tip,'</center>';}
?>
</td>
<td></td>
</tr>
</table></td>
</tr>
</table>
<script type="text/javascript">
function trim(str){ return str.replace(/(^\s*)|(\s*$)/g, "");}
function FormCheck(form)
{
	var title=trim(form.title.value);
	var username=trim(form.username.value);
	var passwd=trim(form.passwd.value);
	var smtp=trim(form.smtp.value);
	if(title==''){
		alert("发件人名称不能为空！");
		form.title.focus();
		return false;
	}
	if(username==''){
		alert("发件人邮件账号不能为空！");
		form.username.focus();
		return false;
	}
	if(passwd==''){
		alert("发件人邮件密码不能为空！");
		form.passwd.focus();
		return false;
	}
	if(smtp==''){
		alert("SMTP地址不能为空！");
		form.smtp.focus();
		return false;
	}
}
</script>
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