<?
require('libs/config.inc.php');
if($_SESSION['username'] == '')
{
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag'] < 91)
{
	mysql_close($conn);
	echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
	exit;
}
?>
<html>
<HEAD>
<TITLE>��������������=>��������</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="��������������=>��������">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/My97DatePicker/WdatePicker.js"></script>
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
<td><table height="100%"  align="center" width="100%" border="0" cellspacing="0" cellpadding="0"  >
<tr>
<td align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td><div class="title01">��������������>>��������</div></td>
<td width="28"><img src="images/icon12.jpg"  border="0"></td>
<td width="5" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>

<table width="100%"  align="center" border="0" cellspacing="0" cellpadding="0" class="rightcon">
<tr>
<td height="100%" align="center" valign="top"><table border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td width="10">&nbsp;</td>
<td>&nbsp;</td>
<td width="10">&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="center">

 
<form method="post" name="myform" action="case_adminsave.php?action=add" onSubmit="return FormCheck(myform)">
<table width="1200" align="center"  valign="top" border="1" bordercolor="#dedfe0"  cellpadding="6" cellspacing="0" class="datatable">
  <tr height="30">
   <td align="right" width="15%">��������:</td>
   <td align="left" width="20%"><INPUT type="text" class="inBg2" name="case_code"  size="20" value=""></td>
   <td align="right" width="15%">������ӳʱ��:</td>
   <td align="left" width="20%"><INPUT type="text" class="inBg2" name="dateandtime"  size="20" value="" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})"><br>
(��ʽΪ��<? echo date('Y-m-d',time());?>������Ϊ��)</td>
   <td align="right" width="15%">�����¼�����:<br>����BAS���涨��ɫ���</td>
   <td align="left" width="15%">
   <select name="shijianleixing">
        <option  value="��" >��</option>
        <option  value="��">��</option>
        <option  value="��">��</option>
    </select>
	</td>
  </tr>
  <tr height="30">
   <td align="right">�������:</td>
   <td align="left">
   		<INPUT type="text" class="inBg2" name="question_type"  size="20"  /><br>
	</td>
					
   <td align="right">Ʒ�ƴ���:</td>
   <td align="left">
    <select name="pinpaicode" onChange="showAjax(2,this.value)">
		<option value="0">��ѡ��</option><?
   	$rs = mysql_query('select gongchangpinpai from gongchang GROUP BY gongchangpinpai');
	while($row = mysql_fetch_array($rs))
	{
	?>
        <option value="<? echo $row['gongchangpinpai'];?>"><? echo $row['gongchangpinpai'];?></option>
   <?
	}mysql_free_result($rs);
   ?>
    </select>
   <td align="right">��������:</td>
   <td align="left" id="gongchang">
    <select name="gongchangcode">
		<option value="0">��ѡ��</option>
    </select></td>
  </tr>
  <tr height="30">
   <td align="right">�����Ա�/����/����</td>
   <td align="left">
   <select name="xingbie">
        <option  value="1" >����</option>
        <option  value="2" >Ů��</option>
        <option  value="0" >δ֪</option>
    </select> / <INPUT type="text" class="inBg2" name="nianling"  size="5" value=""> / <INPUT type="text" class="inBg2" name="experience"  size="5" value="">
    </td>
   <td align="right">�������ڲ��ţ�</td>
   <td align="left"><INPUT type="text" class="inBg2" name="bumen"  size="20" value=""></td>
   <td align="right">��������״��:</td>
   <td align="left">
  	 <INPUT type="text" class="inBg2" name="xianzhuang"  size="20" value="">
	</td>
  <tr height="30" style="border-top:1px solid #DFC2DB;border-lsft:1px solid #DFC2DB;border-right:1px solid #DFC2DB; background:#F49E3B; ">
   <td  align="left" colspan="2" >�¼�����:</td>
   <td  align="left" colspan="2" >���ֽ��:</td>
   <td  align="left" colspan="2" >Ʒ��/������λظ�:</td>
  </tr>
  <tr height="30" valign="top" style="border-bottom:1px solid #DFC2DB;border-lsft:1px solid #DFC2DB;border-right:1px solid #DFC2DB; background:#F49E3B; ">
   <td align="left" colspan="2">
   		<textarea rows="15" name="miaoshu" cols="50" class="smallarea"></textarea>
   </td>
   <td align="left" colspan="2">
   		<textarea rows="15" name="solve_method" cols="50" class="smallarea"></textarea>
   </td>
   <td align="left" colspan="2">
   		<textarea rows="15" name="reply" cols="50" class="smallarea"></textarea
   </td>
  </tr>
  <tr height="30" style="border-top:1px solid #DFC2DB;border-lsft:1px solid #DFC2DB;border-right:1px solid #DFC2DB; background:#F49E3B; ">
   <td  align="left" colspan="2" >��������/��ע:</td>
   <td  align="left" colspan="2" >������λ�Ӧ:</td>
   <td  align="left" colspan="2" ></td>
  </tr>
    <tr height="30" valign="top" style="border-bottom:1px solid #DFC2DB;border-lsft:1px solid #DFC2DB;border-right:1px solid #DFC2DB; background:#F49E3B; ">
   <td align="left" colspan="2">
   		<textarea rows="15" name="beizhu" cols="50" class="smallarea"></textarea>
   </td>
   <td align="left" colspan="2">
   		<textarea rows="15" name="respond" cols="50" class="smallarea"></textarea>
   </td>
  </tr>
  <tr height="30">
   <td align="right">���ʱ��:</td>
   <td align="left" colspan="3"><INPUT type="text" class="inBg2" name="jjueshijian"  size="20" value="" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})">(��ʽΪ��<? echo date('Y-m-d',time());?>������Ѿ�������������д)</td>
   <td align="right">�¼����:</td>
   <td align="left" colspan="2">
   <select name="jieguo">
        <option  value="0" >��δ���</option>
        <option  value="1" >�Ѿ����</option>
    </select>  </td>
  </tr>
  <tr height="30" align="center">
   <td class="b1" colspan="6" ><INPUT type="Submit" class="inBg3" value=" ��� " name="Submit" ></td>
  </tr>
</table>
</form>
<script src="js/show.js" type="text/javascript"></script>
<script type="text/javascript">
function trim(str){ return str.replace(/(^\s*)|(\s*$)/g, "");}
function FormCheck(form)
{
	var case_code=trim(form.case_code.value);
	var dateandtime=trim(form.dateandtime.value);
	var jieguo=form.jieguo.value;
	var jjueshijian=trim(form.jjueshijian.value);
	if(case_code==''){
		alert("�������벻��Ϊ�գ�");
		form.case_code.focus();
		return false;
	}
	if(dateandtime==''){
		alert("������ӳʱ�䲻��Ϊ�գ�");
		form.dateandtime.focus();
		return false;
	}
	if(jieguo == 1 && jjueshijian == ''){
		alert("�¼����ѡ���Ѿ����ʱ�����ʱ�䲻��Ϊ�գ�");
		form.jjueshijian.focus();
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