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
<TITLE>个案管理与生成=>查看个案</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="个案管理与生成=>查看个案">
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
<td><table height="100%"  align="center" width="100%" border="0" cellspacing="0" cellpadding="0"  >
<tr>
<td align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td><div class="title01">个案管理与生成>>查看个案</div></td>
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

<?
$caseid = $_GET['caseid'] + 0;
$sql = 'select * from case_table where caseid=' . $caseid;
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs, MYSQL_ASSOC);
if($_SESSION['flag']<91){
	if(($_SESSION['kind'] == 2 && $row['pinpaicode'] != $_SESSION['pinpaicode'] )
		||($_SESSION['kind'] == 3 && $row['gongchangcode'] != $_SESSION['gongchangcode'])){
		echo '<script type="text/javascript">alert("权限不足");window.location.href="/case_search.php"</script>';
		exit();
	}
}
if(intval($row["shijianleixing"])>0){
	$row["shijianleixing"] = get_color($row["shijianleixing"]);
}
if(empty($row["question_type"])){
	$arr = array("class_1"=>$row["class_1"],"class_2"=>$row["class_2"],"class_3"=>$row["class_3"]);
	$class = array("class_1"=>"投诉","class_2"=>"咨询","class_3"=>"心理");
	arsort($arr);
	$arr2 = $arr;
	$top = array_shift($arr);
	$key = array_search($top,$arr2);
	$row["question_type"] = $class[$key];
}
if(intval($row["xingbie"])>0){
	$row["xingbie"] = get_sex($row['xingbie']);
}
if(intval($row["xianzhuang"])>0){
	$status = array(1=>"愤怒",2=>"平静",3=>"沮丧",4=>"未知");
	$row["xianzhuang"] = $status[$row["xianzhuang"]];
}
if($row)
{
	mysql_free_result($rs);
?>
<?php 
	if($row['is_audit'] != 3){
		echo '<style type="text/css">.no_pass{display:none;}</style>';
	}
?>
<table width="1000" align="center" border="1" bordercolor="#dedfe0"  cellpadding="6" cellspacing="0" class="datatable">
  <tr height="30">
   <td align="right" width="15%">个案编码:</td>
   <td align="left" width="20%"><? echo $row['case_code'];?></td>
   <td align="right" width="15%">事主反映时间:</td>
   <td align="left" width="20%"><? echo date('Y-m-d',$row['dateandtime']);?></td>
   <td align="right" width="15%">事主事件类型:<br>按《BAS》规定颜色填充</td>
   <td align="left" width="15%"><? echo $row['shijianleixing'];?></td>
  </tr>
  <tr height="30">
   <td align="right">问题分类:</td>
   <td align="left">
   		<?php echo $row["question_type"];?>
	</td>
   <td align="right">品牌代码:</td>
   <td align="left"><? echo $row['pinpaicode'];?></td>
   <td align="right">工厂代号：</td>
   <td align="left"><? echo $row['gongchangcode'];?></td>
  </tr>
  <tr height="30">
   <td align="right">事主性别/年龄/工龄:</td>
   <td align="left"><? echo empty($row['xingbie'])?'未知':$row['xingbie'];;?> / <? echo empty($row['nianling'])?'未知':$row['nianling'];?> / <?php echo empty($row["experience"])?'未知':$row["experience"];;?></td>
   <td align="right">事主所在部门:</td>
   <td align="left"><? echo $row['bumen'];?></td>
   <td align="right">事主现在状况:</td>
   <td align="left"><? echo $row['xianzhuang'];?></td>
  </tr>
  <tr height="30" style="border-top:1px solid #DFC2DB;border-lsft:1px solid #DFC2DB;border-right:1px solid #DFC2DB; background:#F49E3B; ">
   <td align="left" colspan="2" >事件描述:</td>
   <td align="left" colspan="2" >握手解决:</td>
   <td align="left" colspan="2" >品牌/工厂回复:</td>
  </tr>
  <tr height="30" valign="top" style="border-bottom:1px solid #DFC2DB;border-lsft:1px solid #DFC2DB;border-right:1px solid #DFC2DB; ">
   <td align="left" colspan="2"><? echo nl2br($row['miaoshu']);?></td>
   <td align="left" colspan="2"><? echo nl2br($row['solve_method']);?></td>
   <td align="left" colspan="2"><?php echo nl2br($row["reply"]);?></td>
  </tr>
  <tr height="30" style="border-top:1px solid #DFC2DB;border-lsft:1px solid #DFC2DB;border-right:1px solid #DFC2DB; background:#F49E3B; ">
   <td align="left" colspan="2" >其他评论/备注:</td>
   <td align="left" colspan="2" >事主回应:</td>
   <?php 
   	if($_SESSION['flag']>=91){
   		echo '<td align="left" colspan="2" >审核状态:</td>';
   	}
   ?>
  </tr>
  <tr height="30" valign="top" style="border-bottom:1px solid #DFC2DB;border-lsft:1px solid #DFC2DB;border-right:1px solid #DFC2DB;  ">
   <td align="left" colspan="2"><? echo nl2br($row['beizhu']);?></td>
   <td align="left" colspan="2"><? echo nl2br($row["respond"]);?></td>
   <?php 
   	if($_SESSION['flag']>=91){
   	?>
   	<td align="left" colspan="2" id="<?php echo $row['caseid'];?>"><? echo $is_audit[$row["is_audit"]];?></td>
   	<?php 
   	}
   ?>
   
  </tr>
  <?php 
  	if($_SESSION['flag']>=91){
  ?>
   <tr class = "no_pass" height="30" style="border-top:1px solid #DFC2DB;border-lsft:1px solid #DFC2DB;border-right:1px solid #DFC2DB; background:#F49E3B; ">
   <td align="left" colspan="6" >审核不通过原因:</td>
  </tr>
  <tr class = "no_pass" height="30" valign="top" style="border-bottom:1px solid #DFC2DB;border-lsft:1px solid #DFC2DB;border-right:1px solid #DFC2DB;  ">
   <td align="left" colspan="6" id="reason"><? echo nl2br($row['reason']);?></td>
  </tr>
  <?php 
  	}
  ?>

  <tr height="30">
   <td align="right" >事件结果:</td>
   <td align="left"><? echo $row['jieguo']==1?'已经解决':'尚未解决';;?></td>
   <td align="right">解决时间:</td>
   <td align="left"><? if($row['jjueshijian'] == 0){ echo '-';}else{ echo date('Y-m-d',$row['jjueshijian']);}?></td>
   <?php 
   	if($row['status'] == 1){
   ?>

   <td align="right">管理选项:</td>
   <td align="left" id="action<?php echo $row['caseid'];?>"> 
<? if($_SESSION['flag'] >= 91){ ?>
   <a href="editcase.php?caseid=<? echo $row['caseid'];?>">修改</a>&nbsp;
   <? if($_SESSION['flag'] > 91){ ?>
   	<a href="case_adminsave.php?action=del&caseid=<? echo $row['caseid'];?>">删除</a>&nbsp;
   <?php }?>
   <?php 
		if($_SESSION['flag']>=95){
			if($row['is_audit'] == 1 ){
				echo '<a href="javascript:;" onclick="do_audit('.$row["caseid"].',2);">通过</a>&nbsp;<a href="javascript:;" onclick="showDiv('.$row["caseid"].',3,this);">不通过</a>';
			}else if($row['is_audit'] == 2 ){
				echo '<a href="javascript:;" onclick="showDiv('.$row["caseid"].',3,this);">不通过</a>';
			}else if($row['is_audit'] == 3 ){
				echo '<a href="javascript:;" onclick="do_audit('.$row["caseid"].',2);">通过</a>';
			}
		}
   ?>
<?	}else{ echo '&nbsp;';}?></td>
   <?php 
   	}
   ?>
  </tr>
</table>
<?
}
else
{
	echo '<center>', $tip, '</center>';
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
<?php include('showDiv.html');?>
<script type="text/javascript">
function showDiv(id,audit,obj){
	var height = $(obj).height();//按钮的高度
    var top = $(obj).offset().top-220;//按钮的位置高度
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
					'<a href="editcase.php?caseid='+id+'">修改</a>&nbsp;'+
					   '<a href="case_adminsave.php?action=del&caseid='+id+'">删除</a>&nbsp;';
				if(data["is_audit"] == "2" ){
					audit = '<font color="green">通过</font>';
					content += '<a href="javascript:;" onclick="showDiv('+id+',3,this);">不通过</a>';
					$(".no_pass").hide();
				}else if(data["is_audit"] == "3" ){
					audit = '<font color="red">不通过</font>';
					content += '<a href="javascript:;" onclick="do_audit('+id+',2);">通过</a>';
					$("#reason").html(reason);
					$(".no_pass").show();
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