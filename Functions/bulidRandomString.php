<?php

/**
 * 获取随机字符 
 * @param  int $length,随机字符的长度,默认为4
 * @param  int $type,随机字符的类型,0表示为数字,1表示为字母,其他表示为混合
 * @return string
 */
function buildRandomString($length=4,$type=0){
	if($type == 0){
		$str =  str_repeat('0123456789',5);
	} else if($type == 1){
		$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	} else {
		$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
	$char = substr(str_shuffle($str), 0,$length);
	return $char;
}


/**
 * 获取文件扩展名
 * @param  string $filename,文件的名称
 * @return string
 */
function getExtension($filename){
	$extension = strtolower(substr($filename,strrpos($filename,'.')+1));
	return $extension;
}
