<?
require('libs/config.inc.php');
if($_SESSION['username'] == ''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag'] < 98){
	mysql_close($conn);
	echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
	exit;
}

if(isset($_POST['Submit']))
{
	//��ӵ绰
	if(trim($_GET['action'])=='add')
	{
		$city=trim($_POST['city']);
		$institution=trim($_POST['institution']);
		$phone=trim($_POST['phone']);
		$address=trim($_POST['address']);
		
		//��֤�绰�Ƿ����
		$sql="select count(phoneid) from phone where phone='$phone'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('�õ绰�Ѿ����ڣ�');history.back();</script>";
			exit;
		}

		$sql="insert into phone (city,institution,phone,address) values('$city','$institution','$phone','$address')";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('��ӳɹ���');location='adminphone.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('���ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
	
	//�޸ĵ绰
	if(trim($_GET['action'])=='edit')
	{
		$phoneid=$_GET['phoneid']+0;
		$page = $_GET['page'] + 0;
		 
		$city=trim($_POST['city']);
		$institution=trim($_POST['institution']);
		$phone=trim($_POST['phone']);
		$address=trim($_POST['address']);
		
		//��֤�绰�Ƿ����
		$sql="select count(phoneid) from phone where phoneid<>$phoneid and phone='$phone'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('�õ绰�Ѿ����ڣ�');history.back();</script>";
			exit;
		}

		$sql="update phone set city='$city',institution='$institution',phone='$phone',address='$address' where phoneid=$phoneid";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('�޸ĳɹ���');location='adminphone.php?page=$page';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('�޸�ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
}
//ɾ���绰
if($_GET['action']=='del')
{
	$phoneid=$_GET['phoneid']+0;
	$page = $_GET['page'] + 0;
	
	$sql='select count(phoneid) from phone where phoneid='.$phoneid;
	$rs = mysql_query($sql);
	$row = mysql_fetch_row($rs);
	if($row[0] > 0)
	{
		$sql="delete from phone where phoneid=$phoneid";
		if(mysql_query($sql)){
			mysql_close($conn);
			echo "<script>alert('ɾ���ɹ���');location='adminphone.php?page=$page';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('û�иõ绰��¼���߸õ绰��¼�Ѿ���ɾ����');location='adminphone.php?page=$page';</script>";
		exit;
	}
}
?>
