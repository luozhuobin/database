<?
require('libs/config.inc.php');
if($_SESSION['username']==''){
	mysql_close($conn);
	header('location:login.php');
	exit;
}
if($_SESSION['flag']<40 or $_SESSION['flag'] == 91){
	mysql_close($conn);
	echo '��Ȩ�޲��㣬��ʹ����Ȩ�޵��û����ƽ��е�¼';
	exit;
}

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$kind = $_SESSION['kind'];
$pinpaicode = $_SESSION['pinpaicode'];
$gongchangcode = $_SESSION['gongchangcode'];
$pinpainame = $_SESSION['pinpainame'];
$gongchangname = $_SESSION['gongchangname'];

if(isset($_POST['Submit']))
{
	$time=time();
	
	//�������
	if($_GET['action']=='addmsg')
	{
		$title=trim($_POST['title']);
		$content=trim($_POST['content']);
		if($_POST['msgobj']==1){ $replyuserid=$_POST['replyuserid1'];}else if($_POST['msgobj']==2){ $replyuserid=$_POST['replyuserid2'];}else if($_POST['msgobj']==3){ $replyuserid=$_POST['replyuserid3'];}
		$is_load=$_POST['is_load'];
		$msgcheckcode=trim($_POST['msgcheckcode']);
		
		setcookie('handshakemsgtitle',$title);	//�������Ա���cookie
		setcookie('handshakemsgcontent',$content);	//������������cookie
		
		if($title==''){
			mysql_close($conn);
			echo "<script>alert('���Ա��ⲻ��Ϊ�գ�');location='addmessage.php';</script>";
			exit;	
		}else if(strlen($title)>100){
			mysql_close($conn);
			echo "<script>alert('���Ա��ⲻ�ܳ���100���ֽڣ�');location='addmessage.php';</script>";
			exit;	
		}
		
		if($content==''){
			mysql_close($conn);
			echo "<script>alert('�������ݲ���Ϊ�գ�');location='addmessage.php';</script>";
			exit;	
		}else if(strlen($content)>1000){
			mysql_close($conn);
			echo "<script>alert('�������ݲ��ܳ���1000���ֽڣ�');location='addmessage.php';</script>";
			exit;	
		}
		if(empty($replyuserid)){
			mysql_close($conn);
			echo "<script>alert('��û��ѡ�����Զ���');location='addmessage.php';</script>";
			exit;
		}
		session_start();
		if($msgcheckcode==''){
			mysql_close($conn);
			echo "<script>alert('��֤�벻��Ϊ�գ�');location='addmessage.php';</script>";
			exit;	
		}else if($msgcheckcode<>$_SESSION['msgcheckcode']){
			mysql_close($conn);
			echo "<script>alert('��֤�����');location='addmessage.php';</script>";
			exit;	
		}
		
		$additional=0;	//�Ƿ��и���
		
		//�ж��Ƿ���ѡ�ϴ��ļ�
		if($is_load==1)
		{
			//�ж��ϴ��Ƿ����0��ʾû�з�������
			if($_FILES['file']['error']>0)	
			{
				$error=$_FILES['file']['error'];
				switch($error){
					case 1:
						$errortype='�ϴ����ļ�����php.ini�ļ���upload_max_filesize ѡ�����Ƶ�ֵ��';break;
					case 2:
						$errortype='�ϴ����ļ���С������HTML���й涨�����ֵ��';break;
					case 3:
						$errortype='�ļ�ֻ�в��ֱ��ϴ���';break;
					case 4:
						$errortype='û���ļ����ϴ���';break;
				}
				
				mysql_close($conn);
				echo "<script>alert('�ļ��ϴ�������������Ϊ��".$errortype."');location='addmessage.php';</script>";
				exit;
			}else{
				$ym=date('Ym',time());
				$uploaddir = 'upfiles/'.$ym.'/';		//�����ļ�����Ŀ¼ 
				if(!file_exists($uploaddir)) mkdir($uploaddir);   	//����������ļ�Ŀ¼�����Զ�������Ŀ¼
				$typeArr=array('pdf','doc','docx','xls','xlsx','rar','zip','jpg');	//���������ϴ��ļ�������
				//��ȡ�ϴ��ļ���׺������
				function fileext($filename){ return substr(strrchr($filename,'.'), 1);}
				$filetype=strtolower(fileext($_FILES['file']['name']));		//�ϴ��ļ���׺��
				$same='no';
				//�ж��ļ������Ƿ�ƥ��
				foreach($typeArr as $v){ if($filetype==$v){ $same='yes';break;}}
				
				if($same=='no'){
					mysql_close($conn);
					echo "<script>alert('���ϴ����ļ����Ͳ�����Ҫ��');location='addmessage.php';</script>";
					exit;	
				}
		
				$filesize=$_FILES['file']['size']/1024;		//�ļ���С
				$filesize=round($filesize,2);
				
				$rand=mt_rand(1000,9999);	//������λ�����
				$t=date('YmdHis');
				$thename=$userid.'_'.$t.'_'.$rand.'.'.$filetype;
				$uploadfile=$uploaddir.$thename;	//�ϴ�����ļ�����·��
		
				if(is_uploaded_file($_FILES['file']['tmp_name']))		//�ж��Ƿ�ͨ��HTTP POST�ϴ�
				{ 
					//�ϴ����ƶ��ļ�
					if(move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile)){
						$additional=1;
					}else{
						mysql_close($conn);
						echo "<script>alert('�ϴ�ʧ��');location='addmessage.php';</script>";
						exit;
					}
			   	}
			}
		}
		
		$rs = mysql_query("select userid,username,kind,pinpaicode,gongchangcode from user where userid=$replyuserid");
		$row = mysql_fetch_array($rs, MYSQL_ASSOC);
		$r_uid = $row['userid'];
		$r_username = $row['username'];
		$r_kind = $row['kind'];
		$r_pinpai = $row['pinpaicode'];
		$r_gongchang = $row['gongchangcode'];
		
		$sql="insert into message_table (q_uid,q_username,q_kind,q_pinpai,q_gongchang,r_uid,r_username,r_kind,r_pinpai,r_gongchang,q_title,q_content,add_time,additional) values($userid,'$username',$kind,'$pinpaicode','$gongchangcode',$r_uid,'$r_username',$r_kind,'$r_pinpai','$r_gongchang','$title','$content',$time,'$additional')";
		if(mysql_query($sql)){
			$mid=mysql_insert_id();
			if($additional==1)	//������ϴ�����
			{
				$type=getfiletype($filetype);	//�ļ�����
				//��Ӽ�¼��������
				$sql="insert into additional_table (mid,q_uid,q_kind,q_pinpai,q_gongchang,r_uid,r_kind,r_pinpai,r_gongchang,filename,url,type,size) values($mid,$userid,$kind,'$pinpaicode','$gongchangcode',$r_uid,$r_kind,'$r_pinpai','$r_gongchang','$thename','$uploadfile',$type,'$filesize')";
				mysql_query($sql);
			}
			setcookie('handshakemsgtitle','',time()-1);			//ɾ�����Ա���cookie
			setcookie('handshakemsgcontent','',time()-1);		//ɾ����������cookie
			
			//����ظ����Ƿ������䣬�оͷ��������ʼ�
			$rs = mysql_query("select Email from user where userid=$r_uid");
			$row = mysql_fetch_array($rs);
			if($row['Email']){
				$Email = $row['Email'];
				//��ȡ����Ա�ʼ���Ϣ
				$rs = mysql_query("select * from email where id=1");
				$row = mysql_fetch_array($rs,MYSQL_ASSOC);
				if($row){ send_Email($r_username,$row['Email'],1,$row['title'],$row['username'],$row['passwd'],$row['smtp']);	}
			}
			mysql_close($conn);
			echo "<script>alert('��ӳɹ���');location='message.php?k=1';</script>";
			exit;		
		}else{
			mysql_close($conn);
			echo "<script>alert('���ʧ�ܣ�');location='addmessage.php';</script>";
			exit;	
		}
		
	}
	
	//���Իظ�
	if($_GET['action']=='reply')
	{
		$mid=$_GET['mid']+0;
		$reply_content=trim($_POST['reply_content']);
		$is_load=$_POST['is_load'];
		$msgcheckcode=trim($_POST['msgcheckcode']);
		
		$k=$_GET['k']+0;
		$page=$_GET['page']+0;
		
		setcookie('handshakemsgreplay',$reply_content);		//�������Իظ�cookie
		
		if($reply_content==''){
			mysql_close($conn);
			echo "<script>alert('�ظ����ݲ���Ϊ�գ�');history.back();</script>";
			exit;	
		}else if(strlen($reply_content)>1000){
			mysql_close($conn);
			echo "<script>alert('�ظ����ݲ��ܳ���1000���ֽڣ�');history.back();</script>";
			exit;	
		}
		
		session_start();
		if($msgcheckcode==''){
			mysql_close($conn);
			echo "<script>alert('��֤�벻��Ϊ�գ�');history.back();</script>";
			exit;	
		}else if($msgcheckcode<>$_SESSION['msgcheckcode']){
			mysql_close($conn);
			echo "<script>alert('��֤�����');history.back();</script>";
			exit;	
		}
		
		$additional=0;	//�Ƿ��и���
		
		//�ж��Ƿ���ѡ�ϴ��ļ�
		if($is_load==1)
		{
			//�ж��ϴ��Ƿ����0��ʾû�з�������
			if($_FILES['file']['error']>0)	
			{
				$error=$_FILES['file']['error'];
				switch($error){
					case 1:
						$errortype='�ϴ����ļ�����php.ini�ļ���upload_max_filesize ѡ�����Ƶ�ֵ��';break;
					case 2:
						$errortype='�ϴ����ļ���С������HTML���й涨�����ֵ��';break;
					case 3:
						$errortype='�ļ�ֻ�в��ֱ��ϴ���';break;
					case 4:
						$errortype='û���ļ����ϴ���';break;
				}
				
				mysql_close($conn);
				echo "<script>alert('�ļ��ϴ�������������Ϊ��".$errortype."');history.back();</script>";
				exit;
			}else{
				$ym=date('Ym',time());
				$uploaddir = 'upfiles/'.$ym.'/';		//�����ļ�����Ŀ¼ 
				if(!file_exists($uploaddir)) mkdir($uploaddir);   	//����������ļ�Ŀ¼�����Զ�������Ŀ¼
				$typeArr=array('pdf','doc','docx','xls','xlsx','rar','zip','jpg');	//���������ϴ��ļ�������
				//��ȡ�ϴ��ļ���׺������
				function fileext($filename){ return substr(strrchr($filename,'.'), 1);}
				$filetype=strtolower(fileext($_FILES['file']['name']));		//�ϴ��ļ���׺��
				$same='no';
				//�ж��ļ������Ƿ�ƥ��
				foreach($typeArr as $v){ if($filetype==$v){ $same='yes';break;}}
				
				if($same=='no'){
					mysql_close($conn);
					echo "<script>alert('���ϴ����ļ����Ͳ�����Ҫ��');history.back();</script>";
					exit;	
				}
		
				$filesize=$_FILES['file']['size']/1024;		//�ļ���С
				$filesize=round($filesize,2);
				
				$rand=mt_rand(1000,9999);	//������λ�����
				$t=date('YmdHis');
				$thename=$userid.'_'.$t.'_'.$rand.'.'.$filetype;
				$uploadfile=$uploaddir.$thename;	//�ϴ�����ļ�����·��
		
				if(is_uploaded_file($_FILES['file']['tmp_name']))		//�ж��Ƿ�ͨ��HTTP POST�ϴ�
				{ 
					//�ϴ����ƶ��ļ�
					if(move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile)){
						$additional=1;
					}else{
						mysql_close($conn);
						echo "<script>alert('�ϴ�ʧ��');history.back();</script>";
						exit;
					}
			   	}
			}
		}
		$rs=mysql_query("select q_uid,q_kind,q_pinpai,q_gongchang from message_table where mid=$mid");
		$row=mysql_fetch_array($rs,MYSQL_ASSOC);
		$q_uid=$row['q_uid'];
		$q_kind=$row['q_kind'];
		$q_pinpai=$row['q_pinpai'];
		$q_gongchang=$row['q_gongchang'];
		
		$sql="insert into reply_table (mid,r_uid,r_username,q_uid,q_kind,q_pinpai,q_gongchang,reply_content,additional,add_time) values($mid,$userid,'$username',$q_uid,$q_kind,'$q_pinpai','$q_gongchang','$reply_content','$additional',$time)";
		if(mysql_query($sql)){
			$rid=mysql_insert_id();
			if($additional==1)	//������ϴ�����
			{
				$type=getfiletype($filetype);	//�ļ�����
				//��Ӽ�¼��������
				$sql="insert into additional_table (rid,q_uid,q_kind,q_pinpai,q_gongchang,r_uid,r_kind,r_pinpai,r_gongchang,filename,url,type,size) values($rid,$q_uid,$q_kind,'$q_pinpai','$q_gongchang',$userid,$kind,'$pinpaicode','$gongchangcode','$thename','$uploadfile',$type,'$filesize')";			
				mysql_query($sql);
			}
			mysql_query("update message_table set is_read=1,reply_counts=reply_counts+1,no_read_counts=no_read_counts+1 where mid=$mid");
			setcookie('handshakemsgreplay','',time()-1);	//������Իظ�cookie
			
			//�����������Ƿ������䣬�оͷ��������ʼ�
			$rs = mysql_query("select Email from user where userid=$q_uid");
			$row = mysql_fetch_array($rs);
			if($row['Email']){
				$Email = $row['Email'];
				//��ȡ����Ա�ʼ���Ϣ
				$rs = mysql_query("select * from email where id=1");
				$row = mysql_fetch_array($rs,MYSQL_ASSOC);
				if($row){ send_Email($r_username,$row['Email'],1,$row['title'],$row['username'],$row['passwd'],$row['smtp']);	}
			}
			
			mysql_close($conn);
			echo "<script>alert('�ظ��ɹ���');location='message.php?k=$k&sort=all&page=$page';</script>";
			exit;		
		}else{
			mysql_close($conn);
			echo "<script>alert('�ظ�ʧ�ܣ�');history.back();</script>";
			exit;	
		}
	}
}

