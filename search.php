<?
require('libs/config.inc.php');
$key = '';
if(isset($_POST['key'])){
	$key = trim($_POST['key']);
}else if(trim($_GET['key'])){
	$key = trim($_GET['key']);
}
?>
<head>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>问题数据库查询</title>
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
<td width="146"><div class="title01">问题数据库查询 </div></td>
<td width="16"><img src="images/icon11.jpg"  border="0"></td>
<td width="7" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="435" background="images/leftbg.jpg">
<tr>
<td align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="10"></td>
</tr>    
</table>      
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="leftsub">
<tr>
<td height="25">
<div id="nav">
	<div class="title"><img alt="" id="pic1" src="<?php echo $_GET["ul"]=='1'?'images/close.gif':'images/open2.gif';?>">&nbsp;<a href="search.php?action=search&kindname=all&ul=1&key=法律法规">法律法规</a></div>
	<ul id="ul1" style="<?php echo $_GET["ul"]=='1'?'':'display:none;';?>">
	</ul>
	<div class="title"><img alt="" id="pic2" src="<?php echo $_GET["ul"]=='2'?'images/close.gif':'images/open2.gif';?>">&nbsp;<a href="search.php?action=search&kindname=all&ul=2&key=劳动法">劳动法</a></div>
	<ul id="ul2" style="<?php echo $_GET["ul"]=='2'?'':'display:none;';?>">
	</ul>
	<div class="title"><img alt="" id="pic2" src="<?php echo $_GET["ul"]=='3'?'images/close.gif':'images/open2.gif';?>">&nbsp;<a href="search.php?action=search&kindname=all&ul=3&key=婚姻法">婚姻法</a></div>
	<ul id="ul3" style="<?php echo $_GET["ul"]=='3'?'':'display:none;';?>">
	</ul>
	<div class="title"><img alt="" id="pic2" src="<?php echo $_GET["ul"]=='4'?'images/close.gif':'images/open2.gif';?>">&nbsp;<a href="search.php?action=search&kindname=all&ul=4&key=劳动合同法">劳动合同法</a></div>
	<ul id="ul4" style="<?php echo $_GET["ul"]=='4'?'':'display:none;';?>">
	</ul>
	<div class="title"><img alt="" id="pic2" src="<?php echo $_GET["ul"]=='5'?'images/close.gif':'images/open2.gif';?>">&nbsp;<a href="search.php?action=search&kindname=all&ul=5&key=保障体系">保障体系</a></div>
	<ul id="ul5" style="<?php echo $_GET["ul"]=='5'?'':'display:none;';?>">
	</ul>
	<div class="title"><img alt="" id="pic2" src="<?php echo $_GET["ul"]=='6'?'images/close.gif':'images/open2.gif';?>">&nbsp;<a href="search.php?action=search&kindname=all&ul=6&key=社保">社保</a></div>
	<ul id="ul6" style="<?php echo $_GET["ul"]=='6'?'':'display:none;';?>">
		<li><img alt="" src="images/dot.gif">&nbsp;<a href="search.php?action=search&kindname=all&ul=6&key=工伤">工伤</a></li>
		<li><img alt="" src="images/dot.gif">&nbsp;<a href="search.php?action=search&kindname=all&ul=6&key=医疗">医疗</a></li>
		<li><img alt="" src="images/dot.gif">&nbsp;<a href="search.php?action=search&kindname=all&ul=6&key=生育">生育</a></li>
		<li><img alt="" src="images/dot.gif">&nbsp;<a href="search.php?action=search&kindname=all&ul=6&key=养老">养老</a></li>
		<li><img alt="" src="images/dot.gif">&nbsp;<a href="search.php?action=search&kindname=all&ul=6&key=失业">失业</a></li>
	</ul>
</div>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</table>
</td>
<td width="5" valign="middle"><img src="images/btnleft.jpg"  width="5" height="117" border="0"></td>
<td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td><div class="title01">问题数据库查询</div></td>
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

<table width="600" border="1" bordercolor="#dedfe0" align="center" cellpadding="0" cellspacing="0" class="datatable">
<tr> 
	<td colspan="6" align="right"> 
		<form name="form1" action="search.php?action=search" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr> 
			<td width=100 align="right"> 搜索条件：</td>
			<td height="30">&nbsp;<INPUT type="text" class="inBg2" name="key" maxlength="30" size="30" value="<? echo $key;?>" class="inBg2">&nbsp;&nbsp;<INPUT  name="Submit" type="Submit" class="inBg3"  value="搜索" ></td>
		</tr>
		</table>
		</form>
	  </td>
</tr>
</table>
<?

/*
'if trim(request("kindname"))="all" then
'strSQL="SELECT * FROM question_answer where "
'if request("key")<>"" then
'strSQL =strSQL&" code like '%"&request("key")&"%' or question like '%"&request("key")&"%' or answer like '%"&request("key")&"%' or keyword like '%"&request("key")&"%'  "
'end if
'if request("key2")<>"" then
'strSQL =strSQL&" "&request("yunsuan1")&" code like '%"&request("key2")&"%'  or question like '%"&request("key2")&"%' or answer like '%"&request("key2")&"%' or keyword like '%"&request("key2")&"%'  "
'end if
'if request("key3")<>"" then
'strSQL =strSQL&" "&request("yunsuan2")&" code like '%"&request("key3")&"%'  or question like '%"&request("key3")&"%' or answer like '%"&request("key3")&"%' or keyword like '%"&request("key3")&"%'  "
'end if
'strSQL =strSQL&" order by questionid desc"
'
'
'else
'
'strSQL="SELECT * FROM question_answer where "
'if request("key")<>"" then
'strSQL =strSQL&" "&request("kindname")&" like '%"&request("key")&"%' "
'end if
'if request("key2")<>"" then
'strSQL =strSQL&" "&request("yunsuan1")&" "&request("kindname")&" like '%"&request("key2")&"%' "
'end if
'if request("key3")<>"" then
'strSQL =strSQL&" "&request("yunsuan2")&" "&request("kindname")&" like '%"&request("key3")&"%' "
'end if
'strSQL =strSQL&" order by questionid desc"
'end if			
		*/	
		
if($_GET['action'] == 'search' and $key <> '')
{
?>
  <table width="900" border="1" bordercolor="#dedfe0" align="center" cellpadding="3" cellspacing="0" class="datatable">
          <tr height="30"> 
            <td width="10%" class="titsty" align="center"><b>编号</b></td>
            <td class="titsty" align="left">&nbsp;&nbsp;<b>标题/问题</b></td>
          </tr>
<?	
	$sql = 'SELECT questionid,code,question,answer FROM question_answer where question like "%' . $key . '%" order by questionid desc';
	$rs = mysql_query($sql);
	while($row = mysql_fetch_array($rs, MYSQL_ASSOC))
	{
?>
          <tr height="28" bgcolor="#fafafa"> 
            <td align="center"><a href="r_a_search.php?questionid=<? echo $row['questionid'];?>" target="_blank" title="<? echo $row['answer']?>"><? echo $row['code']?></a></td>
            <td align="left">&nbsp;<a href="r_a_search.php?questionid=<? echo $row['questionid'];?>" target="_blank" title="<? echo $row['answer']?>"><? echo $row['question']?></a>&nbsp;</td>
          </tr>
<?
	}mysql_free_result($rs);
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