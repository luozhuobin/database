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
	//��ӽű�
	if(trim($_GET['action'])=='add')
	{
		$title = trim($_POST['title']);
		$xianshi = $_POST['xianshi'];
		$leixing = $_POST['leixing'];
		$time = time();

		$sql="insert into title (title,dateandtime,xianshi,leixing) values('$title',$time,$xianshi,$leixing)";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('��ӳɹ���');location='admintitle.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('���ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
	
	//�޸Ľű�
	if(trim($_GET['action'])=='edit')
	{
		$titleid = $_GET['titleid']+0;
		$page = $_GET['page'] + 0;
		 
		$title = trim($_POST['title']);
		$xianshi = $_POST['xianshi'];
		$leixing = $_POST['leixing'];
		$time = time();
		
		$sql="update title set title='$title',dateandtime=$time,xianshi=$xianshi,leixing=$leixing where titleid=$titleid";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('�޸ĳɹ���');location='admintitle.php?page=$page';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('�޸�ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
}
//ɾ���ű�
if($_GET['action']=='del')
{
	$titleid = $_GET['titleid']+0;
	$page = $_GET['page'] + 0;
	
	$sql='select count(titleid) from title where titleid='.$titleid;
	$rs = mysql_query($sql);
	$row = mysql_fetch_row($rs);
	if($row[0] > 0)
	{
		$sql="delete from title where titleid=$titleid";
		if(mysql_query($sql)){ 
			mysql_close($conn);
			echo "<script>alert('ɾ���ɹ���');location='admintitle.php?page=$page';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('û�иýű���¼���߸ýű���¼�Ѿ���ɾ����');location='admintitle.php?page=$page';</script>";
		exit;
	}
}
?>