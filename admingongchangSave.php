<?
require('libs/config.inc.php');
if($_SESSION['username']==''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag']<95){
	mysql_close($conn);
	echo '您权限不足，请使用有权限的用户名称进行登录';
	exit;
}

if(isset($_POST['Submit']))
{
	//添加工厂
	if(trim($_GET['action'])=='add')
	{
		$gongchangname=trim($_POST['gongchangname']);
		$cityname=$_POST['cityname'];
		$gongchangcode=trim($_POST['gongchangcode']);
		$gongchangdizhi=trim($_POST['gongchangdizhi']);
		$pinpai_id=$_POST['pinpai_id'];
		$gongchangchanpin=trim($_POST['gongchangchanpin']);
		$gongchangdianhua=trim($_POST['gongchangdianhua']);
		$lianxiren=trim($_POST['lianxiren']);
		$gongchangrenshu=trim($_POST['gongchangrenshu']) == '' ? 0 : trim($_POST['gongchangrenshu']);
		
		//验证工厂名称是否存在
		$sql="select count(gongchangid) from gongchang where gongchangname='$gongchangname'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('工厂名称已经存在！');history.back();</script>";
			exit;
		}
		
		//验证工厂编码是否存在
		$sql="select count(gongchangid) from gongchang where gongchangcode='$gongchangcode'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('工厂编码已经存在！');history.back();</script>";
			exit;
		}
		
		//验证品牌是否存在
		$sql='select pinpai_id,pinpainame,pinpaicode from pinpai where pinpai_id='.$pinpai_id;
		$rs = mysql_query($sql);
		$row = mysql_fetch_array($rs);
		if(!$row)
		{
			mysql_close($conn);
			echo "<script>alert('品牌不存在！');history.back();</script>";
			exit;
		}
		$pinpainame = $row['pinpainame'];
		$gongchangpinpai = $row['pinpaicode'];
		
		$sql="insert into gongchang (gongchangname,gongchangcode,gongchangdizhi,gongchangdianhua,lianxiren,cityname,pinpai_id,pinpainame,gongchangpinpai,gongchangchanpin,gongchangrenshu) values('$gongchangname','$gongchangcode','$gongchangdizhi','$gongchangdianhua','$lianxiren','$cityname',$pinpai_id,'$pinpainame','$gongchangpinpai','$gongchangchanpin','$gongchangrenshu')";
		//echo $sql;
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('添加成功！');location='admingongchang.php';</script>";
			exit;
		}
	   else
	   {
			mysql_close($conn);
			echo "<script>alert('添加失败！');history.back();</script>";
			exit;
	   }
	}
	
	//修改工厂
	if(trim($_GET['action'])=='edit')
	{
		$gongchangid=$_GET['gongchangid']+0;
		$page = $_GET['page'] + 0;
		 
		$gongchangname=trim($_POST['gongchangname']);
		$cityname=$_POST['cityname'];
		$gongchangcode=trim($_POST['gongchangcode']);
		$gongchangdizhi=trim($_POST['gongchangdizhi']);
		$pinpai_id=$_POST['pinpai_id'];
		$gongchangchanpin=trim($_POST['gongchangchanpin']);
		$gongchangdianhua=trim($_POST['gongchangdianhua']);
		$lianxiren=trim($_POST['lianxiren']);
		$gongchangrenshu=trim($_POST['gongchangrenshu']) == '' ? 0 : trim($_POST['gongchangrenshu']);
			 
		//验证品牌是否存在
		$sql='select pinpai_id,pinpainame,pinpaicode from pinpai where pinpai_id='.$pinpai_id;
		$rs = mysql_query($sql);
		$row = mysql_fetch_array($rs);
		if(!$row)
		{
			mysql_close($conn);
			echo "<script>alert('品牌不存在！');history.back();</script>";
			exit;
		}
		$pinpainame=$row['pinpainame'];
		$gongchangpinpai=$row['pinpaicode'];

		$sql="update gongchang set gongchangname='$gongchangname',gongchangcode='$gongchangcode',gongchangdizhi='$gongchangdizhi',gongchangdianhua='$gongchangdianhua',lianxiren='$lianxiren',cityname='$cityname',pinpai_id=$pinpai_id,pinpainame='$pinpainame',gongchangpinpai='$gongchangpinpai',gongchangchanpin='$gongchangchanpin',gongchangrenshu='$gongchangrenshu' where gongchangid=$gongchangid";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('修改成功！');location='admingongchang.php?page=$page';</script>";
			exit;
		}
	   else
	   {
			mysql_close($conn);
			echo "<script>alert('修改失败！');history.back();</script>";
			exit;
	   }
	}
}

//删除工厂
if($_GET['action']=='del')
{
	$gongchangid=$_GET['gongchangid']+0;
	$page = $_GET['page'] + 0;
	
	$sql='select count(gongchangid) from gongchang where gongchangid='.$gongchangid;
	$rs = mysql_query($sql);
	$row = mysql_fetch_row($rs);
	if($row[0] > 0)
	{
		$sql="delete from gongchang where gongchangid=$gongchangid";
		if(mysql_query($sql)){
			mysql_close($conn);
			echo "<script>alert('删除成功！');location='admingongchang.php?page=$page';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('没有该工厂记录或者该工厂记录已经被删除！');location='admingongchang.php?page=$page';</script>";
		exit;
	}
}

?>