//ajax��֤����
if($_GET['action']=='codecheck')
{
	$code=$_GET['x'];
	session_start();
	if($code==$_SESSION['msgcheckcode'])
	{
		mysql_close($conn);
		echo 'checkpass';
		exit;
	}else{
		mysql_close($conn);
		echo 'checkfail';
		exit;
	}
}

//��Ϊ���Ķ�
if($_GET['action']=='read')
{
	$mid=$_GET['x']+0;
	$sql="update message_table set is_read=1 where mid=$mid";
	if(mysql_query($sql))
	{
		mysql_close($conn);
		echo 'readpass,'.$mid;
		exit;
	}else{
		mysql_close($conn);
		echo 'readfail';
		exit;
	}
}

//��Ϊ�ѽ��
if($_GET['action']=='done' && $_SESSION['kind']==1)
{
	$mid=$_GET['x']+0;
	$time=time();
	$sql="update message_table set is_done=1,is_done_uid=$userid,is_done_time=$time where mid=$mid";
	if(mysql_query($sql))
	{
		mysql_close($conn);
		echo 'donepass,'.$mid;
		exit;
	}else{
		mysql_close($conn);
		echo 'donefail';
		exit;
	}
}

//ajax��ʾƷ�ƺ͹���
if($_GET['action']=='change')
{
	$sort=$_GET['sort']+0;
	$code=$_GET['code'];
	
	header('Content-Type: text/xml;charset=gb2312');
	header("Cache-Control: no-cache, must-revalidate");
	
	if($sort==1)
	{
		//��ʾ�û�
		echo 'sort1';
		echo '|||';		//�ָ���
		if($code=='0'){		//���ѡ��Ϊ��ѡ����ʾ��
			echo 'null';
		}else{
			echo '&nbsp;<select name="replyuserid2">';
			echo '<option value="0">��ѡ��</option>';
			$rs = mysql_query("select userid,username from user where kind=2 and pinpaicode='$code' order by userid asc");
			while($row = mysql_fetch_array($rs, MYSQL_ASSOC))
			{
				echo "<option value='".$row['userid']."'>".$row['username']."</option>";
			}mysql_free_result($rs);
			echo '</select>';
		}
	}
	else if($sort==2)
	{
		//��ʾ����
		echo 'sort2';
		echo '|||';		//�ָ���
		if($code=='0'){		//���ѡ��Ϊ��ѡ����ʾ��
			echo 'null';
		}else{
			$i=1;
			echo '&nbsp;<select name="gongchangcode3" onChange="msgAjax("change",3,this.value)">';
			echo '<option value="0">��ѡ��</option>';
			$rs = mysql_query("select gongchangname,gongchangcode from gongchang where gongchangpinpai='$code' order by gongchangid asc");
			while($row = mysql_fetch_array($rs, MYSQL_ASSOC))
			{
				if($i==1){$gongchangcode=$row['gongchangcode'];}
				$i++;
				echo "<option value='".$row['gongchangcode']."'>".$row['gongchangname']."</option>";
			}mysql_free_result($rs);
			echo '</select>';
		}
	}
	else if($sort==3)
	{
		//��ʾ�û�
		echo 'sort3';
		echo '|||';		//�ָ���
		if($code=='0'){		//���ѡ��Ϊ��ѡ����ʾ��
			echo 'null';
		}else{
			echo '&nbsp;<select name="replyuserid3">';
			echo '<option value="0">��ѡ��</option>';
			$rs = mysql_query("select userid,username from user where kind=3 and gongchangcode='$code' order by userid asc");
			while($row = mysql_fetch_array($rs, MYSQL_ASSOC))
			{
				echo "<option value='".$row['userid']."'>".$row['username']."</option>";
			}mysql_free_result($rs);
			echo '</select>';
		}
	}
	mysql_close($conn);
	exit;
}

?>