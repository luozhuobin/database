<?php
require('../libs/config.inc.php');
if($_SESSION['username']==''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag']<40 or $_SESSION['flag'] == 91){
	mysql_close($conn);
	echo '您权限不足，请使用有权限的用户名称进行登录';
	exit;
}
switch($_GET['action']){
	case 'getFactoryByBrands':
			$brands = $_POST['brands'];
			if(empty($brands)){
				echo json_encode(array("result"=>"1001","msg"=>"error post"));exit();
			}
			$list = array();
			$sql = "SELECT gongchangcode,gongchangname FROM gongchang WHERE gongchangpinpai = '{$brands}'";
			$query = mysql_query($sql);
			while($row = mysql_fetch_assoc($query)){
				$list[$row['gongchangcode']] = iconv('GB2312', 'UTF-8', $row["gongchangname"]);
				//$list[$row['gongchangid']] ="adfadfadfafd";
				//$list[$row["gongchangid"]] = $row["gongchangname"];
			}
			echo json_encode($list);
			exit();
		exit;
		break;
}
?>