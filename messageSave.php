<?
require('libs/config.inc.php');
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
	
	//添加留言
	if($_GET['action']=='addmsg')
	{
		$title=trim($_POST['title']);
		$content=trim($_POST['content']);
		if($_POST['msgobj']==1){ $replyuserid=$_POST['replyuserid1'];}else if($_POST['msgobj']==2){ $replyuserid=$_POST['replyuserid2'];}else if($_POST['msgobj']==3){ $replyuserid=$_POST['replyuserid3'];}
		$is_load=$_POST['is_load'];
		$msgcheckcode=trim($_POST['msgcheckcode']);
		
		setcookie('handshakemsgtitle',$title);	//设置留言标题cookie
		setcookie('handshakemsgcontent',$content);	//设置留言内容cookie
		
		if($title==''){
			mysql_close($conn);
			echo "<script>alert('留言标题不能为空！');location='addmessage.php';</script>";
			exit;	
		}else if(strlen($title)>100){
			mysql_close($conn);
			echo "<script>alert('留言标题不能超出100个字节！');location='addmessage.php';</script>";
			exit;	
		}
		
		if($content==''){
			mysql_close($conn);
			echo "<script>alert('留言内容不能为空！');location='addmessage.php';</script>";
			exit;	
		}else if(strlen($content)>1000){
			mysql_close($conn);
			echo "<script>alert('留言内容不能超出1000个字节！');location='addmessage.php';</script>";
			exit;	
		}
		if(empty($replyuserid)){
			mysql_close($conn);
			echo "<script>alert('您没有选择留言对象！');location='addmessage.php';</script>";
			exit;
		}
		session_start();
		if($msgcheckcode==''){
			mysql_close($conn);
			echo "<script>alert('验证码不能为空！');location='addmessage.php';</script>";
			exit;	
		}else if($msgcheckcode<>$_SESSION['msgcheckcode']){
			mysql_close($conn);
			echo "<script>alert('验证码错误！');location='addmessage.php';</script>";
			exit;	
		}
		
		$additional=0;	//是否有附件
		
		//判断是否有选上传文件
		if($is_load==1)
		{
			//判断上传是否出错，0表示没有发生错误
			if($_FILES['file']['error']>0)	
			{
				$error=$_FILES['file']['error'];
				switch($error){
					case 1:
						$errortype='上传的文件超出php.ini文件中upload_max_filesize 选项限制的值！';break;
					case 2:
						$errortype='上传的文件大小超过了HTML表单中规定的最大值！';break;
					case 3:
						$errortype='文件只有部分被上传！';break;
					case 4:
						$errortype='没有文件被上传！';break;
				}
				
				mysql_close($conn);
				echo "<script>alert('文件上传出错！错误类型为：".$errortype."');location='addmessage.php';</script>";
				exit;
			}else{
				$ym=date('Ym',time());
				$uploaddir = 'upfiles/'.$ym.'/';		//设置文件保存目录 
				if(!file_exists($uploaddir)) mkdir($uploaddir);   	//如果不存在文件目录，就自动创建该目录
				$typeArr=array('pdf','doc','docx','xls','xlsx','rar','zip','jpg');	//设置允许上传文件的类型
				//获取上传文件后缀名函数
				function fileext($filename){ return substr(strrchr($filename,'.'), 1);}
				$filetype=strtolower(fileext($_FILES['file']['name']));		//上传文件后缀名
				$same='no';
				//判断文件类型是否匹配
				foreach($typeArr as $v){ if($filetype==$v){ $same='yes';break;}}
				
				if($same=='no'){
					mysql_close($conn);
					echo "<script>alert('您上传的文件类型不符合要求！');location='addmessage.php';</script>";
					exit;	
				}
		
				$filesize=$_FILES['file']['size']/1024;		//文件大小
				$filesize=round($filesize,2);
				
				$rand=mt_rand(1000,9999);	//生成四位随机数
				$t=date('YmdHis');
				$thename=$userid.'_'.$t.'_'.$rand.'.'.$filetype;
				$uploadfile=$uploaddir.$thename;	//上传后的文件完整路径
		
				if(is_uploaded_file($_FILES['file']['tmp_name']))		//判断是否通过HTTP POST上传
				{ 
					//上传并移动文件
					if(move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile)){
						$additional=1;
					}else{
						mysql_close($conn);
						echo "<script>alert('上传失败');location='addmessage.php';</script>";
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
			if($additional==1)	//如果有上传附件
			{
				$type=getfiletype($filetype);	//文件类型
				//添加记录到附件表
				$sql="insert into additional_table (mid,q_uid,q_kind,q_pinpai,q_gongchang,r_uid,r_kind,r_pinpai,r_gongchang,filename,url,type,size) values($mid,$userid,$kind,'$pinpaicode','$gongchangcode',$r_uid,$r_kind,'$r_pinpai','$r_gongchang','$thename','$uploadfile',$type,'$filesize')";
				mysql_query($sql);
			}
			setcookie('handshakemsgtitle','',time()-1);			//删除留言标题cookie
			setcookie('handshakemsgcontent','',time()-1);		//删除留言内容cookie
			
			//检验回复人是否有邮箱，有就发送提醒邮件
			$rs = mysql_query("select Email from user where userid=$r_uid");
			$row = mysql_fetch_array($rs);
			if($row['Email']){
				$Email = $row['Email'];
				//读取管理员邮件信息
				$rs = mysql_query("select * from email where id=1");
				$row = mysql_fetch_array($rs,MYSQL_ASSOC);
				if($row){ send_Email($r_username,$row['Email'],1,$row['title'],$row['username'],$row['passwd'],$row['smtp']);	}
			}
			mysql_close($conn);
			echo "<script>alert('添加成功！');location='message.php?k=1';</script>";
			exit;		
		}else{
			mysql_close($conn);
			echo "<script>alert('添加失败！');location='addmessage.php';</script>";
			exit;	
		}
		
	}
	
	//留言回复
	if($_GET['action']=='reply')
	{
		$mid=$_GET['mid']+0;
		$reply_content=trim($_POST['reply_content']);
		$is_load=$_POST['is_load'];
		$msgcheckcode=trim($_POST['msgcheckcode']);
		
		$k=$_GET['k']+0;
		$page=$_GET['page']+0;
		
		setcookie('handshakemsgreplay',$reply_content);		//设置留言回复cookie
		
		if($reply_content==''){
			mysql_close($conn);
			echo "<script>alert('回复内容不能为空！');history.back();</script>";
			exit;	
		}else if(strlen($reply_content)>1000){
			mysql_close($conn);
			echo "<script>alert('回复内容不能超出1000个字节！');history.back();</script>";
			exit;	
		}
		
		session_start();
		if($msgcheckcode==''){
			mysql_close($conn);
			echo "<script>alert('验证码不能为空！');history.back();</script>";
			exit;	
		}else if($msgcheckcode<>$_SESSION['msgcheckcode']){
			mysql_close($conn);
			echo "<script>alert('验证码错误！');history.back();</script>";
			exit;	
		}
		
		$additional=0;	//是否有附件
		
		//判断是否有选上传文件
		if($is_load==1)
		{
			//判断上传是否出错，0表示没有发生错误
			if($_FILES['file']['error']>0)	
			{
				$error=$_FILES['file']['error'];
				switch($error){
					case 1:
						$errortype='上传的文件超出php.ini文件中upload_max_filesize 选项限制的值！';break;
					case 2:
						$errortype='上传的文件大小超过了HTML表单中规定的最大值！';break;
					case 3:
						$errortype='文件只有部分被上传！';break;
					case 4:
						$errortype='没有文件被上传！';break;
				}
				
				mysql_close($conn);
				echo "<script>alert('文件上传出错！错误类型为：".$errortype."');history.back();</script>";
				exit;
			}else{
				$ym=date('Ym',time());
				$uploaddir = 'upfiles/'.$ym.'/';		//设置文件保存目录 
				if(!file_exists($uploaddir)) mkdir($uploaddir);   	//如果不存在文件目录，就自动创建该目录
				$typeArr=array('pdf','doc','docx','xls','xlsx','rar','zip','jpg');	//设置允许上传文件的类型
				//获取上传文件后缀名函数
				function fileext($filename){ return substr(strrchr($filename,'.'), 1);}
				$filetype=strtolower(fileext($_FILES['file']['name']));		//上传文件后缀名
				$same='no';
				//判断文件类型是否匹配
				foreach($typeArr as $v){ if($filetype==$v){ $same='yes';break;}}
				
				if($same=='no'){
					mysql_close($conn);
					echo "<script>alert('您上传的文件类型不符合要求！');history.back();</script>";
					exit;	
				}
		
				$filesize=$_FILES['file']['size']/1024;		//文件大小
				$filesize=round($filesize,2);
				
				$rand=mt_rand(1000,9999);	//生成四位随机数
				$t=date('YmdHis');
				$thename=$userid.'_'.$t.'_'.$rand.'.'.$filetype;
				$uploadfile=$uploaddir.$thename;	//上传后的文件完整路径
		
				if(is_uploaded_file($_FILES['file']['tmp_name']))		//判断是否通过HTTP POST上传
				{ 
					//上传并移动文件
					if(move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile)){
						$additional=1;
					}else{
						mysql_close($conn);
						echo "<script>alert('上传失败');history.back();</script>";
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
			if($additional==1)	//如果有上传附件
			{
				$type=getfiletype($filetype);	//文件类型
				//添加记录到附件表
				$sql="insert into additional_table (rid,q_uid,q_kind,q_pinpai,q_gongchang,r_uid,r_kind,r_pinpai,r_gongchang,filename,url,type,size) values($rid,$q_uid,$q_kind,'$q_pinpai','$q_gongchang',$userid,$kind,'$pinpaicode','$gongchangcode','$thename','$uploadfile',$type,'$filesize')";			
				mysql_query($sql);
			}
			mysql_query("update message_table set is_read=1,reply_counts=reply_counts+1,no_read_counts=no_read_counts+1 where mid=$mid");
			setcookie('handshakemsgreplay','',time()-1);	//清除留言回复cookie
			
			//检验提问人是否有邮箱，有就发送提醒邮件
			$rs = mysql_query("select Email from user where userid=$q_uid");
			$row = mysql_fetch_array($rs);
			if($row['Email']){
				$Email = $row['Email'];
				//读取管理员邮件信息
				$rs = mysql_query("select * from email where id=1");
				$row = mysql_fetch_array($rs,MYSQL_ASSOC);
				if($row){ send_Email($r_username,$row['Email'],1,$row['title'],$row['username'],$row['passwd'],$row['smtp']);	}
			}
			
			mysql_close($conn);
			echo "<script>alert('回复成功！');location='message.php?k=$k&sort=all&page=$page';</script>";
			exit;		
		}else{
			mysql_close($conn);
			echo "<script>alert('回复失败！');history.back();</script>";
			exit;	
		}
	}
}

//ajax验证码检查
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

//设为已阅读
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

//设为已解决
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

//ajax显示品牌和工厂
if($_GET['action']=='change')
{
	$sort=$_GET['sort']+0;
	$code=$_GET['code'];
	
	header('Content-Type: text/xml;charset=gb2312');
	header("Cache-Control: no-cache, must-revalidate");
	
	if($sort==1)
	{
		//显示用户
		echo 'sort1';
		echo '|||';		//分隔符
		if($code=='0'){		//如果选项为请选择显示空
			echo 'null';
		}else{
			echo '&nbsp;<select name="replyuserid2">';
			echo '<option value="0">请选择</option>';
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
		//显示工厂
		echo 'sort2';
		echo '|||';		//分隔符
		if($code=='0'){		//如果选项为请选择显示空
			echo 'null';
		}else{
			$i=1;
			echo '&nbsp;<select name="gongchangcode3" onChange="msgAjax("change",3,this.value)">';
			echo '<option value="0">请选择</option>';
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
		//显示用户
		echo 'sort3';
		echo '|||';		//分隔符
		if($code=='0'){		//如果选项为请选择显示空
			echo 'null';
		}else{
			echo '&nbsp;<select name="replyuserid3">';
			echo '<option value="0">请选择</option>';
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