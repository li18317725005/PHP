<?php
//拷贝目录
$pathname = "test";
$despathname = "test_new";
copyDir($pathname,$despathname);
function copyDir($pathname,$despathname){
	//判断 $despathname
	if(file_exists($despathname)){
		if(is_file($despathname)){
			echo "目标目录是文件，无法拷贝";
			exit;
		}
	}else{
		//目标目录不存在，创建目标目录
		mkdir($despathname);
	}
	
	// 将原目录下的内容拷贝到目标目录
	$dir = opendir($pathname);
	//循环读取目录内容 并拷贝
	while($filename = readdir($dir)){
		//过滤掉"."和".."
		if($filename!="."&&$filename!=".."){
			//拼装目录 /1.php
			//原目录
			$srcfilename = $pathname."/".$filename;
			//srcfilename = "test/1.php"			
			//目标目录
			$desfilename = $despathname."/".$filename;
			//desfilename = "test_new/1.php					
			
			if(is_dir($srcfilename)){
				//test/a
				copyDir($srcfilename,$desfilename);
				
			}else{
				//如果是文件
				copy($srcfilename,$desfilename);
			}
		}
		
	}
	
	
	closedir($dir);
	
}



?>







