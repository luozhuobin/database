<?
require('libs/config.inc.php');
if($_SESSION['username'] == ''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag'] < 98){
	mysql_close($conn);
	echo '您权限不足，请使用有权限的用户名称进行登录';
	exit;
}

if(isset($_POST['Submit']))
{
	//添加电话
	if(trim($_GET['action'])=='add')
	{
		$city=trim($_POST['city']);
		$institution=trim($_POST['institution']);
		$phone=trim($_POST['phone']);
		$address=trim($_POST['address']);
		
		//验证电话是否存在
		$sql="select count(phoneid) from phone where phone='$phone'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('该电话已经存在！');history.back();</script>";
			exit;
		}

		$sql="insert into phone (city,institution,phone,address) values('$city','$institution','$phone','$address')";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('添加成功！');location='adminphone.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('添加失败！');history.back();</script>";
			exit;
	   }
	}
	
	//修改电话
	if(trim($_GET['action'])=='edit')
	{
		$phoneid=$_GET['phoneid']+0;
		$page = $_GET['page'] + 0;
		 
		$city=trim($_POST['city']);
		$institution=trim($_POST['institution']);
		$phone=trim($_POST['phone']);
		$address=trim($_POST['address']);
		
		//验证电话是否存在
		$sql="select count(phoneid) from phone where phoneid<>$phoneid and phone='$phone'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('该电话已经存在！');history.back();</script>";
			exit;
		}

		$sql="update phone set city='$city',institution='$institution',phone='$phone',address='$address' where phoneid=$phoneid";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('修改成功！');location='adminphone.php?page=$page';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('修改失败！');history.back();</script>";
			exit;
	   }
	}
}
//删除电话
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
			echo "<script>alert('删除成功！');location='adminphone.php?page=$page';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('没有该电话记录或者该电话记录已经被删除！');location='adminphone.php?page=$page';</script>";
		exit;
	}
}
?>
