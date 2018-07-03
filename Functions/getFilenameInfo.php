<?php

/* * 
 *  获取主文件名和扩展名
 *  @param  string $filename,文件的名称
 *  @return string $mainame,主文件名
 *  @returnstring $extension,文件扩展名  
 */
function getFilenameInfo($filename){
	
	$extension = substr($filename,strrpos($filename, '.')+1);
	
	$mainame   = substr($filename,0,strrpos($filename, '.'));
	
	return array($mainame,$extension);
	
}

list($main,$extension) = getFilenameInfo('$filename');

echo '文件的主文件名是:'  , $main , ',扩展名是:' , $extension , '<br/>';


