<?
//�û���¼
if(isset($_POST['Submit']) and $_GET['action'] == 'login')
{
	$username = trim($_POST['username']);
	$pwd = trim($_POST['pwd']);
	$chknum = trim($_POST['chknum']);
	
	session_start();
	
	if($username == ''){ echo "<script>alert('�û�������Ϊ�գ��������û�����');history.back();</script>"; exit;}
	if($pwd == ''){ echo "<script>alert('���벻��Ϊ�գ����������룡');history.back();</script>"; exit;}
	if($chknum == ''){ echo "<script>alert('��֤�벻��Ϊ�գ���������֤�룡');history.back();</script>"; exit;
	}else if($chknum <> $_SESSION['chknum']){ echo "<script>alert('��֤�벻��ȷ�����������룡');history.back();</script>"; exit;}
	
	require('libs/config.inc.php');
	
	$rs = mysql_query("select userid,username,flag,kind,pinpaicode,gongchangcode,lastlogindate from user where username='{$username}' and userpass='{$pwd}' and work=1");
	$row = mysql_fetch_array($rs, MYSQL_ASSOC);
	if($row){
		$_SESSION['userid'] = $row['userid'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['flag'] = $row['flag'];
		$_SESSION['kind'] = $row['kind'];
		$_SESSION['lastlogindate'] = $row['lastlogindate'];
		
		$time = time();
		//�����û�������¼ʱ��
		$sql = 'update user set lastlogindate=' . $time . ' where userid=' . $row['userid'];
		mysql_query($sql);
		
		//1Ϊӳŵ2ΪƷ��3Ϊ����
		if($row['kind'] == 1){
			$_SESSION['pinpaicode'] = '';
			$_SESSION['pinpainame'] = '';
			$_SESSION['gongchangcode'] = '';
			$_SESSION['gongchangname'] = '';
			mysql_close($conn);
//			header("location:index.php");
//			exit;
		}else if($row['kind'] == 2){
			//��ѯƷ����
			$rs2 = mysql_query("select pinpainame from pinpai where pinpaicode='" . $row['pinpaicode'] . "'");
			$row2 = mysql_fetch_array($rs2);
			$_SESSION['pinpaicode'] = $row['pinpaicode'];
			$_SESSION['pinpainame'] = $row2['pinpainame'];
			$_SESSION['gongchangcode'] = '';
			$_SESSION['gongchangname'] = '';
			mysql_close($conn);
			//header("location:message.php");
//			exit;
		}else if($row['kind'] == 3){
			//��ѯƷ����
			$rs2 = mysql_query("select pinpainame from pinpai where pinpaicode='" . $row['pinpaicode'] . "'");
			$row2 = mysql_fetch_array($rs2);
			$_SESSION['pinpaicode'] = $row['pinpaicode'];
			$_SESSION['pinpainame'] = $row2['pinpainame'];
			//��ѯ������
			$rs2 = mysql_query("select gongchangname from gongchang where gongchangcode='" . $row['gongchangcode'] . "'");
			$row2 = mysql_fetch_array($rs2);
			$_SESSION['gongchangcode'] = $row['gongchangcode'];
			$_SESSION['gongchangname'] = $row2['gongchangname'];
			mysql_close($conn);
//			header("location:message.php");
//			exit;
		}
		header("location:home.php");
		exit();
	}else{
		mysql_close($conn);
		echo "<script>alert('�û��������벻��ȷ�����������룡');history.back();</script>";
		exit;
	}
}

?>