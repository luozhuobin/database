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
	echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
	exit;
}
?>
<html>
<HEAD>
<TITLE>��ѯϵͳ����=>�û�����</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="��ѯϵͳ����=>�û�����">
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
<td><div class="title01">�û�����</div></td>
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
<a href="adduser.php">������û�</a>
<br><br>
<table width="600" align="center" border="1" bordercolor="#dedfe0"  cellpadding="0" cellspacing="0" class="datatable">
  <tr height="30" align="center" >
   <td class="b1 titsty">�û�����</td>
   <td class="b1 titsty">�û�����</td>
   <td class="b1 titsty">��ְ״̬</td>
   <td class="b1 titsty">Ȩ��</td>
   <td class="b1 titsty" width="15%">����</td>
  </tr>
<?
$rs = mysql_query("select count(userid) from user");
$row = mysql_fetch_row($rs);
if($row[0] > 0)
{
	$total=$row[0];
	$pageSize=20;	//��ҳ������ÿҳ��ʾ���ݵ�����;
	$fenyeObj=new Fenye('',$pageSize,$total);	//������ҳ����
	$rs = mysql_query("select userid,username,userpass,flag,work from user order by userid asc limit ".($fenyeObj->page-1)*$pageSize.','.$pageSize."");
	while($row = mysql_fetch_array($rs,MYSQL_ASSOC))
	{
?>
  <tr height="28" align="center">
   <td><? echo $row['username'];?></td>
   <td><? echo $row['userpass'];?></td>
   <td><? if($row['work'] == 1){ echo '��ְ';}else{ echo '��ְ';}?></td>
   <td><? echo $row['flag'];?></td>
   <td><a href="edituser.php?userid=<? echo $row['userid'];?>&page=<? echo $fenyeObj->page;?>">�޸�</a>&nbsp;&nbsp;<a href="adminusersave.php?action=del&userid=<? echo $row['userid'];?>&page=<? echo $fenyeObj->page;?>" onClick="if(confirm('ȷ��ɾ����?')==false){ return false;}">ɾ��</a></td>
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
˵����Ȩ��ֵ����Ϊ��99Ϊ��ߵ�ϵͳ����ԱȨ�ޣ�98Ϊ����Ա�����ԱȨ�ޣ�95Ϊӳŵ����Ȩ�ޣ�91Ϊӳŵ��ͨԱ��Ȩ�ޣ�50ΪƷ��Ȩ�ޣ�40Ϊ����Ȩ��.<br>
ĳ���û����õ�ʱ�����ó���ְ���еģ�������Ҫȥɾ���û�����ְ״̬���û��������ٵ�½ϵͳ;�û�admin�����ܱ�ɾ����
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

  