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
	
	$userid = $_SESSION['userid'];
	$username = $_SESSION['username'];
	$kind = $_SESSION['kind'];
	$pinpaicode = $_SESSION['pinpaicode'];
	$gongchangcode = $_SESSION['gongchangcode'];
	$pinpainame = $_SESSION['pinpainame'];
	$gongchangname = $_SESSION['gongchangname'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>����=>��������</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="����=>��������">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
function selectObj(){
	var selectVal = $("#selectVal").val();
	var sendObj = $("#sendObj").val();
	if(selectVal != ''&&sendObj.indexOf(selectVal)=='-1'){
		sendObj += selectVal+';';
	}
	$("#sendObj").val(sendObj);
}
function sendObjCheck(){
	var sendObj = $("#sendObj").val();
	if(sendObj == ''){
		$("#resultInfo").html("��ѡ�����Զ���");
		return false;
	}else{
		$("#resultInfo").html("");
		return true;
	}
}
function titleCheck(){
	var title = $("#title").val();
	if(title == ''){
		$("#resultInfo").html("���������Ա��⡣");
		return false;
	}else{
		$("#resultInfo").html("");
		return true;
	}
}
function contentCheck(){
	var content = $("#content").val();
	if(content == ''){
		$("#resultInfo").html("�������������ݡ�");
		return false;
	}else{
		$("#resultInfo").html("");
		return true;
	}
}
function codeCheck(){
	var code = $("#code").val();
	if(code == ''){
		$("#resultInfo").html("��������֤�롣");
		return false;
	}else{
		$("#resultInfo").html("");
		return true;
	}
}
function FormCheck(){
	if(sendObjCheck()&&titleCheck()&&contentCheck()&&codeCheck()){
		return true;
	}else{
		return false;
	}
}
</script>
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
<td><div class="title01">��������</div></td>
<td width="28"><img src="images/icon12.jpg"  border="0"></td>
<td width="5" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rightcon">
<tr height="20"><td>&nbsp;</td></tr>
<tr>
<td height="565" align="left" valign="top">
<form name="addmsg" method="post" action="/model/message.php?action=addmsg" enctype="multipart/form-data" onSubmit="return FormCheck()" onKeyDown="if(event.keyCode==13){return false;}">
<table width="800" border="1" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0" class="datatable" >
	<tr>
		<td class="b1" align="right" bgcolor="#fafafa" width="25%">���Զ���</td>
		<td align="left">
			&nbsp;<textarea name="sendObj" id="sendObj" class="areastyle2"><? if($_COOKIE['sendObj']){ echo $_COOKIE['sendObj'];}?></textarea>
			<select name="selectVal" id="selectVal" style="width:130px;padding:4px;text-align:center;" onchange="selectObj();">
				<option value="">��ѡ��</option>
				<?php 
					switch($_SESSION['kind']){
						case '1':
							##������Ա �ɶ�ϵͳ������Ա����
							$sql = "SELECT userid,username FROM `user` WHERE userid != {$userid} ORDER BY kind ASC ,flag DESC ";
						break;
						case '2':
							##Ʒ�� �ɶ�������Ա �� �Լ��Ĺ�������
							$sql = "SELECT userid,username FROM `user` WHERE kind = 1 OR (kind = 3 AND pinpaicode = '{$pinpaicode}') ORDER BY kind ASC ,flag DESC ";
						break;
						case '3':
							##���� �ɶ�������Ա  �� �Լ�����Ʒ������
							$sql = "SELECT userid,username FROM `user` WHERE kind = 1 OR (kind = 2 AND pinpaicode = '{$pinpaicode}') ORDER BY kind ASC ,flag DESC ";
						break;
					}
					$rs = mysql_query($sql);
					while($row = mysql_fetch_assoc($rs)){
						echo '<option value="'.$row["username"].'">'.$row["username"].'</option>';
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="b1" align="right" bgcolor="#fafafa" width="25%">���Ա��⣺</td>
		<td align="left">&nbsp;<textarea name="title" id="title" class="areastyle2"><? if($_COOKIE['handshakemsgtitle']){ echo $_COOKIE['handshakemsgtitle'];}?></textarea>&nbsp;��100���ֽڷ�Χ�ڣ�</td>
	</tr>
	<tr>
		<td class="b1" align="right" bgcolor="#fafafa">�������ݣ�</td>
		<td align="left">&nbsp;<textarea name="content" id="content" class="areastyle"><? if($_COOKIE['handshakemsgcontent']){ echo $_COOKIE['handshakemsgcontent'];}?></textarea>&nbsp;��1000���ֽڷ�Χ�ڣ�</td>
	</tr>
	
	<tr>
		<td class="b1" align="right" bgcolor="#fafafa" valign="top">�ϴ�������</td>
		<td align="left">&nbsp;��<input name="is_load" type="radio" value="1" onClick="document.getElementById('upload').className='display2'">&nbsp;��<input name="is_load" type="radio" value="0" checked="checked" onClick="document.getElementById('upload').className='display1'"><br><span id="upload" class="display1"><input name="file" id="file" type="file" size="40"><br><font color="#FF0000">(�ļ��ϴ�����Ϊ��pdf,doc,docx,xls,xlsx,rar,zip,jpg)</font></span></td>
	</tr>
	<tr>
		<td class="b1" align="right" bgcolor="#fafafa">��֤�룺</td>
		<td align="left">&nbsp;<input type="text" name="code" id="code" size="6" class="txtInput" maxlength="4" />&nbsp;<img src="msgcheckcode.php" align="absmiddle"  style="cursor:pointer" title="���ˢ����֤��" onClick="this.src='msgcheckcode.php?r='+Math.random()"/>&nbsp;&nbsp;<span id="msgcode"></span></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="left" bgcolor="#fafafa">&nbsp;
			<input type="submit" name="Submit" id="Submit" value=" �ύ " class="inBg3">
			<span id="resultInfo" style="margin-left:5px;color:red;"></span>
		</td>
	</tr>
</table>
</form>
</td>
</tr>
</table>
</td>
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