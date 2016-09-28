<?php
/**
 * @desc 本文件处理邮件发送
 * @author lzb
 * @since 2013年3月10日
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
/**
 * @param name 文件名
 */
if(!empty($_SESSION['content_id'])){
	$content_id = $_SESSION['content_id'];
	$jump_id = $_SESSION['todo']=='reply'&&$_SESSION['parent_id']>0?$_SESSION['parent_id']:$_SESSION['content_id'];
	$stat = mysql_fetch_assoc(mysql_query("SELECT count(*) AS count FROM `message_content` AS c LEFT JOIN message_map AS m ON c.id = m.content_id WHERE c.id = '{$content_id}'"));
	$page = intval($_GET['page'])>0?intval($_GET['page']):1;
	$pagesize = 1;
	$offset = ($page-1)*$pagesize;	
	if($page<=ceil(intval($stat['count'])/$pagesize)){
		$sql = "SELECT c.id,c.title,c.content,m.from_id,m.to_id,m.parent_id FROM `message_content` AS c LEFT JOIN message_map AS m ON c.id = m.content_id WHERE c.id = '{$content_id}' LIMIT {$offset},{$pagesize}";
		$row = mysql_fetch_assoc(mysql_query($sql));
		$from = mysql_fetch_assoc(mysql_query("SELECT username FROM user WHERE userid = '{$row["from_id"]}'"));
		$to = mysql_fetch_assoc(mysql_query("SELECT username,Email FROM user WHERE userid = '{$row["to_id"]}'"));
		$from_username = $from["username"];
		$to_username = $to["username"];
		$title = $row["title"];
		$type = $row["parent_id"] >0 ?'回复':'留言';
		$content = "<p>尊敬的{$to_username}，您好！</p><p>{$from["username"]}在映诺握手数据库后台中给你发送一条关于<b>{$title}</b>的新{$type},请注意查收！<br /><a href='http://database.theinno.org' target='_blank'>马上登录</a></p>";
		$email_class = new SmtpEmailEx();
		$result = Email_163::getInstance()->send(Email_163::MAIL_USER, $to["Email"], $title, $content);
		$percent = (round($page/intval($stat["count"]),2))*100;
		$page += 1;
		exit ("<meta http-equiv='refresh' content='3; url=http://".$_SERVER["SERVER_NAME"]."/model/email.php?page=".$page."' />留言成功，正在发送邮件，请稍候。。。（已完成{$percent}%）");
	}else{
		exit ("<meta http-equiv='refresh' content='3; url=http://".$_SERVER["SERVER_NAME"]."/messageShow.php?id=".$jump_id."' />邮件发送完成。（如出现没有收到邮件情况，请查看相关人员是否设置了邮箱）");
	}
}else{
	exit("邮件发送内容不存在。。。。");
}
?>