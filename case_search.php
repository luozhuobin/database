<?
require('libs/config.inc.php');
if($_SESSION['username'] == '' or $_SESSION['flag'] < 40){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
$is_audit = array(
				1=>"<font color='blue'>�����</font>",
				2=>"<font color='green'>ͨ��</font>",
				3=>"<font color='red'>��ͨ��</font>"
			);
?>
<html>
<HEAD>
<TITLE>��������������=>������ѯ</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="��������������=>������ѯ">
<link href="<?php echo autoVer('css/style.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
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
<td><table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0"  >
<tr>
<td width="5">&nbsp;</td>
<td width="201" valign="top" class="leftsty">

<table border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td width="17"><img src="images/icon09.jpg" width="9" height="13"></td>
<td width="146"><div class="title01">�������������� </div></td>
<td width="16"><img src="images/icon11.jpg"  border="0"></td>
<td width="7" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<? include('caseleft.php')?>
</td>
<td width="5" valign="middle"><img src="images/btnleft.jpg"  width="5" height="117" border="0"></td>
<td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td><div class="title01">������ѯ</div></td>
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
<form method="post" name="myform" action="case_search.php?action=search">
<table width="860" border="0" align="center" cellpadding="0" cellspacing="0" class="datatable02" >
<tr>
<td height="30" align="left" valign="middle" style="line-height:180%;">
&nbsp;&nbsp;<b>������ѯ</b> <br>
&nbsp;&nbsp;��������:<INPUT class="inBg2" name="case_code"  size="10" value="<? echo $_REQUEST["case_code"];?>">
&nbsp;&nbsp;��ӳ����:<INPUT class="inBg2" name="start_date"  size="10" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<?php echo $_REQUEST["start_date"];?>">
~ <INPUT class="inBg2" name="end_date" size="10" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<?php echo $_REQUEST["end_date"];?>">
<script type="text/javascript">
function changedate(changedate)
{
	var changedate=changedate;
	document.myform.dateandtime.value=changedate;
} 
</script>

<br><br>
<?php 
	if($_SESSION['kind'] == 2 ||$_SESSION['kind'] == 3){
		echo '&nbsp;&nbsp;Ʒ�ƴ���:<INPUT class="inBg2" name="pinpai_code"  readonly="readonly" size="10" value="'.$_SESSION['pinpaicode'].'">';
	}else{
		echo '&nbsp;&nbsp;Ʒ�ƴ���:<INPUT class="inBg2" name="pinpai_code"  size="10" value="'.$_REQUEST["pinpai_code"].'">';
	}
	if($_SESSION['kind'] == 3){
		echo '&nbsp;&nbsp;��������:<INPUT class="inBg2" name="gongchang_code"  size="10" readonly="readonly" value="'.$_SESSION['gongchangcode'].'">';
	}else{
		echo '&nbsp;&nbsp;��������:<INPUT class="inBg2" name="gongchang_code"  size="10" value="'.$_REQUEST["gongchang_code"].'">';
	}
?>

&nbsp;&nbsp;�¼�����:
   <select name="shijianleixing">
       <option  value="" >����</option>
        <option  value="1" <? if($_REQUEST["shijianleixing"] == 1){?> selected="selected" <? }?>>��</option>
        <option  value="2" <? if($_REQUEST["shijianleixing"] == 2){?> selected="selected" <? }?>>��</option>
        <option  value="3" <? if($_REQUEST["shijianleixing"] == 3){?> selected="selected" <? }?>>��</option>
    </select>
<br><br>
<?php 
if($_SESSION['flag']>= 91){
?>
&nbsp;&nbsp;���״̬:
<select name="is_audit">
        <option  value="" >����</option>
        <option  value="1" <? if($_REQUEST["is_audit"] == 1){?> selected="selected" <? }?>>�����</option>
        <option  value="2" <? if($_REQUEST["is_audit"] == 2){?> selected="selected" <? }?>>���ͨ��</option>
        <option  value="3" <? if($_REQUEST["is_audit"] == 3){?> selected="selected" <? }?>>��˲�ͨ��</option>
    </select>
    <br><br>
<?php 
}
?>
&nbsp;&nbsp;<INPUT type="Submit" class="inBg3" value=" ��ѯ " name="Submit" ><br><br>
   </td>
  </tr>
</table>
</form>
<br><br>
<div class="searchrs" style="width:1000">������ѯ���</div>
<table width="1000" align="center" border="1" bordercolor="#dedfe0"  cellpadding="3" cellspacing="0" class="datatable">
<tr height="30" align="center">
	<td class="b1 titsty">�������</td>
	<td class="b1 titsty">��ӳ����</td>
	<td class="b1 titsty">Ʒ������</td>
	<td class="b1 titsty">Ʒ�Ʊ���</td>
	<td class="b1 titsty">��������</td>
	<td class="b1 titsty">��������</td>
	<td class="b1 titsty">BAS��ɫ</td>
	<?php 
		if($_SESSION['flag']>= 91){
	?>
	<td class="b1 titsty">���״̬</td>
	<?php 
		}
	?>
	<td class="b1 titsty" >�������</td>
</tr>
<?php 
$condition = array();
if(!empty($_REQUEST["case_code"])){
	$condition[] = " `case_code` = '{$_REQUEST["case_code"]}' ";
}
if(!empty($_REQUEST["start_date"])&&!empty($_REQUEST["end_date"])){
	if($_REQUEST["start_date"]>$_REQUEST["end_date"]){
		$tmp = $_REQUEST['start_date'];
		$_REQUEST["start_date"] = $_REQUEST["end_date"];
		$_REQUEST["end_date"] = $tmp;
	}
	$condition[] = " dateandtime BETWEEN ".strtotime($_REQUEST["start_date"])." AND ".strtotime("+1 day",strtotime($_REQUEST["end_date"]));
}
if(!empty($_REQUEST["pinpai_code"])){
	$condition[] = " pinpaicode = '{$_REQUEST["pinpai_code"]}'";
}
if(!empty($_REQUEST['gongchang_code'])){
	$condition[] = " gongchangcode = '{$_REQUEST['gongchang_code']}' ";
}
if(!empty($_REQUEST["shijianleixing"])){
	$arr = array("1"=>"'1','��'","2"=>"'2','��'","3"=>"'3','��'");
	$condition[] = " shijianleixing  in ({$arr[$_REQUEST['shijianleixing']]}) ";
}
if($_SESSION['flag']>=91&&!empty($_REQUEST['is_audit'])){
	$condition[] = " is_audit = {$_REQUEST['is_audit']}";
}
##Ʒ�ƻ��߹��� ֻ�ܿ���ͨ����˵ĸ���
if($_SESSION['flag']<91&&!empty($condition)){
	$condition[] = ' is_audit = 1 ';
}
$where = '';
if(!empty($condition)){
	$condition[] = " status = 1";//ֻ�ܲ���δ���ɾ���ĸ���
	$where = " WHERE ".implode(" AND ",$condition);
}
if(!empty($where)){
	$page = intval($_GET['page'])>0?intval($_GET['page']):0;
	$sql = "SELECT count(*) AS count FROM case_table {$where}";
	$result = mysql_fetch_assoc(mysql_query($sql));
	$pagesize = 15;
	$page = $page>ceil(intval($result["count"])/$pagesize)?ceil(intval($result["count"])/$pagesize):$page;
	$offset = $page>=1?($page-1)*$pagesize:0;
	$sql = "SELECT * FROM case_table {$where} ORDER BY caseid DESC LIMIT {$offset},{$pagesize}";
	$query = mysql_query($sql);
	while($row = mysql_fetch_assoc($query)){
		if(empty($row["pinpainame"])){
			$r = mysql_fetch_assoc(mysql_query("SELECT pinpainame FROM pinpai WHERE pinpaicode = '{$row["pinpaicode"]}'"));
			$row["pinpainame"] = $r["pinpainame"];
		}
		if(empty($row["gongchangname"])){
			$r = mysql_fetch_assoc(mysql_query("SELECT gongchangname FROM gongchang WHERE gongchangcode = '{$row["gongchangcode"]}'"));
			$row["gongchangname"] = $r["gongchangname"];
		}
		if(intval($row["shijianleixing"])>0){
			$row["shijianleixing"] = get_color($row["shijianleixing"]);
		}


?>
<tr align="center" height="28">
<td align="left">&nbsp;&nbsp;<a href="case.php?caseid=<? echo $row['caseid'];?>" target="_blank"><? echo $row['case_code'];?></a></td>
<td><? echo date('Y-m-d',$row['dateandtime']);?></td>
<td><? echo $row['pinpainame'];?></td>
<td><? echo $row['pinpaicode'];?></td>
<td><? echo $row['gongchangname'];?></td>
<td><? echo $row['gongchangcode'];?></td>
<td><? echo $row['shijianleixing'];?></td>
<?php echo $_SESSION['flag']>=91?"<td id='{$row["caseid"]}'>".$is_audit[$row['is_audit']]."</td>":'';?>
<td id="action<?php echo $row['caseid'];?>">
	<a href="case.php?caseid=<? echo $row['caseid'];?>" target="_blank">�鿴</a>
	<? if($_SESSION['flag'] >= 91){?>
		&nbsp;<a href="editcase.php?caseid=<? echo $row['caseid'];?>">�޸�</a>
	<? }?>
	<? if($_SESSION['flag'] > 91){?>
		&nbsp;<a href="case_adminsave.php?action=del&caseid=<? echo $row['caseid'];?>" onClick="if(confirm('ȷ��ɾ����?')==false){ return false;}">ɾ��</a>
	<? }?>
	<?php 
		if($_SESSION['flag']>=95){
			if($row['is_audit'] == 1 ){
				echo '<a href="javascript:;" onclick="do_audit('.$row["caseid"].',2);">&nbsp;ͨ��</a>&nbsp;<a href="javascript:;" onclick="showDiv('.$row["caseid"].',3,this);">��ͨ��</a>';
			}else if($row['is_audit'] == 2 ){
				echo '&nbsp;<a href="javascript:;" onclick="showDiv('.$row["caseid"].',3,this);">��ͨ��</a>';
			}else if($row['is_audit'] == 3 ){
				echo '<a href="javascript:;" onclick="do_audit('.$row["caseid"].',2);">&nbsp;ͨ��</a>';
			}
		}
	?>
</td>
</tr>
<?php 	
	}
	$SubPages = new SubPages($pagesize,$result["count"],$page,10,'/case_search.php?action=search&case_code='.$_REQUEST["case_code"]."&start_date=".$_REQUEST["start_date"]."&end_date=".$_REQUEST["end_date"]."&pinpai_code=".$_REQUEST["pinpai_code"]."&gongchang_code=".$_REQUEST["gongchang_code"]."&shijianleixing=".$_REQUEST["shijianleixing"].'&is_audit='.$_REQUEST['is_audit'].'&page=',2);
	$subPageCss2 = $SubPages->subPageCss2();
?>
<tr height="28" align="center">
<td colspan="8" class="pageCont">
<a href="javascript:;">��<?php echo $result["count"];?>������</a>
<?php echo $subPageCss2;?></td>
</tr>
<?php 
}
?>

</table>
</td>
<td></td>
</tr>
</table></td>
</tr>
</table>
<script type="text/javascript">
function pageTrans(p)
{
	var v = document.getElementById('param').value;
	location="?"+v+"&page="+p;
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
<?php include('showDiv.html');?>
<script type="text/javascript">
function showDiv(id,audit,obj){
	var height = $(obj).height();//��ť�ĸ߶�
    var top = $(obj).offset().top;//��ť��λ�ø߶�
    var left = $(obj).offset().left-300;//��ť��λ����߾���
    //����div��top left
    $("#saveDiv").css("left",left);
    $("#saveDiv").css("top",height+top);
    $("#saveDiv").css("z-index",10);
    $("#submitBut").attr("onclick","do_audit("+id+",3)");
    $("#saveDiv").show();
}
$("#cancleBut").click(function(){
	$("#saveDiv").hide();
});
	function do_audit(id,is_audit){
		var reason = $("#remark").val();
		if(is_audit == 3 && reason == ''){
			$("#result_info").html("�����벻ͨ����ԭ��");
			$("#result_info").show();
			return false;
		}
		$("#result_info").html("");
		$("#result_info").hide();
		$.ajax({
			url:"/model/case.php?action=do_audit",
			type:"GET",
			data:"id="+id+"&is_audit="+is_audit+"&reason="+encodeURIComponent(reason),
			dataType:"JSON",
			success:function(data){
				if(data["result"] == "1"){
					var audit = '';
					var content = 
						'<a href="case.php?caseid='+id+'" target="_blank">�鿴</a>'+
						'&nbsp;<a href="editcase.php?caseid='+id+'">�޸�</a>'+
						'&nbsp;<a href="case_adminsave.php?action=del&caseid='+id+'" onclick="if(confirm(\'ȷ��ɾ����?\')==false){ return false;}">ɾ��</a>';
					if(data["is_audit"] == "2" ){
						audit = '<font color="green">ͨ��</font>';
						content += '<a href="javascript:;" onclick="showDiv('+id+',3,this);">&nbsp;��ͨ��</a>';
					}else if(data["is_audit"] == "3" ){
						audit = '<font color="red">��ͨ��</font>';
						content += '<a href="javascript:;" onclick="do_audit('+id+',2);">&nbsp;ͨ��</a>';
					}
					$("#"+id).html(audit);
					$("#action"+id).html(content);
					$("#saveDiv").hide();
				}else{
					alert("����ʧ�ܣ���ˢ��ҳ�����ԡ�");
				}
			}
		})
	}
</script>
</body>
</html>