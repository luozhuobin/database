<?
	require('libs/config.inc.php');
	if($_SESSION['username']==''){
		mysql_close($conn);
		header('location:login.php');
		exit;
	}
	if($_SESSION['flag']<40 or $_SESSION['flag'] == 91){
		mysql_close($conn);
		echo '您权限不足，请使用有权限的用户名称进行登录';
		exit;
	}
	

	$userid = $_SESSION['userid'];
	$username = $_SESSION['username'];
	$kind = $_SESSION['kind'];
	$pinpaicode = $_SESSION['pinpaicode'];
	$gongchangcode = $_SESSION['gongchangcode'];
	$pinpainame = $_SESSION['pinpainame'];
	$gongchangname = $_SESSION['gongchangname'];
	$todo = empty($_GET['todo'])?'from':$_GET['todo'];
	$type = $_GET['type'];
	
?>
<html>
<HEAD>
<TITLE>留言=>留言列表</TITLE>
<META http-equiv=Content-Type content="text/html; charset=GB2312">
<meta name=keywords content="留言=>留言列表">
<link href="<?php echo autoVer('css/style.css');?>" rel="stylesheet" type="text/css" />
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
<td width="146"><div class="title01">留言板 </div></td>
<td width="16"><img src="images/icon11.jpg"  border="0"></td>
<td width="7" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>
<? include('messageleft.php');?>
</td>
<td width="5" valign="middle"><img src="images/btnleft.jpg" width="5" height="117" border="0"></td>
<td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/titlebg.jpg">
<tr>
<td width="5" height="33" align="left"><img src="images/titleleft.jpg" width="5" height="33"></td>
<td width="10"><img src="images/icon10.jpg" width="3" height="15"></td>
<td><div class="title01">留言列表</div></td>
<td width="28"><img src="images/icon12.jpg"  border="0"></td>
<td width="5" align="right"><img src="images/titleright.jpg" width="5" height="33"></td>
</tr>
</table>



<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rightcon">
<tr>
<td height="565" align="left" valign="top">



<table border="0" cellspacing="0" cellpadding="0" align="center">
<tr height="10"><td></td></tr>
<tr>
	<td><a href="addmessage.php"><img src="images/btnnew.jpg" width="70" height="24" alt="新增" title="新增留言"></a></td>
</tr>
<tr height="10"><td></td></tr>
<tr>
<td align="left">

