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
	echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
	exit;
}

if(isset($_POST['Submit']))
{

	//�޸��ʼ�
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
			echo "<script>alert('�޸ĳɹ���');location='adminmail.php';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('�޸�ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
}
?>