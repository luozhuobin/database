<?
require('libs/config.inc.php');
if($_SESSION['username']==''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag']<40 or $_SESSION['flag'] == 91){
	mysql_close($conn);
	echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
	exit;
}

$k=isset($_GET['k']) ? $_GET['k']+0 : 1;
$page=$_GET['page']+0;
	
?>
<html>
<HEAD>
<TITLE>����=>���Իظ�</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="����=>���Իظ�">
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
<tr><td>
<table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="5">&nbsp;</td>
<td width="201" valign="top" class="leftsty">
<table border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td width="17"><img src="images/icon09.jpg" width="9" height="13"></td>
<td width="146"><div class="title01">���� </div></td>
<td width="16"><img src="images/icon11.jpg"  border="0"></td>
<td width="7" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<? include('messageleft.php');?></td>
<td width="5" valign="middle"><img src="images/btnleft.jpg" width="5" height="117" border="0"></td>
<td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td><div class="title01">���Իظ�</div></td>
<td width="28"><img src="images/icon12.jpg"  border="0"></td>
<td width="5" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rightcon">
<tr height="20"><td>&nbsp;</td></tr>
<tr>
<td height="565" align="center" valign="top">

<?
$mid=$_GET['mid']+0;

$rs=mysql_query("select q_uid,r_uid,reply_counts,is_done from message_table where mid=$mid");
$row=mysql_fetch_array($rs,MYSQL_ASSOC);
if($row)
{
	$canReply = 'no';	//�Ƿ���Իظ�
	if($row['is_done'] == 0){
		if($row['r_uid'] == $_SESSION['userid']){
			$canReply = 'yes';
		}else if($row['reply_counts'] > 0 and $row['q_uid'] == $_SESSION['userid']){
			$canReply = 'yes';
		}
	}

	if($canReply == 'yes')
	{
		$rs=mysql_query("select * from message_table where mid=$mid");
		$row=mysql_fetch_array($rs,MYSQL_ASSOC);
?>
<form name="reply" method="post" action="messageSave.php?action=reply&k=<? echo $k;?>&sort=all&page=<? echo $page;?>&mid=<? echo $mid;?>" enctype="multipart/form-data" onSubmit="return FormCheck()" onKeyDown="if(event.keyCode==13){return false;}">
<table width="800" border="1" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0" class="datatable" >
	<tr>
		<td class="b1" align="right" bgcolor="#fafafa" width="25%">���Ա��⣺</td>
		<td align="left"><div class="areastyle2 msgbg"><? echo $row['q_title'];?></div></td>
	</tr>
	<tr>
		<td class="b1" align="right" bgcolor="#fafafa">�������ݣ�</td>
		<td align="left"><div class="areastyle msgbg"><? echo $row['q_content'];?></div></td>
	</tr>
	<tr>
		<td class="b1" align="right" bgcolor="#fafafa">�ظ����ݣ�</td>
		<td align="left">&nbsp;<textarea name="reply_content" id="reply_content" class="areastyle"></textarea>&nbsp;��1000���ֽڷ�Χ�ڣ�</td>
	</tr>
	<tr>
		<td class="b1" align="right" bgcolor="#fafafa" valign="top">�ϴ�������</td>
		<td align="left">&nbsp;��<input name="is_load" type="radio" value="1" onClick="document.getElementById('upload').className='display2'">&nbsp;��<input name="is_load" type="radio" value="0" checked="checked" onClick="document.getElementById('upload').className='display1'"><br><span id="upload" class="display1"><input name="file" id="file" type="file" size="40"><br><font color="#FF0000">(�ļ��ϴ�����Ϊ��pdf,doc,docx,xls,xlsx,rar,zip,jpg)</font></span></td>
	</tr>
	<tr>
		<td class="b1" align="right" bgcolor="#fafafa">��֤�룺</td>
		<td align="left">&nbsp;<input type="text" name="msgcheckcode" id="msgcheckcode" size="6" class="txtInput" maxlength="4" onBlur="msgcodecheck()"/>&nbsp;<img src="msgcheckcode.php" align="absmiddle"  style="cursor:pointer" title="���ˢ����֤��" onClick="this.src='msgcheckcode.php?r='+Math.random()"/>&nbsp;&nbsp;<span id="msgcode"></span></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="left" bgcolor="#fafafa">&nbsp;<input type="submit" name="Submit" id="Submit" value=" �ύ " class="inBg3"></td>
	</tr>
</table>
</form>
<?	
	}else{ echo 'û���������';}
}else{ echo 'û���������';}?>
</td>
</tr>
</table>
<script type="text/javascript" src="js/show.js"></script>
<script type="text/javascript">
//ȥ���������ߵĿո�
function trim(str){ return str.replace(/(^\s*)|(\s*$)/g, "");}
function intCheck(str){ var reg=/^\d+$/; return reg.test(str);}
function LenCheck(str)
{
	var len=0;
	for (var i=0;i<str.length;i++) 
	{
		if(str.charCodeAt(i)>255) len+=2; else len++;
	}
	return len;
}
var msgcode=false;
function msgcodecheck()
{
	var v=document.getElementById('msgcheckcode').value;
	msgAjax('codecheck',v);
}
function FormCheck()
{
	var reply_content=trim(document.getElementById("reply_content").value);
	var msgcheckcode=trim(document.getElementById("msgcheckcode").value);
	if(reply_content==''){ alert('�ظ����ݲ���Ϊ�գ�');return false;}else if(LenCheck(reply_content)>5000){ alert('�ظ����ݲ��ܳ���5000���ֽڣ�');return false;}
	var arr=document.getElementsByName("is_load");
	if(arr[0].checked==true)
	{
		var file=trim(document.getElementById('file').value);
		if(file==''){ alert('�ϴ�������ַ����Ϊ�գ�');return false;}
	}
	if(msgcheckcode==''){ alert('��֤�벻������Ϊ�գ�');return false;}
	msgcodecheck();
	if(msgcode==false){ alert('��֤�벻��ȷ��');return false;}
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