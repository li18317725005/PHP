<?php
header('content-type:text/html;charset=utf-8');
/**
 * 将一个小图片作为一个水印图片添加到一个大图片上
 * @param  str $des_filename,大图片路径及名称
 * @param  str $src_filename,小图片路径及名称
 * @param  int $src_x,小图片开始剪切的坐标x,一般为0
 * @param  int $src_y,小图片开始剪切的坐标y,一般为0
 * @param  int $xDistance,水印图片(小图片)与图片右边框的预留距离
 * @param  int $yDistance,水印图片(小图片)与图片右边框的预留距离
 */
function waterMark($des_filename,$src_filename,$src_x,$src_y,$xDistance,$yDistance){
	//获取大图片和小图片的宽  高  类型
 	list($des_width,$des_height,$des_type) = getimagesize($des_filename);
	list($src_width,$src_heighr,$src_type) = getimagesize($src_filename);
	//获取大图片和小图片的资源
	$arr = array(
			1 => 'gif',
	        2 => 'jpeg',
			3 => 'png'
	);
	$str_fun = 'imagecreatefrom';
	$des_typeName = $arr[$des_type];
	$src_typeName = $arr[$src_type];
	$fun_des  = $str_fun.$des_typeName;
	$fun_src  = $str_fun.$src_typeName;
	$des_img  = $fun_des($des_filename);
	$src_img  = $fun_src($src_filename);
	//得到小图片贴在大图片上的坐标
	$des_x = $des_width - ($src_width + $xDistance);
	$des_y = $des_height - ($src_heighr + $yDistance);
	//得到小图片的宽  高
	$src_w = $src_width;
	$src_h = $src_heighr;
	//给图片添加水印图片
	imagecopy($des_img,$src_img,
			  $des_x,$des_y,$src_x,$src_y,
			  $src_w,$src_h);
	//展示
	header('content-type:image/png');
	imagepng($des_img);
	//释放资源
	imagedestroy($des_img);
	imagedestroy($src_img);
}