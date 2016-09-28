<?
require('libs/config.inc.php');
if($_SESSION['username']==''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag']<98){
	mysql_close($conn);
	echo '您权限不足，请使用有权限的用户名称进行登录';
	exit;
}

if(isset($_POST['Submit']))
{
	//添加品牌
	if(trim($_GET['action'])=='add')
	{
		$cityname=trim($_POST['cityname']);
		$quhao=trim($_POST['quhao']);
		
		//验证城市是否存在
		$sql="select count(cityid) from city where cityname='$cityname'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('该城市已经存在！');history.back();</script>";
			exit;
		}

		$sql="insert into city (cityname,quhao) values('$cityname','$quhao')";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('添加成功！');location='admincity.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('添加失败！');history.back();</script>";
			exit;
	   }
	}
	
	//修改城市
	if(trim($_GET['action'])=='edit')
	{
		$cityid=$_GET['cityid']+0;
		$page = $_GET['page'] + 0;
		 
		$cityname=trim($_POST['cityname']);
		$quhao=trim($_POST['quhao']);
		
		//验证城市是否存在
		$sql="select count(cityid) from city where cityid<>$cityid and cityname='$cityname'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('该城市已经存在！');history.back();</script>";
			exit;
		}
		
		$sql="update city set cityname='$cityname',quhao='$quhao' where cityid=$cityid";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('修改成功！');location='admincity.php?page=$page';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('修改失败！');history.back();</script>";
			exit;
	   }
	}
}
/*//删除城市
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
			echo "<script>alert('删除成功！');location='admincity.php?page=$page';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('没有该城市记录或者该城市记录已经被删除！');location='admincity.php?page=$page';</script>";
		exit;
	}
}*/
?>