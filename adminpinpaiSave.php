<?
require('libs/config.inc.php');
if($_SESSION['username']==''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag']<98){
	mysql_close($conn);
	echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
	exit;
}

if(isset($_POST['Submit']))
{
	//���Ʒ��
	if(trim($_GET['action'])=='add')
	{
		$pinpainame=trim($_POST['pinpainame']);
		$cityname=$_POST['cityname'];
		$pinpaicode=trim($_POST['pinpaicode']);
		$pinpaidizhi=trim($_POST['pinpaidizhi']);
		$pinpaidianhua=trim($_POST['pinpaidianhua']);
		$lianxiren=trim($_POST['lianxiren']);
		
		//��֤Ʒ�������Ƿ����
		$sql="select count(pinpai_id) from pinpai where pinpainame='$pinpainame'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('Ʒ�������Ѿ����ڣ�');history.back();</script>";
			exit;
		}
		 
		//��֤Ʒ�Ʊ����Ƿ����
		$sql="select count(pinpai_id) from pinpai where pinpaicode='$pinpaicode'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('Ʒ�Ʊ����Ѿ����ڣ�');history.back();</script>";
			exit;
		}	
		
		$sql="insert into pinpai (pinpainame,pinpaicode,pinpaidizhi,pinpaidianhua,lianxiren,cityname) values('$pinpainame','$pinpaicode','$pinpaidizhi','$pinpaidianhua','$lianxiren','$cityname')";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('��ӳɹ���');location='adminpinpai.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('���ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
	
	//�޸�Ʒ��
	if(trim($_GET['action'])=='edit')
	{
		$pinpai_id=$_GET['pinpai_id']+0;
		$page = $_GET['page'] + 0;
		 
		$pinpainame=trim($_POST['pinpainame']);
		$cityname=$_POST['cityname'];
		$pinpaicode=trim($_POST['pinpaicode']);
		$pinpaidizhi=trim($_POST['pinpaidizhi']);
		$pinpaidianhua=trim($_POST['pinpaidianhua']);
		$lianxiren=trim($_POST['lianxiren']);
		
		//��֤Ʒ�������Ƿ����
		$sql="select count(pinpai_id) from pinpai where pinpai_id<>$pinpai_id and pinpainame='$pinpainame'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('Ʒ�������Ѿ����ڣ�');history.back();</script>";
			exit;
		}
		 
		//��֤Ʒ�Ʊ����Ƿ����
		$sql="select count(pinpai_id) from pinpai where pinpai_id<>$pinpai_id and pinpaicode='$pinpaicode'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('Ʒ�Ʊ����Ѿ����ڣ�');history.back();</script>";
			exit;
		}	
		
		$sql="update pinpai set pinpainame='$pinpainame',pinpaicode='$pinpaicode',pinpaidizhi='$pinpaidizhi',pinpaidianhua='$pinpaidianhua',lianxiren='$lianxiren',cityname='$cityname' where pinpai_id=$pinpai_id";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('�޸ĳɹ���');location='adminpinpai.php?page=$page';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('�޸�ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
}
//ɾ��Ʒ��
if($_GET['action']=='del')
{
	$pinpai_id=$_GET['pinpai_id']+0;
	$page = $_GET['page'] + 0;
	
	$sql='select count(pinpai_id) from pinpai where pinpai_id='.$pinpai_id;
	$rs = mysql_query($sql);
	$row = mysql_fetch_row($rs);
	if($row[0] > 0)
	{
		$sql="delete from pinpai where pinpai_id=$pinpai_id";
		if(mysql_query($sql)){
			mysql_close($conn);
			echo "<script>alert('ɾ���ɹ���');location='adminpinpai.php?page=$page';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('û�и�Ʒ�Ƽ�¼���߸�Ʒ�Ƽ�¼�Ѿ���ɾ����');location='adminpinpai.php?page=$page';</script>";
		exit;
	}
}
?>