<?
require('libs/config.inc.php');
$questionid = $_GET['questionid'] + 0;
?>
<head>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>��������鿴����</title>
</head>
<body>
<br><br>


<?
if($questionid > 0)
{
	$sql = 'SELECT * FROM question_answer where questionid=' . $questionid;
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	if($row)
	{
		mysql_free_result($rs);
		$sql2 = 'select username from user where userid=' . $row['userid'];
		$rs2 = mysql_query($sql2);
		$row2 = mysql_fetch_row($rs2);
		$username = $row2[0];
		$sql2 = 'select classname from class where classid=' . $row['classid'];
		$rs2 = mysql_query($sql2);
		$row2 = mysql_fetch_row($rs2);
		$classname = $row2[0];
?>
  <table width="700" border="1" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0" class="datatable">
	  <tr height="28" bgcolor="#fafafa">  
		<td width="15%" align="right"><b>���</b>&nbsp;</td>
		<td>&nbsp;<? echo $row['code'];?></td>
	  </tr>
	  <tr height="28" bgcolor="#fafafa">  
		<td align="right"><b>����/����</b>&nbsp;</td>
		<td>&nbsp;<? echo $row['question'];?></td>
	  </tr>
	  <tr height="28" bgcolor="#fafafa"> 
		<td align="right"><b>���</b>&nbsp;</td>
		<td>&nbsp;<? echo $row['code'];?></td>
	  </tr>
	  <tr height="28" bgcolor="#fafafa">  
		<td align="right"><b>����/�ش�</b>&nbsp;</td>
		<td style="line-height:200%">&nbsp;<? echo $row['answer'];?></td>
	  </tr>
	  <tr height="28" bgcolor="#fafafa">  
		<td align="right"><b>�ؼ���</b>&nbsp;</td>
		<td>&nbsp;<? echo $row['keyword'];?></td>
	  </tr>
	  <tr height="28" bgcolor="#fafafa">  
		<td align="right"><b>���ʱ��</b>&nbsp;</td>
		<td>&nbsp;<? echo date('Y-m-d H:i:s',$row['addtime']);?></td>
	  </tr>
	  <tr height="28" bgcolor="#fafafa"> 
		<td align="right"><b>�����</b>&nbsp;</td>
		<td>&nbsp;<? echo $username;?></td>
	  </tr>
	  <tr height="28" bgcolor="#fafafa"> 
		<td align="right"><b>�������</b>&nbsp;</td>
		<td>&nbsp;<? echo $classname;?></td>
	  </tr>
 </table>	
<?
	}else{ echo '<center>',$tip,'</center>';}
}
?>
