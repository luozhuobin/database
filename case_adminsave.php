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
	echo '您权限不足，请使用有权限的用户名称进行登录';
	exit;
}

if(isset($_POST['Submit']))
{
	//添加个案
	if(trim($_GET['action']) == 'add')
	{
		$case_code = trim($_POST['case_code']);
		$dateandtime = trim($_POST['dateandtime']);
		$dateandtime = strtotime($dateandtime);
		$shijianleixing = $_POST['shijianleixing'];
		$pinpaicode = $_POST['pinpaicode'];
		$gongchangcode = $_POST['gongchangcode'];
		$xingbie = $_POST['xingbie'];
		$nianling = trim($_POST['nianling']);
		$bumen = trim($_POST['bumen']);
		$xianzhuang = $_POST['xianzhuang'];
		$miaoshu = trim($_POST['miaoshu']);
		$goutong = trim($_POST['goutong']);
		$jieguo = $_POST['jieguo'];
		if($jieguo == 1){ $jjueshijian = strtotime(trim($_POST['jjueshijian']));}else{ $jjueshijian = 0;}
		$beizhu = trim($_POST['beizhu']);
		$add_userid = $_SESSION['userid'];
		$question_type = trim($_POST['question_type']);
		$experience = trim($_POST['experience']);
		$solve_method = trim($_POST['solve_method']);
		$reply = trim($_POST['reply']);
		$respond = trim($_POST['respond']);
		$time = time();
		
		//读取品牌名
		$rs = mysql_query("select pinpainame from pinpai where pinpaicode='$pinpaicode'");
		$row = mysql_fetch_row($rs);
		$pinpainame = $row[0];
		//读取工厂名
		$rs = mysql_query("select gongchangname from gongchang where gongchangcode='$gongchangcode'");
		$row = mysql_fetch_row($rs);
		$gongchangname = $row[0];
	
		$sql = "INSERT INTO case_table(
					`caseid`,
					`case_code`,
					`dateandtime`,
					`shijianleixing`,
					`pinpainame`,
					`pinpaicode`,
					`gongchangname`,
					`gongchangcode`,
					`xianzhuang`,
					`bumen`,
					`miaoshu`,
					`jieguo`,
					`xingbie`,
					`nianling`,
					`jjueshijian`,
					`beizhu`,
					`add_date`,
					`add_userid`,
					`experience`,
					`question_type`,
					`solve_method`,
					`reply`,
					`respond`
					) 
				VALUES(
					null,
					'{$case_code}',
					'{$dateandtime}',
					'{$shijianleixing}',
					'{$pinpainame}',
					'{$pinpaicode}',
					'{$gongchangname}',
					'{$gongchangcode}',
					'{$xianzhuang}',
					'{$bumen}',
					'{$miaoshu}',
					'{$jieguo}',
					'{$xingbie}',
					'{$nianling}',
					'{$jjueshijian}',
					'{$beizhu}',
					'".time()."',
					'{$add_userid}',
					'{$experience}',
					'{$question_type}',
					'{$solve_method}',
					'{$reply}',
					'{$respond}'
					)";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('添加成功！');location='case_search.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('添加失败！');history.back();</script>";
			exit;
	   }
	}

	//修改个案
	if(trim($_GET['action']) == 'edit')
	{
		if($_SESSION['flag'] < 95)
		{
			mysql_close($conn);
			echo '您权限不足，请使用有权限的用户名称进行登录';
			exit;
		}
		$caseid = $_GET['caseid']+0;
		
		$case_code = trim($_POST['case_code']);
		$dateandtime = trim($_POST['dateandtime']);
		$dateandtime = strtotime($dateandtime);
		$shijianleixing = $_POST['shijianleixing'];
		$class_1 = trim($_POST['class_1']);
		$class_2 = trim($_POST['class_2']);
		$class_3 = trim($_POST['class_3']);
		$pinpaicode = $_POST['pinpaicode'];
		$gongchangcode = $_POST['gongchangcode'];
		$xingbie = $_POST['xingbie'];
		$nianling = trim($_POST['nianling']);
		$bumen = trim($_POST['bumen']);
		$xianzhuang = $_POST['xianzhuang'];
		$miaoshu = trim($_POST['miaoshu']);
		$goutong = trim($_POST['goutong']);
		$jieguo = $_POST['jieguo'];
		if($jieguo == 1){ $jjueshijian = strtotime(trim($_POST['jjueshijian']));}else{ $jjueshijian = 0;}
		$beizhu = trim($_POST['beizhu']);
		$question_type = trim($_POST['question_type']);
		$experience = trim($_POST['experience']);
		$solve_method = trim($_POST['solve_method']);
		$reply = trim($_POST['reply']);
		$respond = trim($_POST['respond']);
		$time = time();
		$edit_userid = $_SESSION['userid'];
		
		//读取品牌名
		$rs = mysql_query("select pinpainame from pinpai where pinpaicode='$pinpaicode'");
		$row = mysql_fetch_row($rs);
		$pinpainame = $row[0];
		//读取工厂名
		$rs = mysql_query("select gongchangname from gongchang where gongchangcode='$gongchangcode'");
		$row = mysql_fetch_row($rs);
		$gongchangname = $row[0];
		
		$sql="update case_table set case_code='$case_code',dateandtime='$dateandtime',shijianleixing='{$shijianleixing}',"
			."pinpainame='$pinpainame',pinpaicode='$pinpaicode',gongchangname='$gongchangname',gongchangcode='$gongchangcode',"
			."xingbie='{$xingbie}',nianling='$nianling',experience = '{$experience}',bumen='$bumen',xianzhuang='{$xianzhuang}',miaoshu='$miaoshu',solve_method='$solve_method',"
			."reply = '{$reply}',respond = '{$respond}' ,jieguo='{$jieguo}',jjueshijian='$jjueshijian',beizhu='$beizhu',edit_userid=$edit_userid where caseid=$caseid";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('修改成功！');location='case_search.php';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('修改失败！');history.back();</script>";
			exit;
	   }
	}
}

