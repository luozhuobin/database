<?php

//�ַ�������ʼ�ַ�����ȡ����
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

//�ַ���ת�뺯��
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
//��ȡ�ű�����
function title_kind($k)
{
	switch($k)
	{
		case 1 : return '�绰�ű�'; break;
		case 2 : return '��ͨ����'; break;
		case 3 : return '��ѯӳŵ'; break;
		case 4 : return '������ѯ'; break;
		case 5 : return '��������'; break;
		case 6 : return '����ӳŵ'; break;
		default : return '����׼��';
	}
}
//��ȡ��ɫ
function get_color($color)
{
	switch($color)
	{
		case 1 : return '��'; break;
		case 2 : return '��'; break;
		default : return '��'; break;
	}
}
//��ȡ�Ա�
function get_sex($x)
{
	switch($x)
	{
		case 1 : return '����'; break;
		case 2 : return 'Ů��'; break;
		default : return 'δ֪'; break;
	}
}
//��ȡ״̬
function get_zt($x)
{
	switch($x)
	{
		case 1 : return '��ŭ'; break;
		case 2 : return 'ƽ��'; break;
		case 3 : return '��ɥ'; break;
		default : return 'δ֪'; break;
	}
}
//�ļ�����
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
//������ʾ��ͼƬ
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

//MYSQL��ҳ�����
class Fenye
{
	var $param;						//����
	var $pageSize;					//ÿҳ��ʾ�ĸ���
	var $dataCount;					//��ȡ��¼������
	var $pageCount;					//�ֶܷ���ҳ
	var $page;						//��ǰҳ
	var $total;						//��¼������
	
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
		echo '��' . $dataCount . '�� ' . $pageSize . '��/ҳ';
		echo '&nbsp;';
		if($page > 1){ echo "<a href='" . $url . "1'>��ҳ</a>";}else{ echo '��ҳ';}
		echo '&nbsp;';
		if($page != 1){ $up = $page - 1;echo "<a href='" . $url . $up . "'>��һҳ</a>";}else{ echo '��һҳ';}
		echo '&nbsp;';
		if($page != $pageCount){ $down = $page + 1;echo "<a href='" . $url . $down . "'>��һҳ</a>";}else{ echo '��һҳ';}
		echo '&nbsp;';
		if($page < $pageCount){ echo "<a href='" . $url . $pageCount . "'>βҳ</a>";}else{ echo 'βҳ';}
		echo '&nbsp;';
		echo "ҳ�Σ�<b><font color='#ff0000'>".$page."</font><font color='#474747'>/".$pageCount.'</font></b>ҳ ת��';
		echo "<select name='mySelect' size='1' onChange=\"javascript:pageTrans(this.value)\">";
		for($i = 1; $i <= $pageCount; $i++)
		{	
			if($page == $i){ echo "<option value=" . $i . " selected='selected'>��" . $i . "ҳ</option>";}
			else{ echo "<option value=" . $i . ">��" . $i . "ҳ</option>";}
		}
		echo '</select></form>';
	}
}
//�����ʼ�
function send_Email($name,$EmailAddr,$kind,$title,$username,$passwd,$smtp)
{
	if(empty($EmailAddr) or empty($title) or empty($username) or empty($passwd) or empty($smtp)){ exit;}

	$str = '';
	if($kind == 1){ $str = '���յ���1���µ����ԣ�';}else if($kind == 2){ $str = '�������������µĻظ���';}
	
	$body='<p>�װ���'.$name.'�û���</p><p>���ã�</p><p>ӳŵ�������ݿ���������'.$str.'</p>';
					
	$jmail = new COM('JMail.Message') or die('�޷�����Jmail���');
	$jmail->silent = true;		 //�����������
	$jmail->charset = 'gb2312';		 //�������Ļ�����
	$jmail->ContentType='text/html'; 	
	$jmail->From = $username; 			//�����ʼ��˺�
	$jmail->FromName = $title;
	$jmail->AddRecipient($EmailAddr);	 //�ʼ�������
	$jmail->Subject = 'ӳŵ�������ݿ�����������';
	$jmail->Body = $body; 
	$jmail->MailServerUserName = $username; 	//�����ʼ��˺�
	$jmail->MailServerPassword = $passwd; 		//�˻�������
	$jmail->Send($smtp);
}
/**
 * Ϊjs,css,img�Ⱦ�̬�ļ���Ӱ汾��
 * @param $url ��̬�ļ�·��
 * @param string 
 * @author lzb
 * @since 2013-1-18
 */
function autoVer($url){
	$ver = mb_substr(md5(filemtime($_SERVER['DOCUMENT_ROOT'].$url)),0,16,'UTF-8');
	echo $url."?version=".$ver;
}
?>