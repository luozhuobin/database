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
<HEAD>
<TITLE>��ѯϵͳ����=>�޸�����</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="��ѯϵͳ����=>�޸�����">
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
<td><div class="title01">�޸�����</div></td>
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
$page = $_GET['page'] + 0;
if(isset($_POST['code'])){
	$sql = 'select * from question_answer where code="' . trim($_POST['code']) . '"';
}else{
	$questionid=$_GET['questionid']+0;
	$sql='select * from question_answer where questionid=' . $questionid;
}
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs, MYSQL_ASSOC);
if($row)
{
	mysql_free_result($rs);
?>
<form method="post" name="myform" action="adminquestionsave.php?action=edit&questionid=<? echo $questionid;?>&page=<? echo $page;?>" >
<table width="900" border="1" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0" class="datatable">
  <tr height="28">
   <td class="b1" align="right" width="20%">������룺</td>
   <td align="left">&nbsp;<INPUT class="inBg2" name="code"  size="50" value="<? echo $row['code'];?>"></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">���⣺</td>
   <td align="left">&nbsp;<INPUT class="inBg2" name="question"  size="50" value="<? echo $row['question'];?>"><br>������Ƿ��棬����дΪ��XX���桷��X�����Է�����ϣ�</td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">����ش�</td>
   <td align="left">&nbsp;<textarea name="answer" cols="80" rows="10"><? echo $row['answer'];?></textarea></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">����ؼ��֣�</td>
   <td align="left">&nbsp;<INPUT class="inBg2" name="keyword"  size="50" value="<? echo $row['keyword'];?>"></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">������ࣺ</td>
   <td align="left">&nbsp;<select name="classid"><?
    $rs2 = mysql_query('select classid,classname from class');
	while($row2 = mysql_fetch_array($rs2, MYSQL_ASSOC))
	{
?>
        <option value="<? echo $row2['classid'];?>" <? if($row['classid'] == $row2['classid']){ ?>selected="selected"<? }?> ><? echo $row2['classname'];?></option>
<?
	}mysql_free_result($rs);
?>
    </select>
   </td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">����ˣ�</td>
   <td align="left">&nbsp;<?
   $userid = $row['userid'];
   $rs2 = mysql_query("select username from user where userid=$userid");
   $row2 = mysql_fetch_row($rs2);
   echo $row2[0];?></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right">���ʱ�䣺</td>
   <td align="left">&nbsp;<? echo date('Y-m-d H:i:s',$row['addtime']);?></td>
  </tr>
  <tr height="28">
	<td>&nbsp;</td>
	<td align="left">&nbsp;<INPUT type="submit" class="inBg3" value=" �޸� " name="Submit" ></td>
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