//删除个案
if($_GET['action']=='del')
{
	if($_SESSION['flag'] <= 91)
	{
		mysql_close($conn);
		echo '您权限不足，请使用有权限的用户名称进行登录';
		exit;
	}
	$status = intval($_GET['status'])>0?intval($_GET['status']):2;
	$caseid = $_GET['caseid'] + 0;
	//$page = $_GET['page'] + 0;
	
	$sql='select count(caseid) from case_table where caseid='.$caseid;
	$rs = mysql_query($sql);
	$row = mysql_fetch_row($rs);
	if($row[0] > 0)
	{
		$msg = "删除成功";
		$url = "case_search.php";
		if($status == 3){
			$sql="delete from case_table where caseid=$caseid";
		}else{
			$sql="update case_table set status = {$status},del_time = unix_timestamp(now()) where caseid=$caseid";
			if($status == 1){
				$msg = "还原成功";
				$url = "case_recycle.php";
			}
		}
		if(mysql_query($sql)){
			mysql_close($conn);
			echo "<script>alert('{$msg}！');location='{$url}';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('没有该记录或者该用户已经被删除！');location='case_search.php';</script>";
		exit;
	}
}

//ajax显示对应品牌下的工厂
if($_GET['action'] == 'show')
{
	header('Content-Type: text/xml;charset=gb2312');
	$pingpaicode = $_GET['value'];
	
	echo '<select name="gongchangcode">';
	echo '<option value="0">请选择</option>';
	if($pingpaicode <> '')
	{
		$rs = mysql_query("select gongchangcode from gongchang where gongchangpinpai='$pingpaicode' order by gongchangid asc");
		while($row = mysql_fetch_array($rs, MYSQL_ASSOC))
		{
			echo '<option value="' . $row['gongchangcode'] . '">' . $row['gongchangcode'] . '</option>';
		}mysql_free_result($rs);
	}
	echo '</select>';
	mysql_close($conn);
	exit;
}

?>


