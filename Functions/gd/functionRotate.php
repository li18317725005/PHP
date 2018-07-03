<?php
header('content-type:text/html;charset=utf-8');
/**
 * 图片旋转
 * @param  str $filename,旋转图片的路径及即名称
 * @param  int $angle,旋转的度数
 * @param  int $red,合成颜色中的原色红色,范围0~225
 * @param  int $green,合成颜色中的原色红色,范围0~225
 * @param  int $bule,合成颜色中的原色红色,范围0~225
 */
function rotate($filename,$angle,$red,$green,$bule){
	//获取图片资源
	list($width,$height,$type) = getimagesize($filename);
	$arr = array(
			1 => 'gif',
			2 => 'jpeg',
			3 => 'png'
	);
	$str_fun  = 'imagecreatefrom';
	$typeNmae = $arr[$type];
	$fun      = $str_fun.$typeNmae;
	$img      = $fun($filename);
	//创建背景色
	$bgcolor  = imagecolorallocate($img,$red,$green,$bule);
	$des_img  = imagerotate($img,$angle,$bgcolor);
	//展示
	header('content-type:image/png');
	imagepng($des_img);
	//释放资源
	imagedestroy($img);
}