<?
	require('libs/config.inc.php');
	if($_SESSION['username']==''){
		mysql_close($conn);
		header('location:login.php');
		exit;
	}
	if($_SESSION['flag']<98){
		mysql_close($conn);
		echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
		exit;
	}
?>
<html>
<head>
<TITLE>��ѯϵͳ����=>�����������</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="��ѯϵͳ����=>�����������">
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
<td width="146"><div class="title01">ϵͳ���� </div></td>
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
<td><div class="title01">�����������</div></td>
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

<a href="addgongchang.php">����¹�������</a>
<br><br>
<table width="1000" border="1" bordercolor="#dedfe0" align="center" cellpadding="0" cellspacing="0" class="datatable">
  <tr height="30" align="center">
   <td class="b1 titsty">��������</td>
   <td class="b1 titsty">��������</td>
   <td class="b1 titsty">���ڳ���</td>
   <td class="b1 titsty">Ʒ������</td>
   <td class="b1 titsty">Ʒ�Ʊ���</td>
   <td class="b1 titsty">��Ʒ</td>
   <td class="b1 titsty">����</td>
   <td class="b1 titsty" width="15%">����</td>
  </tr><?
$rs = mysql_query("select count(gongchangid) from gongchang");
$row = mysql_fetch_row($rs);
if($row[0] > 0)
{
	$total=$row[0];
	$pageSize=20;	//��ҳ������ÿҳ��ʾ���ݵ�����;
	$fenyeObj=new Fenye('',$pageSize,$total);	//������ҳ����
	$rs = mysql_query("select gongchangid,gongchangname,gongchangcode,cityname,pinpainame,gongchangpinpai,gongchangchanpin,gongchangrenshu from gongchang order by gongchangid desc limit ".($fenyeObj->page-1)*$pageSize.','.$pageSize."");
	while($row = mysql_fetch_array($rs, MYSQL_ASSOC))
	{	
?>
  <tr height="28" align="center" bgcolor="#fafafa">
   <td ><? echo $row['gongchangname'];?></td>
   <td ><? echo $row['gongchangcode'];?></td>
   <td ><? echo $row['cityname'];?></td>
   <td ><? echo $row['pinpainame'];?></td>
   <td ><? echo $row['gongchangpinpai'];?></td>
   <td ><? echo $row['gongchangchanpin'];?></td>
   <td ><? echo $row['gongchangrenshu'];?></td>
   <td ><a href="gongchang.php?gongchangid=<? echo $row['gongchangid'];?>&page=<? echo $fenyeObj->page;?>" target="_blank">�鿴</a>&nbsp;&nbsp;<a href="editgongchang.php?gongchangid=<? echo $row['gongchangid'];?>&page=<? echo $fenyeObj->page;?>">�޸�</a>&nbsp;&nbsp;<a href="admingongchangSave.php?action=del&gongchangid=<? echo $row['gongchangid'];?>&page=<? echo $fenyeObj->page;?>" onClick="if(confirm('ȷ��ɾ����?')==false){ return false;}">ɾ��</a></td>
  </tr>
<?
	}mysql_free_result($rs);
?>
  <tr height="28" align="center" bgcolor="#fafafa">
  <td colspan="8"><? $fenyeObj->fenyeFoot();unset($fenyeObj);?></td>
  </tr>
<?
}else{ echo "<tr align='center' height='28'><td colspan='8'>".$tip."</td></tr>";}
?>
</table>
<script language="javascript">
function pageTrans(p)
{
	location="?page="+p;
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
<td><? include('foot.php');?></td>
</tr>
</table>
</body>
</html>