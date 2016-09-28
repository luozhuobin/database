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
<TITLE>查询系统管理=>问题管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="查询系统管理=>问题管理">
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
<td><div class="title01">问题管理</div></td>
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

<a href="addquestion.php">添加新问题</a>
<br><br>
<form method="post" name="myform" action="adminquestion.php">
<table width="600" border="0" bordercolor="#dedfe0" align="center" cellpadding="0" cellspacing="0" class="datatable">
  <tr height="28">
   <td class="b1" align="right">按分类查看&nbsp;</td>
   <td align="left"><select name="classid"><?
    $rs = mysql_query('select * from class');
	while($row = mysql_fetch_array($rs, MYSQL_ASSOC))
	{
?>
        <option value="<? echo $row['classid'];?>" <? if($row['classid'] == $_POST['classid']){ ?>selected="selected"<? }?> ><? echo $row['classname'];?></option>
<?
	}mysql_free_result($rs);
?>
    </select>&nbsp;&nbsp;<INPUT type="Submit" class="inBg3" value=" 查看 " name="Submit" >
   </td>
  </tr>
</table>
</form>
<br><br>
<form method="post" name="myform1" action="editquestion.php" onSubmit="return FormCheck(myform1)">
<table width="600" border="0" bordercolor="#dedfe0" align="center" cellpadding="0" cellspacing="0" class="datatable">
  <tr height="28">
   <td class="b1" align="right">通过编码进行查找修改&nbsp;</td>
   <td align="left"><INPUT class="inBg2" name="code"  size="15" maxlength="20" value="">&nbsp;&nbsp;<INPUT type="Submit" class="inBg3" value=" 修改 " name="Submit" ></td>
  </tr>
</table>
</form>
<br><br>
<table width="1000" border="1" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0" class="datatable">
  <tr height="30" align="center" bgcolor="#fafafa">
   <td class="b1 titsty" width="8%">问题编号</td>
   <td class="b1 titsty">问题</td>
   <td class="b1 titsty">回答</td>
   <td class="b1 titsty" width="10%">关键词</td>
   <td class="b1 titsty" width="10%">分类名称</td>
   <td class="b1 titsty" width="5%">操作</td>
  </tr><?
if(isset($_POST['classid'])){
	$sql = 'select count(classid) from question_answer where classid=' . $_POST['classid'];
	$sql2 = 'select * from question_answer where classid=' . $_POST['classid'] . ' order by questionid desc limit ';
}else{
	$sql = 'select count(classid) from question_answer';
  	$sql2 = 'select * from question_answer order by questionid desc limit ';
}
$rs = mysql_query($sql);
$row = mysql_fetch_row($rs);
if($row[0] > 0)
{
	$total=$row[0];
	$pageSize=20;	//分页程序中每页显示数据的数量;
	$fenyeObj=new Fenye('',$pageSize,$total);	//创建分页对象
	$rs = mysql_query($sql2 . ($fenyeObj->page-1)*$pageSize.','.$pageSize."");
	while($row = mysql_fetch_array($rs,MYSQL_ASSOC))
	{	
		$sql3 = 'select classname from class where classid=' . $row['classid'];
		$rs3 = mysql_query($sql3);
		$row3 = mysql_fetch_array($rs3, MYSQL_ASSOC);
?>
  <tr height="28" align="center"bgcolor="#fafafa">
   <td><? echo $row['code'];?></td>
   <td style="text-align:left"><? echo $row['question'];?></td>
   <td style="text-align:left"><? echo $row['answer'];?></td>
   <td style="text-align:left"><? echo $row['keyword'];?></td>
   <td><? echo $row3['classname']; ?></td>
   <td ><a href="editquestion.php?questionid=<? echo $row['questionid'];?>&page=<? echo $fenyeObj->page;?>">修改</a><br><a href="adminquestionsave.php?action=del&questionid=<? echo $row['questionid'];?>&page=<? echo $fenyeObj->page;?>" onClick="if(confirm('确定删除吗?')==false){ return false;}">删除</a> </td>
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
<script language="javascript">
function trim(str){ return str.replace(/(^\s*)|(\s*$)/g, "");}	
function pageTrans(p)
{
	location="?page="+p;
}
function FormCheck(form)
{
	var code = trim(form.code.value);
	if(code == ''){
		alert('请输入编码！');
		form.code.focus();
		return false;
	}
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
<td>
<? include('foot.php');?>
</td>
</tr>
</table>
</body>
</html>