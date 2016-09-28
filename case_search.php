<?
require('libs/config.inc.php');
if($_SESSION['username'] == '' or $_SESSION['flag'] < 40){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
$is_audit = array(
				1=>"<font color='blue'>待审核</font>",
				2=>"<font color='green'>通过</font>",
				3=>"<font color='red'>不通过</font>"
			);
?>
<html>
<HEAD>
<TITLE>个案管理与生成=>个案查询</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="个案管理与生成=>个案查询">
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
<td width="146"><div class="title01">个案管理与生成 </div></td>
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
<td><div class="title01">个案查询</div></td>
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
&nbsp;&nbsp;<b>个案查询</b> <br>
&nbsp;&nbsp;个案编码:<INPUT class="inBg2" name="case_code"  size="10" value="<? echo $_REQUEST["case_code"];?>">
&nbsp;&nbsp;反映日期:<INPUT class="inBg2" name="start_date"  size="10" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<?php echo $_REQUEST["start_date"];?>">
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
		echo '&nbsp;&nbsp;品牌代码:<INPUT class="inBg2" name="pinpai_code"  readonly="readonly" size="10" value="'.$_SESSION['pinpaicode'].'">';
	}else{
		echo '&nbsp;&nbsp;品牌代码:<INPUT class="inBg2" name="pinpai_code"  size="10" value="'.$_REQUEST["pinpai_code"].'">';
	}
	if($_SESSION['kind'] == 3){
		echo '&nbsp;&nbsp;工厂代码:<INPUT class="inBg2" name="gongchang_code"  size="10" readonly="readonly" value="'.$_SESSION['gongchangcode'].'">';
	}else{
		echo '&nbsp;&nbsp;工厂代码:<INPUT class="inBg2" name="gongchang_code"  size="10" value="'.$_REQUEST["gongchang_code"].'">';
	}
?>

&nbsp;&nbsp;事件类型:
   <select name="shijianleixing">
       <option  value="" >不限</option>
        <option  value="1" <? if($_REQUEST["shijianleixing"] == 1){?> selected="selected" <? }?>>红</option>
        <option  value="2" <? if($_REQUEST["shijianleixing"] == 2){?> selected="selected" <? }?>>黄</option>
        <option  value="3" <? if($_REQUEST["shijianleixing"] == 3){?> selected="selected" <? }?>>绿</option>
    </select>
<br><br>
<?php 
if($_SESSION['flag']>= 91){
?>
&nbsp;&nbsp;审核状态:
<select name="is_audit">
        <option  value="" >不限</option>
        <option  value="1" <? if($_REQUEST["is_audit"] == 1){?> selected="selected" <? }?>>待审核</option>
        <option  value="2" <? if($_REQUEST["is_audit"] == 2){?> selected="selected" <? }?>>审核通过</option>
        <option  value="3" <? if($_REQUEST["is_audit"] == 3){?> selected="selected" <? }?>>审核不通过</option>
    </select>
    <br><br>
<?php 
}
?>
&nbsp;&nbsp;<INPUT type="Submit" class="inBg3" value=" 查询 " name="Submit" ><br><br>
   </td>
  </tr>
</table>
</form>
<br><br>
<div class="searchrs" style="width:1000">个案查询结果</div>
<table width="1000" align="center" border="1" bordercolor="#dedfe0"  cellpadding="3" cellspacing="0" class="datatable">
<tr height="30" align="center">
	<td class="b1 titsty">个案编号</td>
	<td class="b1 titsty">反映日期</td>
	<td class="b1 titsty">品牌名称</td>
	<td class="b1 titsty">品牌编码</td>
	<td class="b1 titsty">工厂名称</td>
	<td class="b1 titsty">工厂编码</td>
	<td class="b1 titsty">BAS分色</td>
	<?php 
		if($_SESSION['flag']>= 91){
	?>
	<td class="b1 titsty">审核状态</td>
	<?php 
		}
	?>
	<td class="b1 titsty" >管理操作</td>
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
	$arr = array("1"=>"'1','红'","2"=>"'2','黄'","3"=>"'3','绿'");
	$condition[] = " shijianleixing  in ({$arr[$_REQUEST['shijianleixing']]}) ";
}
if($_SESSION['flag']>=91&&!empty($_REQUEST['is_audit'])){
	$condition[] = " is_audit = {$_REQUEST['is_audit']}";
}
##品牌或者工厂 只能看到通过审核的个案
if($_SESSION['flag']<91&&!empty($condition)){
	$condition[] = ' is_audit = 1 ';
}
$where = '';
if(!empty($condition)){
	$condition[] = " status = 1";//只能查找未标记删除的个案
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
	<a href="case.php?caseid=<? echo $row['caseid'];?>" target="_blank">查看</a>
	<? if($_SESSION['flag'] >= 91){?>
		&nbsp;<a href="editcase.php?caseid=<? echo $row['caseid'];?>">修改</a>
	<? }?>
	<? if($_SESSION['flag'] > 91){?>
		&nbsp;<a href="case_adminsave.php?action=del&caseid=<? echo $row['caseid'];?>" onClick="if(confirm('确定删除吗?')==false){ return false;}">删除</a>
	<? }?>
	<?php 
		if($_SESSION['flag']>=95){
			if($row['is_audit'] == 1 ){
				echo '<a href="javascript:;" onclick="do_audit('.$row["caseid"].',2);">&nbsp;通过</a>&nbsp;<a href="javascript:;" onclick="showDiv('.$row["caseid"].',3,this);">不通过</a>';
			}else if($row['is_audit'] == 2 ){
				echo '&nbsp;<a href="javascript:;" onclick="showDiv('.$row["caseid"].',3,this);">不通过</a>';
			}else if($row['is_audit'] == 3 ){
				echo '<a href="javascript:;" onclick="do_audit('.$row["caseid"].',2);">&nbsp;通过</a>';
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
<a href="javascript:;">共<?php echo $result["count"];?>条数据</a>
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
	var height = $(obj).height();//按钮的高度
    var top = $(obj).offset().top;//按钮的位置高度
    var left = $(obj).offset().left-300;//按钮的位置左边距离
    //设置div的top left
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
			$("#result_info").html("请输入不通过的原因。");
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
						'<a href="case.php?caseid='+id+'" target="_blank">查看</a>'+
						'&nbsp;<a href="editcase.php?caseid='+id+'">修改</a>'+
						'&nbsp;<a href="case_adminsave.php?action=del&caseid='+id+'" onclick="if(confirm(\'确定删除吗?\')==false){ return false;}">删除</a>';
					if(data["is_audit"] == "2" ){
						audit = '<font color="green">通过</font>';
						content += '<a href="javascript:;" onclick="showDiv('+id+',3,this);">&nbsp;不通过</a>';
					}else if(data["is_audit"] == "3" ){
						audit = '<font color="red">不通过</font>';
						content += '<a href="javascript:;" onclick="do_audit('+id+',2);">&nbsp;通过</a>';
					}
					$("#"+id).html(audit);
					$("#action"+id).html(content);
					$("#saveDiv").hide();
				}else{
					alert("操作失败，请刷新页面重试。");
				}
			}
		})
	}
</script>
</body>
</html>