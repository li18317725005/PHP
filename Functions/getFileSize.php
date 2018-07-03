<?php
header('content-type:text/html;charset=utf-8');

function getFileSize($filename){
	$size = filesize($filename);
	$dw   = '';
	if($size >= pow(2,40)){
		$size = $size/pow(2,40);
		$dw   = 'TB';
	}else if($size >= pow(2,30)){
		$size = $size/pow(2,30);
		$dw   = 'GB';
	}else if($size >= pow(2,20)){
		$size = $size/pow(2,20);
		$dw   = 'MB';
	}else if($size >= pow(2,10)){
		$size = $size/pow(2,10);
		$dw   = 'KB';
	}else{
		$dw   = 'bytes';
	}
	$size = rand($size,2);
	return $size . $dw;
}
