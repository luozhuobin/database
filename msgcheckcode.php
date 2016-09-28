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

$width = 50; //验证码图片的宽度
$height = 20; //验证码图片的高度
@header("Content-Type:image/jpeg");

$im=imagecreate($width,$height);	
$back=imagecolorallocate($im,255,255,255);	//背景色
/*$pix=imagecolorallocate($im,34,97,227);		//模糊点颜色
$font=imagecolorallocate($im,34,97,227);	//字体色*/
$gray=imagecolorallocate($im,153,153,153);		//字体色

$pix=imagecolorallocate($im,0,0,0);		//模糊点颜色
$font=imagecolorallocate($im,0,0,0);		//字体色


mt_srand();
for($i=0;$i<100;$i++)
{
	imagesetpixel($im,mt_rand(0,$width),mt_rand(0,$height),$pix);	//绘模糊作用的点
}
imagestring($im,5,7,2,$str, $font);
imagerectangle($im,0,0,$width-1,$height-1,$gray);
imagejpeg($im);
imagedestroy($im);



?>