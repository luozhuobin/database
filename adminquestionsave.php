<?
require('libs/config.inc.php');
if($_SESSION['username']==''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag']<98){
	mysql_close($conn);
	echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
	exit;
}

if(isset($_POST['Submit']))
{
	//�������
	if(trim($_GET['action'])=='add')
	{
		$code=trim($_POST['code']);
		$question=trim($_POST['question']);
		$answer=trim($_POST['answer']);
		$keyword=trim($_POST['keyword']);
		$classid=$_POST['classid'];
		
		$userid = $_SESSION['userid'];
		$time = time();

		//��֤����������Ƿ����
		$sql="select count(questionid) from question_answer where code='$code'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		if($row[0] > 0)
		{
			mysql_close($conn);
			echo "<script>alert('�ñ���������Ѿ�����".$code."��');history.back();</script>";
			exit;
		}else{
			mysql_query("update class set count=count+1 where classid=$classid");
		}

		$sql="insert into question_answer (code,question,answer,keyword,addtime,userid,classid) values('$code','$question','$answer','$keyword','$time','$userid','$classid')";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('��ӳɹ���');location='adminquestion.php';</script>";
			exit;
		} else {
			mysql_close($conn);
			echo "<script>alert('���ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
	
	//�޸�����
	if(trim($_GET['action'])=='edit')
	{
		$questionid=$_GET['questionid']+0;
		$page = $_GET['page'] + 0;
		 
		$code=trim($_POST['code']);
		$question=trim($_POST['question']);
		$answer=trim($_POST['answer']);
		$keyword=trim($_POST['keyword']);
		$classid=$_POST['classid'];

		$sql = 'select classid from question_answer where questionid=' . $questionid;
		$rs = mysql_query($sql);
		$row = mysql_fetch_array($rs);
		if($classid <> $row['classid'])
		{
			$classid_old = $row['classid'];
			$classid_new = $classid;
			mysql_query("update class set count=count-1 where classid=$classid_old");
			mysql_query("update class set count=count+1 where classid=$classid_new");
		}

		$sql="update question_answer set code='$code',question='$question',answer='$answer',keyword='$keyword',classid='$classid' where questionid=$questionid";
		if(mysql_query($sql))
		{
			mysql_close($conn);
			echo "<script>alert('�޸ĳɹ���');location='adminquestion.php?page=$page';</script>";
			exit;
		}else{
			mysql_close($conn);
			echo "<script>alert('�޸�ʧ�ܣ�');history.back();</script>";
			exit;
	   }
	}
}
//ɾ������
if($_GET['action']=='del')
{
	$questionid=$_GET['questionid']+0;
	$page = $_GET['page'] + 0;
	
	$sql='select count(questionid) from question_answer where questionid='.$questionid;
	$rs = mysql_query($sql);
	$row = mysql_fetch_row($rs);
	if($row[0] > 0)
	{
		$rs = mysql_query("select classid from question_answer where questionid=$questionid");
		$row = mysql_fetch_array($rs);
		$sql = 'update class set count=count-1 where classid=' . $row[0];
		mysql_query($sql);
		
		$sql="delete from question_answer where questionid=$questionid";
		if(mysql_query($sql)){
			mysql_close($conn);
			echo "<script>alert('ɾ���ɹ���');location='adminquestion.php?page=$page';</script>";
			exit;
		}
	}
	else
	{
		mysql_close($conn);
		echo "<script>alert('û�и������¼���߸������¼�Ѿ���ɾ����');location='adminquestion.php?page=$page';</script>";
		exit;
	}
}
?>