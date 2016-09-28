<?
session_start();
//ÓÃ»§×¢Ïú
if($_GET['action'] == 'logout')
{
	unset($_SESSION['userid']);
	unset($_SESSION['username']);
	unset($_SESSION['flag']);
	unset($_SESSION['kind']);
	unset($_SESSION['pinpaicode']);
	unset($_SESSION['gongchangcode']);
	unset($_SESSION['pinpainame']);
	unset($_SESSION['gongchangname']);
	session_unset();
	session_destroy();
	header("location:login.php");
	exit;
}


?>