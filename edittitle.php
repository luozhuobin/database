<?
	require('libs/config.inc.php');
	if($_SESSION['username']==''){
		mysql_close($conn);
		header('location:login.php');
		exit;
	}
	if($_SESSION['flag']<98){
		mysql_close($conn);
		echo '您权限不足，请使用有权限的用户名称进行登录';
		exit;
	}
?>
<html>
<HEAD>
<TITLE>查询系统管理=>修改映诺脚本</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="查询系统管理=>修改映诺脚本">
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
<td><div class="title01">修改映诺脚本</div></td>
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
$titleid=$_GET['titleid']+0;
$page = $_GET['page'] + 0;
$sql='select * from title where titleid='.$titleid;
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs, MYSQL_ASSOC);
if($row)
{
	mysql_free_result($rs);
?>
<form method="post" name="myform" action="admintitlesave.php?action=edit&titleid=<? echo $row['titleid'];?>&page=<? echo $page;?>">
<table width="800" border="1" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0" class="datatable">
  <tr height="28">
   <td class="b1" align="right" width="20%">语句：</td>
   <td align="left">&nbsp;<textarea rows="10" name="title" cols="80" class="smallarea"><? echo $row['title'];?></textarea></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">是否首页显示：</td>
   <td align="left">&nbsp;<select name="xianshi">
        <option  value='1' <? if($row['xianshi'] == 1){?>selected="selected"<? }?> >是</option>
        <option  value='0' <? if($row['xianshi'] == 0){?>selected="selected"<? }?> >否</option>
    </select>
	</td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">类型：</td>
   <td align="left">&nbsp;<select name="leixing">
        <option  value=0 <? if($row['leixing'] == 0){?>selected="selected"<? }?> >工作准备</option>
        <option  value=1 <? if($row['leixing'] == 1){?>selected="selected"<? }?> >电话脚本</option>
        <option  value=2 <? if($row['leixing'] == 2){?>selected="selected"<? }?> >沟通问题</option>
        <option  value=3 <? if($row['leixing'] == 3){?>selected="selected"<? }?> >咨询映诺</option>
        <option  value=4 <? if($row['leixing'] == 4){?>selected="selected"<? }?> >申诉咨询</option>
        <option  value=5 <? if($row['leixing'] == 5){?>selected="selected"<? }?> >心理适用</option>
        <option  value=6 <? if($row['leixing'] == 6){?>selected="selected"<? }?> >求助映诺</option>
    </select>
	</td>
  </tr>
  <tr height="28">
	<td>&nbsp;</td>
	<td align="left">&nbsp;<INPUT type="submit" class="inBg3" value=" 修改 " name="Submit" ></td>
  </tr>
  <tr height="28" align="left">
   <td  colspan="2" >
   
<br><br>
 HTML语法：(红色的为代码)<br>
 换行符号 <font color=red><</font><font color=red>br></font><br>
 粗体字 <font color=red><</font><font color=red>b></font>要变成粗体字的文字<font color=red><</font><font color=red>/b></font> 效果：<b>要变成粗体字的文字</b><br>
 红色文字 <font color=red><</font><font color=red>font color=red></font>要变成红色的文字<font color=red><</font><font color=red>/font></font> 效果：<font color=red>要变成红色的文字</font><br>
   </td>
  </tr>
</table>
</form>
<?
}else{ echo $tip;}
?>
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