<?
	require('libs/config.inc.php');
	if($_SESSION['username']==''){
		mysql_close($conn);
		header('location:login.php');
		exit;
	}
	if($_SESSION['flag']<50){
		mysql_close($conn);
		echo '您权限不足，请使用有权限的用户名称进行登录';
		exit;
	}
	if($_SESSION['kind'] == 2)
	{
		$title1 = '下属工厂信息';	
		$title2 = '下属工厂列表';
		$title3 = $title1;
	}
	else
	{
		$title1 = '工厂查询';
		$title2 = $title1;
		$title3 = '品牌/工厂查询';
	}
	
?>
<html>
<head>
<TITLE><? echo $title1;?></TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="<? echo $title1;?>">
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
<td width="146"><div class="title01"><? echo $title3;?></div></td>
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
<td><div class="title01"><? echo $title2;?></div></td>
<td width="28"><img src="images/icon12.jpg"  border="0"></td>
<td width="5" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rightcon">
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
<?
if($_SESSION['kind'] <> 2)
{
	$key='';
	$sort='';
	if($_POST['key']){ $key=trim($_POST['key']);}else if($_GET['key']){ $key=trim($_GET['key']);}
	if($_POST['sort']){ $sort=$_POST['sort'];}else if($_GET['sort']){ $sort=trim($_GET['sort']);}
?>
<form name="searchForm" method="post" action="?action=search">
<table width="600" border="0" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0">
<tr>
	<td><strong>工厂查询</strong>&nbsp;&nbsp;<input type="text" name="key" size="40" value="<? echo $key;?>" maxlength="30">&nbsp;
		<select name="sort">
			<option value="gongchangname" <? if($sort=='gongchangname'){?>selected="selected"<? }?>>工厂名称</option>
			<option value="gongchangcode" <? if($sort=='gongchangcode'){?>selected="selected"<? }?>>工厂编码</option>
			<option value="gongchangdizhi" <? if($sort=='gongchangdizhi'){?>selected="selected"<? }?>>工厂地址</option>
			<option value="cityname" <? if($sort=='cityname'){?>selected="selected"<? }?>>所属城市</option>
			<option value="gongchangpinpai" <? if($sort=='gongchangpinpai'){?>selected="selected"<? }?>>工厂品牌</option>
			<option value="pinpainame" <? if($sort=='pinpainame'){?>selected="selected"<? }?>>品牌名称</option>
			<option value="gongchangchanpin" <? if($sort=='gongchangchanpin'){?>selected="selected"<? }?>>工厂产品</option>
		</select>&nbsp;
		<input type="submit" name="Submit" value="查找" class="inBg3">
	 </td>
</tr>
</table>
</form>
<br>
<br>
<?
}

if($_SESSION['flag'] == 95 and $_GET['action'] == '')
{
	if(empty($_GET['k']))
	{
?>
<input type="hidden" name="param" id="param" value="">
<table width="850" border="1" bordercolor="#dedfe0" align="center" cellpadding="3" cellspacing="0" class="datatable">
  <tr height="30" align="center">
   <td class="b1 titsty">品牌名称</td>
   <td class="b1 titsty">品牌编码</td>
   <td class="b1 titsty">品牌地址</td>
   <td class="b1 titsty">所在城市</td>
   <td class="b1 titsty">操作</td>
  </tr><?
$rs = mysql_query("select count(pinpai_id) from pinpai");
$row = mysql_fetch_array($rs);
if($row[0]>0)
{
	$total=$row[0];
	$pageSize=20;	//分页程序中每页显示数据的数量;
	$fenyeObj=new Fenye('',$pageSize,$total);	//创建分页对象
	$rs=mysql_query("select * from pinpai order by pinpai_id asc limit ".($fenyeObj->page-1)*$pageSize.','.$pageSize."");
	while($row = mysql_fetch_array($rs,MYSQL_ASSOC))
	{	
?>
  <tr height="28" align="center" bgcolor="#fafafa">
   <td ><? echo $row['pinpainame'];?></td>
   <td ><? echo $row['pinpaicode'];?></td>
   <td ><? echo $row['pinpaidizhi'];?></td>
   <td ><? echo $row['cityname'];?>&nbsp;</td>
   <td ><a href="search_gongchang.php?k=gongchang&pinpaicode=<? echo $row['pinpaicode'];?>">查看下属工厂</a></td>
  </tr>
<?
	}mysql_free_result($rs);
?>
  <tr height="28" align="center" bgcolor="#fafafa">
  <td colspan="5"><? $fenyeObj->fenyeFoot();unset($fenyeObj);?></td>
  </tr>
<?
}else{ echo "<tr align='center' height='28'><td colspan='5'>没有找到符合条件的品牌</td></tr>";}
?>
</table>
<?
	}
	else if($_GET['k'] == 'gongchang')
	{
		$pinpaicode = $_GET['pinpaicode'];
		$param = 'k=gongchang&pinpaicode=' . $pinpaicode;	
?>
<input type="hidden" name="param" id="param" value="<? echo $param;?>">
<table width="850" border="1" bordercolor="#dedfe0" align="center" cellpadding="0" cellspacing="0" class="datatable">
  <tr height="30" align="center">
   <td class="b1 titsty">工厂名称</td>
   <td class="b1 titsty">工厂编码</td>
   <td class="b1 titsty">所在城市</td>
   <td class="b1 titsty">产品</td>
   <td class="b1 titsty">人数</td>
   <td class="b1 titsty" width="15%">操作</td>
  </tr><?
$rs = mysql_query("select count(gongchangid) from gongchang where gongchangpinpai='$pinpaicode'");
$row = mysql_fetch_row($rs);
if($row[0] > 0)
{
	$total=$row[0];
	$pageSize=20;	//分页程序中每页显示数据的数量;
	$fenyeObj=new Fenye($param,$pageSize,$total);	//创建分页对象
	$rs = mysql_query("select gongchangid,gongchangname,gongchangcode,cityname,gongchangchanpin,gongchangrenshu from gongchang where gongchangpinpai='$pinpaicode' order by gongchangid desc limit ".($fenyeObj->page-1)*$pageSize.','.$pageSize."");
	while($row = mysql_fetch_array($rs, MYSQL_ASSOC))
	{	
?>
  <tr height="28" align="center" bgcolor="#fafafa">
   <td ><? echo $row['gongchangname'];?></td>
   <td ><? echo $row['gongchangcode'];?></td>
   <td ><? echo $row['cityname'];?></td>
   <td ><? echo $row['gongchangchanpin'];?></td>
   <td ><? echo $row['gongchangrenshu'];?></td>
   <td ><a href="gongchang.php?gongchangid=<? echo $row['gongchangid'];?>" target="_blank">查看</a></td>
  </tr>
<?
	}mysql_free_result($rs);
?>
  <tr height="28" align="center" bgcolor="#fafafa">
  <td colspan="6"><? $fenyeObj->fenyeFoot();unset($fenyeObj);?></td>
  </tr>
<?
}else{ echo "<tr align='center' height='28'><td colspan='6'>".$tip."</td></tr>";}
?>
</table>
<?
	}
}

