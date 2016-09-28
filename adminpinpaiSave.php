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
		$pinpainame=trim($_POST['pinpainame']);
		$cityname=$_POST['cityname'];
		$pinpaicode=trim($_POST['pinpaicode']);
		$pinpaidizhi=trim($_POST['pinpaidizhi']);
		$pinpaidianhua=trim($_POST['pinpaidianhua']);
		$lianxiren=trim($_POST['lianxiren']);
		
		//验证品牌名称是否存在
		$sql="select count(pinpai_id) from pinpai where pinpainame='$pinpainame'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('品牌名称已经存在！');history.back();</script>";
			exit;
		}
		 
		//验证品牌编码是否存在
		$sql="select count(pinpai_id) from pinpai where pinpaicode='$pinpaicode'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('品牌编码已经存在！');history.back();</script>";
			exit;
		}	
		
		$sql="insert into pinpai (pinpainame,pinpaicode,pinpaidizhi,pinpaidianhua,lianxiren,cityname) values('$pinpainame','$pinpaicode','$pinpaidizhi','$pinpaidianhua','$lianxiren','$cityname')";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('添加成功！');location='adminpinpai.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('添加失败！');history.back();</script>";
			exit;
	   }
	}
	
	//修改品牌
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
		
		//验证品牌名称是否存在
		$sql="select count(pinpai_id) from pinpai where pinpai_id<>$pinpai_id and pinpainame='$pinpainame'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('品牌名称已经存在！');history.back();</script>";
			exit;
		}
		 
		//验证品牌编码是否存在
		$sql="select count(pinpai_id) from pinpai where pinpai_id<>$pinpai_id and pinpaicode='$pinpaicode'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('品牌编码已经存在！');history.back();</script>";
			exit;
		}	
		
		$sql="update pinpai set pinpainame='$pinpainame',pinpaicode='$pinpaicode',pinpaidizhi='$pinpaidizhi',pinpaidianhua='$pinpaidianhua',lianxiren='$lianxiren',cityname='$cityname' where pinpai_id=$pinpai_id";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('修改成功！');location='adminpinpai.php?page=$page';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('修改失败！');history.back();</script>";
			exit;
	   }
	}
}
//删除品牌
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
			echo "<script>alert('删除成功！');location='adminpinpai.php?page=$page';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('没有该品牌记录或者该品牌记录已经被删除！');location='adminpinpai.php?page=$page';</script>";
		exit;
	}
}
?>