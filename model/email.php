<?php
/**
 * @desc ���ļ������ʼ�����
 * @author lzb
 * @since 2013��3��10��
 */
require('../libs/config.inc.php');
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
/**
 * @param name �ļ���
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
		$type = $row["parent_id"] >0 ?'�ظ�':'����';
		$content = "<p>�𾴵�{$to_username}�����ã�</p><p>{$from["username"]}��ӳŵ�������ݿ��̨�и��㷢��һ������<b>{$title}</b>����{$type},��ע����գ�<br /><a href='http://database.theinno.org' target='_blank'>���ϵ�¼</a></p>";
		$email_class = new SmtpEmailEx();
		$result = Email_163::getInstance()->send(Email_163::MAIL_USER, $to["Email"], $title, $content);
		$percent = (round($page/intval($stat["count"]),2))*100;
		$page += 1;
		exit ("<meta http-equiv='refresh' content='3; url=http://".$_SERVER["SERVER_NAME"]."/model/email.php?page=".$page."' />���Գɹ������ڷ����ʼ������Ժ򡣡����������{$percent}%��");
	}else{
		exit ("<meta http-equiv='refresh' content='3; url=http://".$_SERVER["SERVER_NAME"]."/messageShow.php?id=".$jump_id."' />�ʼ�������ɡ��������û���յ��ʼ��������鿴�����Ա�Ƿ����������䣩");
	}
}else{
	exit("�ʼ��������ݲ����ڡ�������");
}
?>