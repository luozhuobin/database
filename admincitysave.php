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
		$cityname=trim($_POST['cityname']);
		$quhao=trim($_POST['quhao']);
		
		//��֤�����Ƿ����
		$sql="select count(cityid) from city where cityname='$cityname'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('�ó����Ѿ����ڣ�');history.back();</script>";
			exit;
		}

		$sql="insert into city (cityname,quhao) values('$cityname','$quhao')";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('��ӳɹ���');location='admincity.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('���ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
	
	//�޸ĳ���
	if(trim($_GET['action'])=='edit')
	{
		$cityid=$_GET['cityid']+0;
		$page = $_GET['page'] + 0;
		 
		$cityname=trim($_POST['cityname']);
		$quhao=trim($_POST['quhao']);
		
		//��֤�����Ƿ����
		$sql="select count(cityid) from city where cityid<>$cityid and cityname='$cityname'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('�ó����Ѿ����ڣ�');history.back();</script>";
			exit;
		}
		
		$sql="update city set cityname='$cityname',quhao='$quhao' where cityid=$cityid";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('�޸ĳɹ���');location='admincity.php?page=$page';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('�޸�ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
}
/*//ɾ������
if($_GET['action']=='del')
{
	$cityid=$_GET['cityid']+0;
	$page = $_GET['page'] + 0;
	
	$sql='select count(cityid) from city where cityid='.$cityid;
	$rs = mysql_query($sql);
	$row = mysql_fetch_row($rs);
	if($row[0] > 0)
	{
		$sql="delete from city where cityid=$cityid";
		if(mysql_query($sql)){
			mysql_close($conn);
			echo "<script>alert('ɾ���ɹ���');location='admincity.php?page=$page';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('û�иó��м�¼���߸ó��м�¼�Ѿ���ɾ����');location='admincity.php?page=$page';</script>";
		exit;
	}
}*/
?>