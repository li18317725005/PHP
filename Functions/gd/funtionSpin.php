<?php
header('content-type:text/html;charset=utf-8');
/**
 * 图片沿x轴反转
 * @param  str $filename,想要反转的图片
 */
function spin($filename){
	//获取原图和旋转后的图片资源
	list($width,$height,$type) = getimagesize($filename);
	$des_img = imagecreatetruecolor($width, $height);
	$arr     = array(
					1=>'gif',
					2=>'jpeg',
					3=>'png'
			   );
	$str_fun      = 'imagecreatefrom';
	$src_typeName = $arr[$type];
	$src_fun      = $str_fun.$src_typeName;
	$src_img      = $src_fun($filename);
	for($i = 0;$i < $height;$i ++){
		$des_x = 0;
		$des_y = $height - ($i + 1);
		$src_x = 0;
		$src_y = $i;
		$src_w= $width;
		$src_h = 1;
	imagecopy($des_img,$src_img, 
			  $des_x,$des_y, 
			  $src_x,$src_y,
			  $src_w,$src_h);
	}
	//展示
	header('content-type:image/png');
	imagepng($des_img);
	//释放资源
	imagedestroy($des_img);
	imagedestroy($src_img);
}