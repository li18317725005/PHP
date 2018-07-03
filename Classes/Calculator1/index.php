<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>图形计算器</title>
	</head>
	<body>
		<h1>图形计算器</h1>
<h2>图形计算器</h2>
<p><a href="index.php?action=Rectangle">矩形</a> | <a href="index.php?action=Triangle">三角形</a> | <a href="index.php?action=Circle">圆</a></p>
	<?php 
		function __autoload($className){
			include $className . '.class.php';
		}
		$cname = isset($_GET['action'])?$_GET['action']:"";
		if ($cname != ""){
			$obj = new $cname;
			$obj->view();
			if ($_POST) {
				$obj = new $cname($_POST);
				echo $obj->name , "的周长是:" , $obj->circum();
				echo $obj->name , "的面积是:" , $obj->area();
			}
		}else{
			echo "<br/><br/>请选择要计算的图形";
		}
		
	?>
	</body>
</html>