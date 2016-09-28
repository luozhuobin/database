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
	echo '您权限不足，请使用有权限的用户名称进行登录';
	exit;
}
?>
<html>
<HEAD>
<TITLE>查询系统管理=>修改用户</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="查询系统管理=>修改用户">
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
<td><div class="title01">修改用户</div></td>
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
$userid=$_GET['userid']+0;
$page = $_GET['page'] + 0;
$sql='select * from user where userid='.$userid;
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs, MYSQL_ASSOC);
if($row)
{
	mysql_free_result($rs);
?>
<form method="post" name="myform" action="adminusersave.php?action=edit&userid=<? echo $row['userid'];?>&page=<? echo $page;?>" onSubmit="return FormCheck(myform)">
<table width="600" border="1" bordercolor="#dedfe0" align="center" cellpadding="5" cellspacing="0" class="datatable">
  <tr height="20">
   <td class="b1" align="right" bgcolor="#fafafa" width="25%">用户名称：</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="username"  size="30" value="<? echo $row['username'];?>"></td>
  </tr>
  <tr height="20">
   <td class="b1" align="right" bgcolor="#fafafa">用户密码：</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="userpass"  size="30" value="<? echo $row['userpass'];?>"></td>
  </tr>
  <tr height="20">
   <td class="b1" align="right" bgcolor="#fafafa">工作状态：</td>
   <td align="left">&nbsp;<select name="work">
        <option  value=1 <? if($row['work'] == 1){?>selected="selected"<? }?> >在职</option>
        <option  value=0 <? if($row['work'] == 0){?>selected="selected"<? }?> >离职</option>
    </select>
	</td>
  </tr>
  <tr height="20">
   <td class="b1" align="right" bgcolor="#fafafa">操作权限：</td>
   <td align="left">&nbsp;<?
/*
   99 系统管理员
   98 程序员或测试员
   95 主管
   91 普通员工
   50 品牌
   40 工厂
   */
?><select name="flag" onChange="changePurview();" id="purview">
        <option  value=99 <? if($row['flag'] == 99){?>selected="selected"<? }?> >系统管理员</option>
        <option  value=98 <? if($row['flag'] == 98){?>selected="selected"<? }?> >程序员或测试员</option>
        <option  value=95 <? if($row['flag'] == 95){?>selected="selected"<? }?> >映诺主管</option>
        <option  value=91 <? if($row['flag'] == 91){?>selected="selected"<? }?> >映诺普通员工</option>
        <option  value=50 <? if($row['flag'] == 50){?>selected="selected"<? }?> >品牌</option>
        <option  value=40 <? if($row['flag'] == 40){?>selected="selected"<? }?> >工厂</option>
    </select></td>
  </tr>
<?
	$display = 'style="display:none"';
	if($row['flag'] < 51){ $display = '';}
?>
  <tr height="28" id="tr1" <? echo $display;?>>
   <td class="b1" align="right" bgcolor="#fafafa">所属品牌：</td>
   <td align="left">&nbsp;
   <select name="pinpaicode" id="pinpaicode" onChange="changeBrands();">
	<option value="0">请选择</option><?
	$rs2 = mysql_query("select * from pinpai");
	while($row2 = mysql_fetch_array($rs2, MYSQL_ASSOC))
	{
?>
        <option value="<? echo $row2['pinpaicode'];?>" <? if($row['pinpaicode'] == $row2['pinpaicode']){ ?> selected="selected" <? }?>><? echo $row2['pinpainame'];?></option>
<?	}?>
    </select></td>
  </tr>
<?
	$display = 'style="display:none"';
	if($row['flag'] < 41){ $display = '';}
?>
  <tr height="28" id="tr2" <? echo $display;?>>
   <td class="b1" align="right" bgcolor="#fafafa">所属工厂：</td>
   <td align="left" >&nbsp;<select name="gongchangcode" id="gongchang">
	<option value="0">请选择</option><?
	$rs2 = mysql_query($sql = "SELECT gongchangcode,gongchangname FROM gongchang WHERE gongchangpinpai = '{$row['pinpaicode']}'");
	while($row2 = mysql_fetch_array($rs2, MYSQL_ASSOC))
	{
?>
        <option value="<? echo $row2['gongchangcode'];?>" <? if($row['gongchangcode'] == $row2['gongchangcode']){ ?> selected="selected" <? }?>><? echo $row2['gongchangname'];?></option>
<?	}?>
    </select></td>
  </tr>
  <tr height="20">
   <td class="b1" align="right" bgcolor="#fafafa">联系电话：</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="phone"  size="30" value="<? echo $row['phone'];?>"></td>
  </tr>
  <tr height="20">
   <td class="b1" align="right" bgcolor="#fafafa">联系手机：</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="mobile"  size="30" value="<? echo $row['mobile'];?>"></td>
  </tr>
  <tr height="20">
   <td class="b1" align="right" bgcolor="#fafafa">联系地址：</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="address"  size="30" value="<? echo $row['address'];?>"></td>
  </tr>
  <tr height="28">
   <td class="b1" align="right" bgcolor="#fafafa">邮箱地址：</td>
   <td align="left">&nbsp;<INPUT type="text" class="inBg2" name="Email"  size="30" value="<? echo $row['Email'];?>"><br>&nbsp;
（有新留言时会发送提醒消息至该邮箱）</td>
  </tr>
  <tr height="20">
   <td class="b1" align="right" bgcolor="#fafafa">添加时间：</td>
   <td align="left">&nbsp;<? echo date('Y-m-d H:i:s',$row['adddate']);?></td>
  </tr>
  <tr height="20">
   <td class="b1" align="right" bgcolor="#fafafa">最后登录时间：</td>
   <td align="left">&nbsp;<? if($row['lastlogindate'] == 0){ echo '-';}else{ echo date('Y-m-d H:i:s',$row['lastlogindate']);}?></td>
  </tr>
  <tr height="28">
	<td>&nbsp;</td>
	<td align="left">&nbsp;<INPUT type="submit" class="inBg3" value=" 修改 " name="Submit" ></td>
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
<script src="js/show.js" type="text/javascript"></script>
<script type="text/javascript">
function changePurview(){
	var purview = $("#purview").val();
	if(purview == 40){
		//工厂		
		$("#tr1").show();
		$("#tr2").show();
	}else if(purview == 50){
		//品牌
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
				var content = '<option value="0">请选择</option>';
				$.each(data,function(key,val){
					content += '<option value="'+key+'">'+val+'</option>';
				})	
				$("#gongchang").html(content);		
			}
		});
	}
}
function trim(str){ return str.replace(/(^\s*)|(\s*$)/g, "");}
function isEmail(str){ var reg=/^([a-zA-Z0-9_\-\.\+]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;return reg.test(str);}	
function FormCheck(form)
{
	var username=trim(form.username.value);
	var userpass=trim(form.userpass.value);
	var Email=trim(form.Email.value);
	if(username==''){
		alert("用户名称不能为空！");
		form.username.focus();
		return false;
	}
	if(userpass==''){
		alert("用户密码不能为空！");
		form.userpass.focus();
		return false;
	}
	if(Email != '' && isEmail(Email) == false)
	{
		alert("邮箱地址格式不正确！");
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