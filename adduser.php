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
<!doctype html>
<HEAD>
<TITLE>��ѯϵͳ����=>������û�</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="��ѯϵͳ����=>������û�">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
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
<td><div class="title01">������û�</div></td>
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

<form method="post" name="myform" action="adminusersave.php?action=add" onSubmit="return FormCheck(myform)">
<table width="600" border="1" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0" class="datatable">
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa" width="25%">�û����ƣ�</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="username"  size="30" value=""></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa">�û����룺</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="userpass"  size="30" value=""></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa">����״̬��</td>
   <td align="left">&nbsp;<select name="work">
        <option  value=1  selected="selected">��ְ</option>
        <option  value=0  >��ְ</option>
    </select>
	</td>
  </tr>
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa">����Ȩ�ޣ�</td>
   <td align="left">
<?
/*
   99 ϵͳ����Ա
   98 ����Ա�����Ա
   95 ����
   91 ��ͨԱ��
   50 Ʒ��
   40 ����
   */
?>&nbsp;<select name="flag" onChange="changePurview();" id="purview">
        <option  value=99 >ϵͳ����Ա</option>
        <option  value=98 >����Ա�����Ա</option>
        <option  value=95 >ӳŵ����</option>
        <option  value=91 >ӳŵ��ͨԱ��</option>
        <option  value=50 >Ʒ��</option>
        <option  value=40 >����</option>
    </select></td>
  </tr>
  <tr height="28" id="tr1" style="display:none">
   <td class="b1" align="right" bgcolor="#fafafa">����Ʒ�ƣ�</td>
   <td align="left">
   	<select name="pinpaicode" id="pinpaicode" onChange="changeBrands();">
	<option value="0">��ѡ��</option>
	<?
	$rs = mysql_query("select * from pinpai");
	while($row = mysql_fetch_array($rs,MYSQL_ASSOC))
	{
?>
        <option value="<? echo $row['pinpaicode'];?>" ><? echo $row['pinpainame'];?></option>
<?
	}mysql_free_result($rs);
?>
    </select></td>
  </tr>
  <tr height="28" id="tr2" style="display:none">
   <td class="b1" align="right" bgcolor="#fafafa">����������</td>
   <td align="left" >
   <select name="gongchangcode" id="gongchang">
		<option value="0">��ѡ��</option>
    </select>
    </td>
  </tr>
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa">��ϵ�绰��</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="phone"  size="30" value=""></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa">��ϵ�ֻ���</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="mobile"  size="30" value=""></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa">��ϵ��ַ��</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="address"  size="30" value=""></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa">�����ַ��</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="Email"  size="30" value=""><br>&nbsp;
����������ʱ�ᷢ��������Ϣ�������䣩</td>
  </tr>
  <tr height="28" align="center">
   <td class="b1">&nbsp;</td>
   <td align="left">&nbsp;<INPUT type="submit" class="inBg3" value=" ��� "  name="Submit" ></td>
  </tr>
</table>
</form>
</td>
<td></td>
</tr>
</table></td>
</tr>
</table>
<script type="text/javascript">
function changePurview(){
	var purview = $("#purview").val();
	if(purview == 40){
		//����		
		$("#tr1").show();
		$("#tr2").show();
	}else if(purview == 50){
		//Ʒ��
		$("#tr1").show();
	}else{
		$("#tr1").hide();
		$("#tr2").hide();
	}
}
function changeBrands(){
	var brands = $("#pinpaicode").val();
	var purview = $("#purview").val();
	if(purview == 40){
		$.ajax({
			url:"/model/user.php?action=getFactoryByBrands",
			type:"POST",
			data:"brands="+brands,
			dataType:"json",
			success:function(data){
				var content = '<option value="0">��ѡ��</option>';
				$.each(data,function(key,val){
					content += '<option value="'+key+'">'+val+'</option>';
				})	
				$("#gongchang").html(content);		
			}
		});
	}
}

function trim(str){ return str.replace(/(^\s*)|(\s*$)/g, "");}
function isEmail(str){ var reg=/^([a-zA-Z0-9_\-\.\+]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/; return reg.test(str);}	
function FormCheck(form)
{
	var username=trim(form.username.value);
	var userpass=trim(form.userpass.value);
	var Email=trim(form.Email.value);
	if(username==''){
		alert("�û����Ʋ���Ϊ�գ�");
		form.username.focus();
		return false;
	}
	if(userpass==''){
		alert("�û����벻��Ϊ�գ�");
		form.userpass.focus();
		return false;
	}
	if(Email != '' && isEmail(Email) == false)
	{
		alert("�����ַ��ʽ����ȷ��");
		form.Email.focus();
		return false;
	}
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
<td>
<? include('foot.php');?>
</td>
</tr>
</table>
</body>
</html>