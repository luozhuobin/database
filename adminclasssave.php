<?
require('libs/config.inc.php');
if($_SESSION['username'] == ''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag'] < 5){
	mysql_close($conn);
	echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
	exit;
}

if(isset($_POST['Submit']))
{
	//����������
	if(trim($_GET['action'])=='add')
	{
		$classname=trim($_POST['classname']);
		
		//��֤��������Ƿ����
		$sql="select count(classid) from class where classname='$classname'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('����������Ѿ����ڣ�');history.back();</script>";
			exit;
		}

		$sql="insert into class (classname) values('$classname')";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('��ӳɹ���');location='adminclass.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('���ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
	
	//�޸��������
	if(trim($_GET['action'])=='edit')
	{
		$page = $_GET['page'] + 0;
		$classid=$_GET['classid']+0; 
		$classname=trim($_POST['classname']);
		
		//��֤��������Ƿ����
		$sql="select count(classid) from class where classid<>$classid and classname='$classname'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('����������Ѿ����ڣ�');history.back();</script>";
			exit;
		}
		
		$sql="update class set classname='$classname' where classid=$classid";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('�޸ĳɹ���');location='adminclass.php?page=$page';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('�޸�ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
}
?>