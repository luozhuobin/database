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
<TITLE>查询系统管理=>修改工厂编码</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="查询系统管理=>修改工厂编码">
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
<td><div class="title01">修改工厂编码</div></td>
<td width="28"><img src="images/icon12.jpg"  border="0"></td>
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
$gongchangid=$_GET['gongchangid']+0;
$page = $_GET['page'] + 0;
$sql='select * from gongchang where gongchangid='.$gongchangid;
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs, MYSQL_ASSOC);
if($row)
{
	mysql_free_result($rs);
?>
<form method="POST" name="myform" action="admingongchangSave.php?action=edit&gongchangid=<? echo $gongchangid;?>&page=<? echo $page;?>" onSubmit="return FormCheck(myform)">
<table width="600" border="1" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0" class="datatable">
  <tr height="28">
   <td align="right" class="b1" width="25%">工厂名称：</td>
   <td align="left">&nbsp;<INPUT class="inBg2" name="gongchangname" size="30" value="<? echo $row['gongchangname'];?>"></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">所在城市：</td>
   <td align="left">&nbsp;<select name="cityname"><?
	$rs2 = mysql_query("select cityname from city order by cityid asc");
	while($row2 = mysql_fetch_array($rs2, MYSQL_ASSOC))
	{?>
        <option value="<? echo $row2['cityname'];?>" <? if($row['cityname'] == $row2['cityname']){?>selected="selected"<? }?>><? echo $row2['cityname'];?></option>
<?	}mysql_free_result($rs2);?>	
	</select>
   </td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">工厂编码：</td>
   <td align="left">&nbsp;<INPUT class="inBg2" name="gongchangcode"  size="30" value="<? echo $row['gongchangcode'];?>"></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">工厂地址：</td>
   <td align="left">&nbsp;<INPUT class="inBg2" name="gongchangdizhi"  size="30" value="<? echo $row['gongchangdizhi'];?>"></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">品牌名称：</td>
   <td align="left">&nbsp;<select name="pinpai_id"><?
	$rs2 = mysql_query('select pinpai_id,pinpainame from pinpai order by pinpai_id asc');
	while($row2 = mysql_fetch_array($rs2, MYSQL_ASSOC))
	{?>
        <option value="<? echo $row2['pinpai_id'];?>" <? if($row['pinpai_id'] == $row2['pinpai_id']){?>selected="selected"<? }?>><? echo $row2['pinpainame'];?></option>
<?	}?>	
	</select>
     </td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">工厂产品：</td>
   <td align="left">&nbsp;<INPUT class="inBg2" name="gongchangchanpin"  size="30" value="<? echo $row['gongchangchanpin'];?>"></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">联系电话：</td>
   <td align="left">&nbsp;<INPUT class="inBg2" name="gongchangdianhua"  size="30" value="<? echo $row['gongchangdianhua'];?>"></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">联系人：</td>
   <td align="left">&nbsp;<INPUT class="inBg2" name="lianxiren"  size="30" value="<? echo $row['lianxiren'];?>"></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">工厂人数：</td>
   <td align="left">&nbsp;<INPUT class="inBg2" name="gongchangrenshu"  size="30" value="<? echo $row['gongchangrenshu'];?>">&nbsp;(只能填写数字)</td>
  </tr>
  <tr height="28" align="center">
	<td>&nbsp;</td>
	<td align="left">&nbsp;<INPUT type="submit" class="inBg3" value=" 修改 " name="Submit" ></td>
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
<script type="text/javascript">
function trim(str){ return str.replace(/(^\s*)|(\s*$)/g, "");}
function FormCheck(form)
{
	var gongchangname=trim(form.gongchangname.value);
	var gongchangcode=trim(form.gongchangcode.value);
	if(gongchangname==''){
		alert("工厂名称不能为空！");
		form.gongchangname.focus();
		return false;
	}
	if(gongchangcode==''){
		alert("工厂编码不能为空！");
		form.gongchangcode.focus();
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
<td><? include('foot.php');?></td>
</tr>
</table>
</body>
</html>