$condit='';
$param='';
$bool = false;
if($_GET['action']=='search' and $_SESSION['kind'] <> 2)
{
	$bool = true;
	if($_POST['key']){ $key=trim($_POST['key']);}else if($_GET['key']){ $key=trim($_GET['key']);}
	if($_POST['sort']){ $sort=$_POST['sort'];}else if($_GET['sort']){ $sort=trim($_GET['sort']);}
	$param='action=search&sort='.$sort.'&key='.$key;
	$condit = 'where ' . $sort . " like '%".$key."%'";
	echo '<div class="searchrs" style="width:1000">工厂查询结果</div>';
}
else if($_SESSION['kind'] == 2)
{
	$bool = true;
	$pinpaicode = $_SESSION['pinpaicode'];
	$condit="where gongchangpinpai='$pinpaicode'";
}

if($bool == true)
{
?>
<input type="hidden" name="param" id="param" value="<? echo $param;?>">
<table width="1000" border="1" bordercolor="#dedfe0" align="center" cellpadding="3" cellspacing="0" class="datatable">
  <tr height="30" align="center">
   <td class="b1 titsty">工厂名称</td>
   <td class="b1 titsty">工厂编码</td>
   <td class="b1 titsty">工厂地址</td>
   <td class="b1 titsty">所属城市</td>
   <td class="b1 titsty">工厂品牌</td>
   <td class="b1 titsty">品牌名称</td>
   <td class="b1 titsty">工厂产品</td>
   <td class="b1 titsty" width="5%">操作</td>
  </tr><?
	$sql ="select count(gongchangid) from gongchang $condit";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	if($row[0]>0)
	{
		$total=$row[0];
		$pageSize=20;	//分页程序中每页显示数据的数量;
		$fenyeObj=new Fenye($param,$pageSize,$total);	//创建分页对象
		$rs=mysql_query("select * from gongchang $condit order by gongchangid asc limit ".($fenyeObj->page-1)*$pageSize.','.$pageSize."");
		while($row = mysql_fetch_array($rs,MYSQL_ASSOC))
		{
?>
  <tr height="28" align="center" bgcolor="#fafafa">
   <td ><? echo $row['gongchangname'];?>&nbsp;</td>
   <td ><? echo $row['gongchangcode'];?>&nbsp;</td>
   <td ><? echo $row['gongchangdizhi'];?>&nbsp;</td>
   <td ><? echo $row['cityname'];?>&nbsp;</td>
   <td ><? echo $row['gongchangpinpai'];?>&nbsp;</td>
   <td ><? echo $row['pinpainame'];?>&nbsp;</td>
   <td ><? echo $row['gongchangchanpin'];?>&nbsp;</td>
   <td ><a href="gongchang.php?gongchangid=<? echo $row['gongchangid'];?>&page=<? echo $fenyeObj->page;?>" target="_blank">查看</a></td>
  </tr>
<?
		}mysql_free_result($rs);
?>
  <tr height="28" align="center" bgcolor="#fafafa">
  <td colspan="8"><? $fenyeObj->fenyeFoot();unset($fenyeObj);?></td>
  </tr>
<?
	}else{ echo "<tr align='center' height='28'><td colspan='8'>没有找到符合条件的工厂</td></tr>";}
?>
</table>
<?
}
?>

</td>
<td></td>
</tr>
</table></td>
</tr>
</table>
<script language="javascript">
function pageTrans(p)
{
	var param=document.getElementById('param').value;
	if(param == ''){ location="?page="+p;}else{ location="?"+param+"&page="+p;}
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