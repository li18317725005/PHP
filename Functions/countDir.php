<?php
header("Content-Type:text/html;charset=utf-8");
//统计目录下的文件数和目录数
$file_num = 0; //统计文件个数
$dir_num = 0;  //统计目录个数
$pathname = "test";
countDir($pathname);
echo "文件数:".$file_num;
echo "<br/>";
echo "目录数:".$dir_num;

function countDir($pathname){
	global $file_num;
	global $dir_num;
	
	$dir = opendir($pathname);
	//循环读取目录下的内容
	while($filename=readdir($dir)){
		//过滤掉"."和".."
		if($filename!="."&&$filename!=".."){
			//拼装目录
			$filename =$pathname."/".$filename;
			if(is_dir($filename)){
				//是目录
				$dir_num = $dir_num+1;
				//处理子目录 test/a
                countDir($filename); 				
			}else{
				//是文件
				$file_num = $file_num+1;
				
			} 
		}
	}
	
	closedir($dir);
}

function countDir2($pathname){
	global $file_num;
	global $dir_num;
	//pathname = test/a
	
	$dir = opendir($pathname);
	//循环读取文件下的内容
	while($filename=readdir($dir)){
		//过滤掉"."和".."
		if($filename!="."&&$filename!=".."){
			//拼装目录
			$filename =$pathname."/".$filename;
			//判断是目录还是文件
			if(is_dir($filename)){
				//是目录  test/a/b
				//countDir3($filename);
				$dir_num = $dir_num+1;
			}else{
				//文件
				$file_num+=1;
			}
			
		}
	}
	
	
	closedir($dir);
	
}
?>













