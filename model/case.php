<?php
require('../libs/config.inc.php');
if($_SESSION['username']==''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag']<91){
	mysql_close($conn);
	echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
	exit;
}
switch($_GET['action']){
	case 'import':
		$uploaddir = 'import/';		//�����ļ�����Ŀ¼ 
		if(!file_exists($uploaddir)) mkdir($uploaddir);   	//����������ļ�Ŀ¼�����Զ�������Ŀ¼
		$uploaddir .= date('Ym').'/';		//�����ļ�����Ŀ¼ 
		if(!file_exists($uploaddir)) mkdir($uploaddir);   	//����������ļ�Ŀ¼�����Զ�������Ŀ¼
		$typeArr=array('xls','xlsx');	//���������ϴ��ļ�������
		//��ȡ�ϴ��ļ���׺������
		$fileinfo = pathinfo($_FILES['file']['name']);
        if(!in_array($fileinfo['extension'],array('xls'))){
        	echo "<script>alert('���ϴ����ļ����Ͳ�����Ҫ��');location='/case_import.php';</script>";
			exit;
        } 
		$filesize=$_FILES['file']['size']/1024;		//�ļ���С
		$filesize=round($filesize,2);
		$rand=mt_rand(1000,9999);	//������λ�����
		$t=date('YmdHis');
		$thename=$userid.'_'.$t.'_'.$rand.'.'.$fileinfo['extension'];
		$uploadfile=$uploaddir.$thename;	//�ϴ�����ļ�����·��

		if(is_uploaded_file($_FILES['file']['tmp_name']))		//�ж��Ƿ�ͨ��HTTP POST�ϴ�
		{ 
			//�ϴ����ƶ��ļ�
			if(!move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile)){
				mysql_close($conn);
				echo "<script>alert('�ϴ�ʧ��');location='/case_import.php';</script>";
				exit;
			}
	   	}
	   	$data = new Spreadsheet_Excel_Reader();
	   	$data->setOutputEncoding('GBK');
	   	$data->read($uploadfile);
		##ȥ��ͷ�� ������
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
		echo "<script>alert('����ɹ�');location='/case_import.php';</script>";
		exit;
		break;
	case 'do_audit':
		$id = intval($_GET['id']);
		$is_audit = intval($_GET['is_audit']);
		$reason = htmlspecialchars(urldecode($_GET['reason']));
		if($_SESSION['flag']<95){
			echo json_encode(array("result"=>"-1","msg"=>"Ȩ�޲���"));
			exit();
		}
		if(empty($id)){
			echo json_encode(array("result"=>"-2","msg"=>"����id����Ϊ��"));
			exit();
		}
		if(empty($is_audit)){
			echo json_encode(array("result"=>"-3","msg"=>"���״̬����Ϊ��"));
			exit();
		}
		$reason = iconv("UTF-8","GBK",$reason);
		$sql = "UPDATE case_table SET is_audit = {$is_audit},reason = '{$reason}',admin_id = '{$_SESSION['userid']}',audit_time = unix_timestamp(now()) WHERE caseid = {$id}";
		$query = mysql_query($sql);
		if($query){
			echo json_encode(array("result"=>"1","msg"=>"�����ɹ�","is_audit"=>$is_audit,"reason"=>$reason));
			exit();
		}else{
			echo json_encode(array("result"=>"-4","msg"=>"����ʧ��"));
			exit();
		}
		break;
}
?>