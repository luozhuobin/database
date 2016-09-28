<?php

//字符串，开始字符，截取长度
function mid_str($str,$start,$len){
$tmpstr = '';
$strlen = $start + $len;
for($i = 0; $i < $strlen; $i++){
   if(ord(substr($str, $i, 1)) > 0xa0){
    $tmpstr .= substr($str, $i, 2);
    $i++;
   }else
    $tmpstr .= substr($str, $i, 1);
}
return $tmpstr;
}

//字符串转码函数
function saddslashes($string)
{
	if(is_array($string)){
		foreach($string as $key => $val){ $string[$key] = saddslashes($val);}
	}else{
		$magic_quote = get_magic_quotes_gpc();
		if($magic_quote==0){ $string = addslashes(htmlspecialchars($string));}else{ $string = htmlspecialchars($string);}
		$arr1 = array('/include/i','/require/i','/union/i','/script/i','/iframe/i','/0x/i');
		$arr2 = array('in-clude','re-quire','un-ion','sc-ript','ifr-ame','');
		$string = preg_replace($arr1,$arr2,$string);
	}
	return $string;
}
//获取脚本类型
function title_kind($k)
{
	switch($k)
	{
		case 1 : return '电话脚本'; break;
		case 2 : return '沟通问题'; break;
		case 3 : return '咨询映诺'; break;
		case 4 : return '申诉咨询'; break;
		case 5 : return '心理适用'; break;
		case 6 : return '求助映诺'; break;
		default : return '工作准备';
	}
}
//获取颜色
function get_color($color)
{
	switch($color)
	{
		case 1 : return '红'; break;
		case 2 : return '黄'; break;
		default : return '绿'; break;
	}
}
//获取性别
function get_sex($x)
{
	switch($x)
	{
		case 1 : return '男性'; break;
		case 2 : return '女性'; break;
		default : return '未知'; break;
	}
}
//获取状态
function get_zt($x)
{
	switch($x)
	{
		case 1 : return '愤怒'; break;
		case 2 : return '平静'; break;
		case 3 : return '沮丧'; break;
		default : return '未知'; break;
	}
}
//文件类型
function getfiletype($type)
{
	switch($type)
	{
		case 'pdf' :
			return '1';break;
		case 'doc' :
			return '2';break;
		case 'docx' :
			return '2';break;
		case 'xls' :
			return '3';break;
		case 'xlsx' :
			return '3';break;
		case 'rar' :
			return '4';break;
		case 'zip' :
			return '4';break;
		case 'jpg' :
			return '5';break;
	}
}
//附件显示的图片
function showfilepic($k)
{
	switch($k)
	{
		case '1' :
			return 'images/pdf.jpg';break;
		case '2' :
			return 'images/doc.jpg';break;
		case '3' :
			return 'images/xls.jpg';break;
		case '4' :
			return 'images/rar.ico';break;
		case '5' :
			return 'images/jpg.jpg';break;
	}
}

//MYSQL分页类程序
class Fenye
{
	var $param;						//参数
	var $pageSize;					//每页显示的个数
	var $dataCount;					//获取记录的总数
	var $pageCount;					//能分多少页
	var $page;						//当前页
	var $total;						//记录的总数
	
	function __construct($param, $pageSize, $total)
	{ 
		$this->param = $param;
		$this->pageSize = $pageSize;
		$this->dataCount = intval($total);	
		$this->pageCount = $this->dataCount % $this->pageSize == 0 ? $this->dataCount / $this->pageSize : intval($this->dataCount / $this->pageSize) + 1;
		$this->page = isset($_GET['page']) ? $_GET['page'] : 1;	
		$this->page += 0;
		if($this->page > $this->pageCount){ $this->page = $this->pageCount;}
	}
	
	function fenyeFoot()
	{
		$param = $this->param;
		$pageSize = $this->pageSize;
		$dataCount = $this->dataCount;
		$pageCount = $this->pageCount;
		$page = $this->page;
		
		$url = '?' . $param . '&page=';
		
		echo "<form name='fenyeForm' method='post' action=''>";
		echo '&nbsp;&nbsp;';
		echo '共' . $dataCount . '条 ' . $pageSize . '条/页';
		echo '&nbsp;';
		if($page > 1){ echo "<a href='" . $url . "1'>首页</a>";}else{ echo '首页';}
		echo '&nbsp;';
		if($page != 1){ $up = $page - 1;echo "<a href='" . $url . $up . "'>上一页</a>";}else{ echo '上一页';}
		echo '&nbsp;';
		if($page != $pageCount){ $down = $page + 1;echo "<a href='" . $url . $down . "'>下一页</a>";}else{ echo '下一页';}
		echo '&nbsp;';
		if($page < $pageCount){ echo "<a href='" . $url . $pageCount . "'>尾页</a>";}else{ echo '尾页';}
		echo '&nbsp;';
		echo "页次：<b><font color='#ff0000'>".$page."</font><font color='#474747'>/".$pageCount.'</font></b>页 转：';
		echo "<select name='mySelect' size='1' onChange=\"javascript:pageTrans(this.value)\">";
		for($i = 1; $i <= $pageCount; $i++)
		{	
			if($page == $i){ echo "<option value=" . $i . " selected='selected'>第" . $i . "页</option>";}
			else{ echo "<option value=" . $i . ">第" . $i . "页</option>";}
		}
		echo '</select></form>';
	}
}
//发送邮件
function send_Email($name,$EmailAddr,$kind,$title,$username,$passwd,$smtp)
{
	if(empty($EmailAddr) or empty($title) or empty($username) or empty($passwd) or empty($smtp)){ exit;}

	$str = '';
	if($kind == 1){ $str = '您收到了1条新的留言！';}else if($kind == 2){ $str = '您的留言有了新的回复！';}
	
	$body='<p>亲爱的'.$name.'用户：</p><p>您好！</p><p>映诺热线数据库提醒您，'.$str.'</p>';
					
	$jmail = new COM('JMail.Message') or die('无法调用Jmail组件');
	$jmail->silent = true;		 //屏蔽例外错误
	$jmail->charset = 'gb2312';		 //否则中文会乱码
	$jmail->ContentType='text/html'; 	
	$jmail->From = $username; 			//发信邮件账号
	$jmail->FromName = $title;
	$jmail->AddRecipient($EmailAddr);	 //邮件接受者
	$jmail->Subject = '映诺热线数据库新留言提醒';
	$jmail->Body = $body; 
	$jmail->MailServerUserName = $username; 	//发信邮件账号
	$jmail->MailServerPassword = $passwd; 		//账户的密码
	$jmail->Send($smtp);
}
/**
 * 为js,css,img等静态文件添加版本号
 * @param $url 静态文件路径
 * @param string 
 * @author lzb
 * @since 2013-1-18
 */
function autoVer($url){
	$ver = mb_substr(md5(filemtime($_SERVER['DOCUMENT_ROOT'].$url)),0,16,'UTF-8');
	echo $url."?version=".$ver;
}
?>