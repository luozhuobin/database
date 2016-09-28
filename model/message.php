<?php 
/**
 * @desc 本文件处理留言相关 不重构项目结构了，额，按照原作者的来。
 * @author lzb
 * @since 2013-3-7
 */
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

if(!empty($_GET["action"])){
	switch($_GET["action"]){
		case 'addmsg':
			$title = $_POST["title"];
			$sendObj = $_POST["sendObj"];
			$content = $_POST["content"];
			$code = $_POST["code"];
			$parent_id = intval($_POST['parent_id'])>0?intval($_POST['parent_id']):0;
			$url = $parent_id >0 ?'/messageShow.php?id='.$parent_id:'/addmessage.php';
			session_start();
			if($sendObj==''){
				mysql_close($conn);
				echo "<script>alert('留言对象不能为空！');location='{$url}';</script>";
				exit;	
			}
			if($title==''){
				mysql_close($conn);
				echo "<script>alert('留言主题不能为空！');location='{$url}';</script>";
				exit;	
			}
			if($content==''){
				mysql_close($conn);
				echo "<script>alert('留言内容不能为空！');location='{$url}';</script>";
				exit;	
			}
			if($code==''&&$parent_id==0){
				mysql_close($conn);
				echo "<script>alert('验证码不能为空！');location='{$url}';</script>";
				exit;	
			}else if($code!=$_SESSION['msgcheckcode']&&$parent_id==0){
				mysql_close($conn);
				echo "<script>alert('验证码错误！');location='{$url}';</script>";
				exit;	
			}
			##上传附件
			if($_POST['is_load']==1){
				$uploaddir = 'upfiles/';		//设置文件保存目录 
				if(!file_exists($uploaddir)) mkdir($uploaddir);   	//如果不存在文件目录，就自动创建该目录
				$uploaddir .= date('Ym').'/';		//设置文件保存目录 
				if(!file_exists($uploaddir)) mkdir($uploaddir);   	//如果不存在文件目录，就自动创建该目录
				$typeArr=array('pdf','doc','docx','xls','xlsx','rar','zip','jpg','jpeg','png');	//设置允许上传文件的类型
				//获取上传文件后缀名函数
				$filetype=strtolower(substr(strrchr($_FILES['file']['name'],'.'),1));		//上传文件后缀名
				//判断文件类型是否匹配
				if(!in_array($filetype,$typeArr)){
					echo "<script>alert('您上传的文件类型不符合要求！');location='{$url}';</script>";
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
					if(!move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile)){
						mysql_close($conn);
						echo "<script>alert('上传失败');location='{$url}';</script>";
						exit;
					}
			   	}
			}
			$sql = "INSERT INTO `message_content`(`id`,`title`,`content`,`attachment`,`is_solve`,`solvetime`,`createtime`) 
					VALUES(null,'{$title}','{$content}','{$uploadfile}','N','0','".time()."')";
			$query = mysql_query($sql);
			$content_id = mysql_insert_id();
			if($query){
				$sendObj = str_ireplace("\r",'',$sendObj);
				$sendObj = str_ireplace("\n",'',$sendObj);
				$arr = explode(";",$sendObj);
				$arr = array_filter($arr);
				$to_arr = array();
				foreach($arr as $key=>$value){
					if(!empty($value)){
						$rs = mysql_query("SELECT userid,email FROM `user` WHERE username = '{$value}'");
						$row = mysql_fetch_array($rs, MYSQL_ASSOC);
						$sql = "INSERT INTO message_map(`id`,`from_id`,`to_id`,`to_groupid`,`parent_id`,`content_id`,`is_read`,`createtime`,`readtime`) 
								VALUES(null,'{$userid}','{$row["userid"]}','0','{$parent_id}','{$content_id}','N','".time()."','0')";
						$rs = mysql_query($sql);
						if($rs){
							$to_arr[] = 'true';
						}
					}
				}
				if(!empty($to_arr)){
        			$_SESSION['content_id'] = $content_id;
        			$_SESSION['parent_id'] = $parent_id;
        			$_SESSION['todo'] = $parent_id>0?'reply':'add';
        			echo "<script>location='http://".$_SERVER["SERVER_NAME"]."/model/email.php'</script>";
					exit;
				}else{
					echo "<script>alert('留言失败,请重试。');location='{$url}';</script>";
					exit;
				}
			}
			break;
		case 'setSolve':
			$id = intval($_GET['id']);
			$q = mysql_query("UPDATE message_content SET is_solve = 'Y',solvetime = '".time()."' WHERE id in (SELECT distinct(content_id) FROM `message_map` WHERE content_id = '{$id}' OR parent_id = '{$id}')");
			if($q){
				echo json_encode(array("result"=>"1"));
				exit();
			}else{
				echo json_encode(array("result"=>"-1"));
				exit();
			}
			break;
	}
}
?>