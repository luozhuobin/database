<?
	require('libs/config.inc.php');
	if($_SESSION['username']==''){
		mysql_close($conn);
		header('location:login.php');
		exit;
	}
	if($_SESSION['flag']<50){
		mysql_close($conn);
		echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
		exit;
	}
?>
<html>
<HEAD>
<TITLE>�鿴����</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="�鿴����">
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<br><br>
<?
$gongchangid=$_GET['gongchangid']+0;
$page = $_GET['page'] + 0;
$condit='';
if($_SESSION['kind']==2){ $condit=" and gongchangpinpai='" . $_SESSION['pinpaicode'] . "'";}
$sql='select * from gongchang where gongchangid='.$gongchangid.$condit;
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs, MYSQL_ASSOC);
if($row)
{
	mysql_free_result($rs);
?>
<table width="600" border="1" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0" class="datatable">
  <tr height="30">
   <td width="25%" align="right" class="b1">�������ƣ�</td>
   <td align="left">&nbsp;<? echo $row['gongchangname'];?></td>
  </tr>
  <tr height="30">
   <td  align="right" class="b1">���ڳ��У�</td>
   <td align="left">&nbsp;<? echo $row['cityname'];?></td>
  </tr>
  <tr height="30">
   <td  align="right" class="b1">�������룺</td>
   <td align="left">&nbsp;<? echo $row['gongchangcode'];?></td>
  </tr>
  <tr height="30">
   <td  align="right" class="b1">Ʒ�����ƣ�</td>
   <td align="left">&nbsp;<? echo $row['pinpainame'];?></td>
  </tr>
  <tr height="30">
   <td  align="right" class="b1">Ʒ�Ʊ��룺</td>
   <td align="left">&nbsp;<? echo $row['gongchangpinpai'];?></td>
  </tr>
  <tr height="30">
   <td  align="right" class="b1">������Ʒ��</td>
   <td align="left">&nbsp;<? echo $row['gongchangchanpin'];?></td>
  </tr>
  <tr height="30">
   <td  align="right" class="b1">����������</td>
   <td align="left">&nbsp;<? echo $row['gongchangrenshu'];?></td>
  </tr>
<tr height="30">
	<td  align="right" class="b1">������ַ��</td>
	<td align="left">&nbsp;<? echo $row['gongchangdizhi'];?></td>
</tr>
<tr height="30">
	<td  align="right" class="b1">��ϵ�绰��</td>
	<td align="left">&nbsp;<? echo $row['gongchangdianhua'];?></td>
</tr>
<tr height="30">
	<td  align="right" class="b1">��ϵ�ˣ�</td>
	<td align="left">&nbsp;<? echo $row['lianxiren'];?></td>
</tr>
<? if($_SESSION['flag']>95){ ?>
<tr height="30">
	<td  align="right" class="b1">����ѡ�</td>
	<td align="left">&nbsp;<a href="editgongchang.php?gongchangid=<? echo $row['gongchangid'];?>&page=<? echo $page;?>" target="_top">�޸�</a> </td>
</tr>
<?	}?>
</table>
<?
}else{ echo '�Ҳ���������ݻ���û�����Ȩ�޲鿴';}
mysql_close($conn);
?>
</body>
</html>