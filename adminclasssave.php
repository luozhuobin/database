<?
require('libs/config.inc.php');
if($_SESSION['username'] == ''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag'] < 5){
	mysql_close($conn);
	echo '您权限不足，请使用有权限的用户名称进行登录';
	exit;
}

if(isset($_POST['Submit']))
{
	//添加问题分类
	if(trim($_GET['action'])=='add')
	{
		$classname=trim($_POST['classname']);
		
		//验证问题分类是否存在
		$sql="select count(classid) from class where classname='$classname'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('该问题分类已经存在！');history.back();</script>";
			exit;
		}

		$sql="insert into class (classname) values('$classname')";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('添加成功！');location='adminclass.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('添加失败！');history.back();</script>";
			exit;
	   }
	}
	
	//修改问题分类
	if(trim($_GET['action'])=='edit')
	{
		$page = $_GET['page'] + 0;
		$classid=$_GET['classid']+0; 
		$classname=trim($_POST['classname']);
		
		//验证问题分类是否存在
		$sql="select count(classid) from class where classid<>$classid and classname='$classname'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('该问题分类已经存在！');history.back();</script>";
			exit;
		}
		
		$sql="update class set classname='$classname' where classid=$classid";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('修改成功！');location='adminclass.php?page=$page';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('修改失败！');history.back();</script>";
			exit;
	   }
	}
}
?>