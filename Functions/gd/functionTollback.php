<?php
header('content-type:text/html;charset=utf-8');
/**
 * 图片沿y轴反转
 * @param  str $filename,想要反转的图片
 */
function rollback($filename){
	//获取反转前后的图片资源
	list($width,$height,$type) = getimagesize($filename);
	$des_img = imagecreatetruecolor($width,$height);
	$arr = array(
			1 => 'gif',
			2 => 'jpeg',
			3 => 'png'
	);
	$str      = 'imagecreatefrom';
	$trpeName = $arr[$type];
	$fun      = $str.$trpeName;
	$src_img  = $fun($filename);
	for ($i=0;$i<$width;$i++){
		$des_x = $width - ($i+1);
		$des_y = 0;
		$src_x = $i;
		$src_y = 0;
		$src_w = 1; //每次移动一个元素
		$src_h = $height;
		imagecopy($des_img, $src_img,
		$des_x, $des_y,
		$src_x, $src_y,
		$src_w, $src_h);
	}
	//展示
	header("Content-Type:image/png");
	imagepng($des_img);

	//清理资源
	imagedestroy($des_img);
	imagedestroy($src_img);

}