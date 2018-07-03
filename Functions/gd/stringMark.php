<?php
header('content-type:text/html;charset=utf-8');
/**
 * 给图片添加水印文字
 * @param  str $filename,被添加水印文字的图片路径及即名称
 * @param  int $font,添加的水印文字字体大小,范围1~5,其中1最小,5最大
 * @param  str $s,水印文字的内容
 * @param  int $red,合成颜色中的原色红色,范围0~225
 * @param  int $green,合成颜色中的原色红色,范围0~225
 * @param  int $bule,合成颜色中的原色红色,范围0~225
 * @param  int $xDistance,水印文字与图片右边框的预留距离
 * @param  int $yDistance,水印文字与图片右边框的预留距离
 */
function stringMark($filename,$font,$s,$red,$green,$bule,$xDistance,$yDistance){
	//得到图片的宽  高  图片类型
	list($width,$height,$type) = getimagesize($filename);
	/*	
	$fileInfo = getimagesize($filename);
	$width  = $fileInfo[0];
	$height = $fileInfo[1];
	$type   = $fileInfo[2];
	*/
	//获取图片的资源
	$arr    = array(
				 1=>'gif',
			     2=>'jpeg',
			     3=>'png'
	          );
	$str_fun  = 'imagecreatefrom';
	$typeName = $arr[$type];
	$fun      = $str_fun.$typeName;
 	$img = $fun($filename);
 	//创建颜色
	$color = imagecolorallocate($img,$red,$green,$bule);
	//计算水印文字的宽  高
	$font_width  = imagefontwidth($font);
	$font_height = imagefontheight($font);
	//计算水印文字的起始坐标
	$x = $width - ($font_width * strlen($s) + $xDistance);
	$y = $height - ($font_height + $yDistance);
	imagestring($img,$font,$x,$y,$s,$color);
	//输出
	header("Content-Type:image/png");
	imagepng($img);
	
	//4、清理资源
	imagedestroy($img);
	
	
}
