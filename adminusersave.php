<?
require('libs/config.inc.php');
if($_SESSION['username'] == '')
{
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag'] < 98)
{
	mysql_close($conn);
	echo '您权限不足，请使用有权限的用户名称进行登录';
	exit;
}

if(isset($_POST['Submit']))
{
	//添加用户
	if(trim($_GET['action']) == 'add')
	{
		$username=trim($_POST['username']);
		$userpass=trim($_POST['userpass']);
		$work=$_POST['work'];
		$flag=$_POST['flag'];
		$pinpaicode=$_POST['pinpaicode'];
		$gongchangcode=$_POST['gongchangcode'];
		$phone=trim($_POST['phone']);
		$mobile=trim($_POST['mobile']);
		$address=trim($_POST['address']);
		$Email=trim($_POST['Email']);
		$time = time();
		
/*		if($pinpaicode <> 'a' and $gongchangcode <> 'a'){
			$kind = 3;	//工厂
		}else if($pinpaicode <> 'a' and $gongchangcode == 'a'){
			$kind = 2;	//品牌
		}else{
			$kind = 1;	//在线映诺人员
		}*/
		
		if($flag == 40){
			$kind = 3;
		}else if($flag == 50){
			$kind = 2;
			$gongchangcode = 'a';
		}else{
			$kind = 1;
			$pinpaicode = 'a';
			$gongchangcode = 'a';
		}
		
		
		//验证用户名是否存在
		$sql="select count(userid) from user where username='$username'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('该用户名已经被注册了！');history.back();</script>";
			exit;
		}
		
		if($Email)
		{
			//验证邮箱是否存在
			$sql="select count(userid) from user where Email='$Email'";
			$rs = mysql_query($sql);
			$row = mysql_fetch_row($rs);
			if($row[0] > 0)
			{
				mysql_close($conn);
				echo "<script>alert('该邮箱已经被其他用户使用了！');history.back();</script>";
				exit;
			}
		}
		
		$sql="insert into user (username,userpass,flag,work,adddate,phone,mobile,address,Email,kind,pinpaicode,gongchangcode) values('$username','$userpass','$flag','$work','$time','$phone','$mobile','$address','$Email',$kind,'$pinpaicode','$gongchangcode')";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('添加成功！');location='adminuser.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('添加失败！');history.back();</script>";
			exit;
	   }
	}

	//修改用户
	if(trim($_GET['action']) == 'edit')
	{
		$userid=$_GET['userid']+0;
		$page = $_GET['page'] + 0;
		 
		$username=trim($_POST['username']);
		$userpass=trim($_POST['userpass']);
		$work=$_POST['work'];
		$flag=$_POST['flag'];
		$pinpaicode=$_POST['pinpaicode'];
		$gongchangcode=$_POST['gongchangcode'];
		$phone=trim($_POST['phone']);
		$mobile=trim($_POST['mobile']);
		$address=trim($_POST['address']);
		$Email=trim($_POST['Email']);
		
		if($flag == 40){
			$kind = 3;		//工厂
		}else if($flag == 50){
			$kind = 2;		//品牌
			$gongchangcode = 'a';
		}else{
			$kind = 1;		//在线映诺人员
			$pinpaicode = 'a';
			$gongchangcode = 'a';
		}
		
		//验证用户名是否存在
		$sql="select count(userid) from user where userid<>$userid and username='$username'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('该用户名已经被注册了！');history.back();</script>";
			exit;
		}
		if($Email)
		{
			//验证邮箱是否存在
			$sql="select count(userid) from user where Email='$Email' and userid != {$userid}";
			$rs = mysql_query($sql);
			$row = mysql_fetch_row($rs);
			if($row[0] > 0)
			{
				mysql_close($conn);
				echo "<script>alert('该邮箱已经被其他用户使用了！');history.back();</script>";
				exit;
			}
		}
		
		$cond = '';
		if ($username=="admin")
		{
			$sql="update user set userpass='$userpass',phone='$phone',mobile='$mobile',address='$address',Email='$Email' where userid=$userid";
			if(mysql_query($sql))
			{
				mysql_close($conn);
				echo "<script>alert('修改成功！');location='adminuser.php?page=$page';</script>";
				exit;
			}else{
				mysql_close($conn);
				echo "<script>alert('修改失败！');history.back();</script>";
				exit;
		   }
		}
		else
		{
			$sql="update user set username='$username',userpass='$userpass',flag='$flag',work='$work',phone='$phone',mobile='$mobile',address='$address',Email='$Email',kind=$kind,pinpaicode='$pinpaicode',gongchangcode='$gongchangcode' where userid=$userid";
			if(mysql_query($sql))
			{
				mysql_close($conn);
				echo "<script>alert('修改成功！');location='adminuser.php?page=$page';</script>";
				exit;
			}else{
				mysql_close($conn);
				echo "<script>alert('修改失败！');history.back();</script>";
				exit;
		   }
		}
	}
}


//删除用户
if($_GET['action']=='del')
{
	$userid=$_GET['userid']+0;
	$page = $_GET['page'] + 0;
	
	$sql='select count(userid) from user where userid='.$userid;
	$rs = mysql_query($sql);
	$row = mysql_fetch_row($rs);
	if($row[0] > 0)
	{
		$sql="delete from user where userid=$userid and username<>'admin' ";
		if(mysql_query($sql)){
			mysql_close($conn);
			echo "<script>alert('删除成功！');location='adminuser.php?page=$page';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('没有该用户记录或者该用户已经被删除！');location='adminuser.php?page=$page';</script>";
		exit;
	}
}

//ajax显示对应品牌下的工厂
if($_GET['action'] == 'show')
{
	header('Content-Type: text/xml;charset=gb2312');
	$pingpaicode = $_GET['value'];
	
	echo '&nbsp;<select name="gongchangcode">';
	echo '<option value="0">请选择</option>';
	if($pingpaicode <> '')
	{
		$rs = mysql_query("select gongchangcode from gongchang where gongchangpinpai='$pingpaicode' order by gongchangid asc");
		while($row = mysql_fetch_array($rs, MYSQL_ASSOC))
		{
			echo '<option value="' . $row['gongchangcode'] . '">' . $row['gongchangcode'] . '</option>';
		}mysql_free_result($rs);
	}
	echo '</select>';
	mysql_close($conn);
	exit;
}
?>