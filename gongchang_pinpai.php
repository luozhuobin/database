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
<head>
<TITLE>按品牌查看工厂</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="按品牌查看工厂">
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
<tr><td><table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0"  >
<tr>
<td width="5">&nbsp;</td>
<td width="201" valign="top" class="leftsty">
<table border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td width="17"><img src="images/icon09.jpg" width="9" height="13"></td>
<td width="146"><div class="title01">品牌/工厂查询 </div></td>
<td width="16"><img src="images/icon11.jpg"  border="0"></td>
<td width="7" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<? require('searchleft.php');?>
</td>
<td width="5" valign="middle"><img src="images/btnleft.jpg"  width="5" height="117" border="0"></td>
<td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td><div class="title01">按品牌查看工厂</div></td>
<td width="28"><img src="images/icon12.jpg"  border="0"></td>
<td width="5" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rightcon">
<tr height="10"><td></td></tr>
<tr><td>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" class="datatable02" >
<tr>
<td height="30" align="left" valign="middle" style="line-height:180%;">
&nbsp;&nbsp;<b>按品牌查询</b> <br><?
$i=0;
$rs = mysql_query("select gongchangpinpai from gongchang where gongchangpinpai<>'' group by gongchangpinpai");
while($row = mysql_fetch_array($rs))
{
	$i++;
?>
&nbsp;&nbsp;<a href="search_gongchang.php?action=search&sort=gongchangpinpai&key=<? echo $row['gongchangpinpai'];?>"><font color="#0000ff"><u><? echo $row['gongchangpinpai'];?></u></font></a>
<?
	if($i>12){ echo '<br>';$i=0;}
}mysql_free_result($rs);
?>
</td>
</tr>
</table>
</td></tr>
<tr>
<td height="565" align="left" valign="top">

<table border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td width="10">&nbsp;</td>
<td>&nbsp;</td>
<td width="10">&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="center">

<form name="searchForm" method="post" action="search_gongchang.php?action=search">
<table width="600" border="0" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0">
<tr>
	<td><strong>工厂查询</strong>&nbsp;&nbsp;<input type="text" name="key" size="40" maxlength="30">&nbsp;
		<select name="sort">
			<option value="gongchangname" selected="selected">工厂名称</option>
			<option value="gongchangdizhi">工厂地址</option>
			<option value="gongchangdianhua">工厂电话</option>
			<option value="cityname">所属城市</option>
			<option value="gongchangpinpai">工厂品牌</option>
			<option value="gongchangchanpin">工厂产品</option>
		</select>&nbsp;
		<input type="submit" name="Submit" value="查找" class="inBg3">
	 </td>
</tr>
</table>
</form>

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
<td><? include('foot.php');?></td>
</tr>
</table>
</body>
</html>