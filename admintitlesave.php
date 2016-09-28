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
	//添加脚本
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
			echo "<script>alert('添加成功！');location='admintitle.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('添加失败！');history.back();</script>";
			exit;
	   }
	}
	
	//修改脚本
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
			echo "<script>alert('修改成功！');location='admintitle.php?page=$page';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('修改失败！');history.back();</script>";
			exit;
	   }
	}
}
//删除脚本
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
			echo "<script>alert('删除成功！');location='admintitle.php?page=$page';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('没有该脚本记录或者该脚本记录已经被删除！');location='admintitle.php?page=$page';</script>";
		exit;
	}
}
?>