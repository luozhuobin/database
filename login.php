<?

session_start();
$chknum = mt_rand(1000,9999);	//随机数
$_SESSION['chknum'] = $chknum;

if($_SESSION['userid'] and $_SESSION['username'])
{
	if($_SESSION['kind'] == 1){
		header("location:index.php");
		exit;
	}else{
		header("location:message.php");
		exit;
	}
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>映诺热线数据库登录页面</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table height="100%" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="center" valign="middle">
<table width="504" height="300" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="left" valign="top" background="images/loginbg.jpg"><table height="300" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="7" height="50"></td>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td height="126"></td>
<td colspan="2"><img src="images/loginimage.jpg" width="487" height="126" /></td>
</tr>
<tr>
<td height="112"></td>
<td width="186">&nbsp;</td>
<td width="301" align="left" valign="top">

<form name="loginform" method="post" action="login_check.php?action=login" onSubmit="return FormCheck(loginform)"> 
<table width="94%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="6" height="20">&nbsp;</td>
<td width="50">&nbsp;</td>
<td colspan="2">&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td height="25">&nbsp;</td>
<td class="font01">用户名：</td>
<td colspan="2"><input name="username" type="text" tabindex="1" value="" class="input01" /></td>
<td><input name="Submit" type="Submit" value="" class="input06" /></td>
</tr>
<tr>
<td height="25">&nbsp;</td>
<td class="font01">密&nbsp;&nbsp;码：</td>
<td colspan="2"><input name="pwd" type="password" value="" tabindex="2" class="input01" /></td>
<td><input name="reset" type="reset" value="" class="input07" /></td>
</tr>
<tr>
<td height="25">&nbsp;</td>
<td class="font01">验证码：</td>
<td width="77"><input  type="text" name="chknum" id="chknum" maxlength="4" size="8" tabindex="3" class="input02"/></td>
<td width="66"><input  name="" type="button" value="<? echo $_SESSION['chknum'];?>" class="input08"></td>
<td>&nbsp;</td>
</tr>
</table>
</form>

</td>
</tr>
</table></td>
</tr>
<tr>
<td align="left" valign="top" class="font02 font03">&nbsp;&nbsp;映诺热线电话：13632326234&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Copyright (C) 2008-2010 Handshake  All Right Reserved </td>
</tr>
</table>
</td>
</tr>
</table>
<script type="text/javascript">
function trim(str){ return str.replace(/(^\s*)|(\s*$)/g, "");}	
function FormCheck(form)
{
	var username = trim(form.username.value);
	var pwd = trim(form.pwd.value);
	var chknum = trim(form.chknum.value);
	if(username == ''){
		alert("用户名不能为空，请输入用户名！");
		form.username.focus();
		return false;
	}
	if(pwd == ''){
		alert("密码不能为空，请输入密码！");
		form.pwd.focus();
		return false;
	}
	if(chknum == ''){
		alert("验证码不能为空，请输入验证码！");
		form.chknum.focus();
		return false;
	}
}
</script>
</body>
</html>