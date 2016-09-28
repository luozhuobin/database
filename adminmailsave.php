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

	//修改邮件
	if(trim($_GET['action']) == 'edit')
	{
		$id=$_GET['id']+0;
		 
		$title=trim($_POST['title']);
		$username=trim($_POST['username']);
		$passwd=trim($_POST['passwd']);
		$smtp=trim($_POST['smtp']);
		
		$sql="update email set title='$title',username='$username',passwd='$passwd',smtp='$smtp' where id=$id";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('修改成功！');location='adminmail.php';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('修改失败！');history.back();</script>";
			exit;
	   }
	}
}
?>