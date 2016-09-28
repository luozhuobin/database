<?php
require('../libs/config.inc.php');
if($_SESSION['username']==''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag']<91){
	mysql_close($conn);
	echo '您权限不足，请使用有权限的用户名称进行登录';
	exit;
}
switch($_GET['action']){
	case 'import':
		$uploaddir = 'import/';		//设置文件保存目录 
		if(!file_exists($uploaddir)) mkdir($uploaddir);   	//如果不存在文件目录，就自动创建该目录
		$uploaddir .= date('Ym').'/';		//设置文件保存目录 
		if(!file_exists($uploaddir)) mkdir($uploaddir);   	//如果不存在文件目录，就自动创建该目录
		$typeArr=array('xls','xlsx');	//设置允许上传文件的类型
		//获取上传文件后缀名函数
		$fileinfo = pathinfo($_FILES['file']['name']);
        if(!in_array($fileinfo['extension'],array('xls'))){
        	echo "<script>alert('您上传的文件类型不符合要求！');location='/case_import.php';</script>";
			exit;
        } 
		$filesize=$_FILES['file']['size']/1024;		//文件大小
		$filesize=round($filesize,2);
		$rand=mt_rand(1000,9999);	//生成四位随机数
		$t=date('YmdHis');
		$thename=$userid.'_'.$t.'_'.$rand.'.'.$fileinfo['extension'];
		$uploadfile=$uploaddir.$thename;	//上传后的文件完整路径

		if(is_uploaded_file($_FILES['file']['tmp_name']))		//判断是否通过HTTP POST上传
		{ 
			//上传并移动文件
			if(!move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile)){
				mysql_close($conn);
				echo "<script>alert('上传失败');location='/case_import.php';</script>";
				exit;
			}
	   	}
	   	$data = new Spreadsheet_Excel_Reader();
	   	$data->setOutputEncoding('GBK');
	   	$data->read($uploadfile);
		##去掉头部 中文字
		array_shift($data->sheets[0]["cells"]);
		$result = array_merge($data->sheets[0]["cells"][1],$data->sheets[0]["cells"][3]);
		//foreach($data->sheets[0]["cells"] as $key=>$value){
			$brand = mysql_fetch_assoc(mysql_query("SELECT * FROM pinpai WHERE pinpaicode = '{$result[3]}'"));
			$factory = mysql_fetch_assoc(mysql_query("SELECT * FROM `gongchang` WHERE `gongchangcode` = '{$result[4]}'"));
			$result[1] = str_ireplace("/",'-',$result[1]);
			$sql = "INSERT INTO case_table SET 
				`case_code` = '{$result[0]}',
				`dateandtime` = '".strtotime($result[1])."',
				`shijianleixing` = '{$result[2]}',
				`pinpainame` = '{$brand["pinpainame"]}',
				`pinpaicode` = '{$result[3]}',
				`gongchangname` = '{$factory["gongchangname"]}',
				`gongchangcode` = '{$result[4]}',
				`xingbie` = '{$result[5]}',
				`experience` = '{$result[6]}',
				`nianling` = '{$result[7]}',
				`bumen` = '{$result[8]}',
				`xianzhuang` = '{$result[9]}',
				`question_type` = '{$result[10]}',
				`miaoshu` = '{$result[11]}',
				`solve_method` = '{$result[12]}',
				`reply` = '{$result[13]}' ,
				`respond` = '{$result[14]}',
				`add_date` = '".time()."',
				`add_userid` = '{$userid}'
				";
			$q = mysql_query($sql);
		//}
		echo "<script>alert('导入成功');location='/case_import.php';</script>";
		exit;
		break;
	case 'do_audit':
		$id = intval($_GET['id']);
		$is_audit = intval($_GET['is_audit']);
		$reason = htmlspecialchars(urldecode($_GET['reason']));
		if($_SESSION['flag']<95){
			echo json_encode(array("result"=>"-1","msg"=>"权限不足"));
			exit();
		}
		if(empty($id)){
			echo json_encode(array("result"=>"-2","msg"=>"个案id不能为空"));
			exit();
		}
		if(empty($is_audit)){
			echo json_encode(array("result"=>"-3","msg"=>"审核状态不能为空"));
			exit();
		}
		$reason = iconv("UTF-8","GBK",$reason);
		$sql = "UPDATE case_table SET is_audit = {$is_audit},reason = '{$reason}',admin_id = '{$_SESSION['userid']}',audit_time = unix_timestamp(now()) WHERE caseid = {$id}";
		$query = mysql_query($sql);
		if($query){
			echo json_encode(array("result"=>"1","msg"=>"操作成功","is_audit"=>$is_audit,"reason"=>$reason));
			exit();
		}else{
			echo json_encode(array("result"=>"-4","msg"=>"操作失败"));
			exit();
		}
		break;
}
?>