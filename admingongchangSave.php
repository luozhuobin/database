<?
require('libs/config.inc.php');
if($_SESSION['username']==''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag']<95){
	mysql_close($conn);
	echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
	exit;
}

if(isset($_POST['Submit']))
{
	//��ӹ���
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
		
		//��֤���������Ƿ����
		$sql="select count(gongchangid) from gongchang where gongchangname='$gongchangname'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('���������Ѿ����ڣ�');history.back();</script>";
			exit;
		}
		
		//��֤���������Ƿ����
		$sql="select count(gongchangid) from gongchang where gongchangcode='$gongchangcode'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('���������Ѿ����ڣ�');history.back();</script>";
			exit;
		}
		
		//��֤Ʒ���Ƿ����
		$sql='select pinpai_id,pinpainame,pinpaicode from pinpai where pinpai_id='.$pinpai_id;
		$rs = mysql_query($sql);
		$row = mysql_fetch_array($rs);
		if(!$row)
		{
			mysql_close($conn);
			echo "<script>alert('Ʒ�Ʋ����ڣ�');history.back();</script>";
			exit;
		}
		$pinpainame = $row['pinpainame'];
		$gongchangpinpai = $row['pinpaicode'];
		
		$sql="insert into gongchang (gongchangname,gongchangcode,gongchangdizhi,gongchangdianhua,lianxiren,cityname,pinpai_id,pinpainame,gongchangpinpai,gongchangchanpin,gongchangrenshu) values('$gongchangname','$gongchangcode','$gongchangdizhi','$gongchangdianhua','$lianxiren','$cityname',$pinpai_id,'$pinpainame','$gongchangpinpai','$gongchangchanpin','$gongchangrenshu')";
		//echo $sql;
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('��ӳɹ���');location='admingongchang.php';</script>";
			exit;
		}
	   else
	   {
			mysql_close($conn);
			echo "<script>alert('���ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
	
	//�޸Ĺ���
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
			 
		//��֤Ʒ���Ƿ����
		$sql='select pinpai_id,pinpainame,pinpaicode from pinpai where pinpai_id='.$pinpai_id;
		$rs = mysql_query($sql);
		$row = mysql_fetch_array($rs);
		if(!$row)
		{
			mysql_close($conn);
			echo "<script>alert('Ʒ�Ʋ����ڣ�');history.back();</script>";
			exit;
		}
		$pinpainame=$row['pinpainame'];
		$gongchangpinpai=$row['pinpaicode'];

		$sql="update gongchang set gongchangname='$gongchangname',gongchangcode='$gongchangcode',gongchangdizhi='$gongchangdizhi',gongchangdianhua='$gongchangdianhua',lianxiren='$lianxiren',cityname='$cityname',pinpai_id=$pinpai_id,pinpainame='$pinpainame',gongchangpinpai='$gongchangpinpai',gongchangchanpin='$gongchangchanpin',gongchangrenshu='$gongchangrenshu' where gongchangid=$gongchangid";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('�޸ĳɹ���');location='admingongchang.php?page=$page';</script>";
			exit;
		}
	   else
	   {
			mysql_close($conn);
			echo "<script>alert('�޸�ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
}

//ɾ������
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
			echo "<script>alert('ɾ���ɹ���');location='admingongchang.php?page=$page';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('û�иù�����¼���߸ù�����¼�Ѿ���ɾ����');location='admingongchang.php?page=$page';</script>";
		exit;
	}
}

?>