<input type="hidden" name="param" id="param" value="<? echo $param;?>">
<table width="1000" align="center" border="1" bordercolor="#dedfe0"  cellpadding="0" cellspacing="0" class="datatable">
  <tr height="30" align="left" >
   <td class="b1 titsty">&nbsp;ID</td>
   <td class="b1 titsty" width="400">&nbsp;留言标题</td>
   <td class="b1 titsty">&nbsp;<?php echo $_GET["todo"]=='from'?'发件人':'收件人';?></td>
   <td class="b1 titsty">&nbsp;类型</td>
   <td class="b1 titsty" title="回复数/未读回复数">&nbsp;回复数</td>
   <td class="b1 titsty">&nbsp;是否解决</td>
   <td class="b1 titsty" width="180">&nbsp;时间</td>
   <td class="b1 titsty">&nbsp;附件</td>
  </tr>
  <?php 
  $arr = array("from"=>array("to_id","is_read"),"send"=>array("from_id","is_solve"));
  $condition = " WHERE `{$arr[$todo][0]}` = {$userid}";
  if(!empty($type)){
  	$condition .= " AND `{$arr[$todo][1]}` = '{$type}'";
  }
  $page = intval($_GET['page'])>0?intval($_GET['page']):1;
  $orderby = " ORDER BY m.createtime DESC ";
  $groupby = " GROUP BY content_id ";
  $total_sql = "SELECT count(*) AS count FROM (SELECT m.id FROM message_map AS m LEFT JOIN message_content AS c ON m.content_id = c.id LEFT JOIN user AS u ON m.from_id = u.userid {$condition} GROUP BY content_id ) T";
  $sql = "SELECT m.*,c.*,u.username FROM message_map AS m LEFT JOIN message_content AS c ON m.content_id = c.id LEFT JOIN user AS u ON m.from_id = u.userid ";
  $stat = mysql_fetch_assoc(mysql_query($total_sql));
  $pagesize = 15;
  $page = $page>ceil(intval($stat['count'])/$pagesize)?ceil(intval($stat["count"]/$pagesize)):$page;
  $offset = ($page-1)*$pagesize;
  $limit = " LIMIT {$offset},{$pagesize}";
  $sql .= $condition.$groupby.$orderby.$limit;
  $query = mysql_query($sql);
  $j = 1;
  while($row = mysql_fetch_assoc($query)){
  	##收件或者发件人
  	$uname = array();
  	$witch = $_GET["todo"]=='send'?'to_id':'from_id';
  	$sql = "SELECT u.username FROM `message_map` AS m INNER JOIN user AS u ON m.{$witch} = u.userid WHERE content_id = '{$row["id"]}'";
  	$q = mysql_query($sql);
  	while($r = mysql_fetch_assoc($q)){
  		$uname[] = $r["username"];
  	}
  	$uname = array_unique($uname);
  	##回复数
  	$reply = mysql_fetch_assoc(mysql_query("SELECT count(*) AS count FROM message_map WHERE parent_id = '{$row["id"]}'"));
  	##是否已读
  	$is_read = mysql_fetch_assoc(mysql_query("SELECT is_read FROM message_map WHERE content_id = '{$row["id"]}' AND to_id = '{$userid}'"));
  	if(!empty($is_read)){
  		$font_weight = $is_read["is_read"]=='Y'?'':'style="font-weight:bold;"';
  	}else{
  		$font_weight = '';
  	}
  	$type = $row["parent_id"]==0?'留言':'回复';
  	$date = date("Y-m-d H:i:s",$row["createtime"]);
  	$id = $row["parent_id"] == 0?$row["id"]:$row["parent_id"];
  	$is_solve = $row["is_solve"]=='Y'?'<font color="green">是</font>':'<font color="red">否</font>';
  	$attachment = empty($row["attachment"])?'':'<a href="/model/'.$row["attachment"].'" target="_blank"><img src="images/addi.jpg" alt="附件表" title="附件表"></a>';
  	if($j%2==0){ $color='#eeeeee';}else{ $color='#fafafa';}
	$j++;
  	echo '<tr height="30" align="left" >
   			<td bgcolor="'.$color.'">&nbsp;'.$row["id"].'</td>
   			<td bgcolor="'.$color.'" width="400" '.$font_weight.'>&nbsp;<a href="/messageShow.php?id='.$id.'">'.$row["title"].'</a></td>
   			<td bgcolor="'.$color.'">&nbsp;'.implode(",",$uname).'</td>
   			<td bgcolor="'.$color.'">&nbsp;'.$type.'</td>
   			<td bgcolor="'.$color.'" title="回复数/未读回复数">&nbsp;'.intval($reply["count"]).'</td>
   			<td bgcolor="'.$color.'">&nbsp;'.$is_solve.'</td>
   			<td bgcolor="'.$color.'" width="180">&nbsp;'.$date.'</td>
   			<td bgcolor="'.$color.'">&nbsp;'.$attachment.'</td>
  		</tr>';
  }
  if($j%2==0){ $color='#eeeeee';}else{ $color='#fafafa';}
  $SubPages = new SubPages($pagesize,$stat['count'],$page,10,'/message.php?todo='.$_GET['todo'].'&type='.$_GET['type'].'&page=',2);
  $subPageCss2 = $SubPages->subPageCss2();
  echo '<tr height="30" align="left"><td colspan="8" bgcolor="'.$color.'" class="pageCont"><a href="javascript:;">共'.$stat["count"]."条数据</a>".$subPageCss2.'</td></tr>';
  ?>
</table>

</td>
<td></td>
</tr>
</table>

</td>
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
<td><? include('foot.php');?></td>
</tr>
</table>
</body>
</html>