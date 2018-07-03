<?php
//删除目录下的内容
delDir("test");
function delDir($pathname){
	//判断目录是否存在
	if(file_exists($pathname)){
		if(is_file($pathname)){
			//如果给的目录就是个文件，则直接删除
			unlink($pathname);
			exit;
		}	
	}else{
		echo "文件不存在";
		exit;
	}
	
	//打开目录 
	$dir = opendir($pathname);
	//循环读取目录内容
	while($filename=readdir($dir)){
		//过滤掉"."和".."
		if($filename!="."&&$filename!=".."){
			//拼装目录
			$filename = $pathname."/".$filename;
			if(is_dir($filename)){
				//目录// test/a
				delDir($filename);
			}else{
				//文件
				unlink($filename);
			}
		}
	}
	
	closedir($dir);
	rmdir($pathname);
}
?>












