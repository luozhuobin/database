<?
session_start();
function getRandNumber($fMin, $fMax)
{ 
	srand((double)microtime()*1000000);
	$fLen = "%0".strlen($fMax). "d";
	Return sprintf($fLen, rand($fMin,$fMax));
} 
$str=getRandNumber(1000,9999);

$_SESSION["msgcheckcode"]=$str;

$width = 50; //��֤��ͼƬ�Ŀ��
$height = 20; //��֤��ͼƬ�ĸ߶�
@header("Content-Type:image/jpeg");

$im=imagecreate($width,$height);	
$back=imagecolorallocate($im,255,255,255);	//����ɫ
/*$pix=imagecolorallocate($im,34,97,227);		//ģ������ɫ
$font=imagecolorallocate($im,34,97,227);	//����ɫ*/
$gray=imagecolorallocate($im,153,153,153);		//����ɫ

$pix=imagecolorallocate($im,0,0,0);		//ģ������ɫ
$font=imagecolorallocate($im,0,0,0);		//����ɫ


mt_srand();
for($i=0;$i<100;$i++)
{
	imagesetpixel($im,mt_rand(0,$width),mt_rand(0,$height),$pix);	//��ģ�����õĵ�
}
imagestring($im,5,7,2,$str, $font);
imagerectangle($im,0,0,$width-1,$height-1,$gray);
imagejpeg($im);
imagedestroy($im);



?>