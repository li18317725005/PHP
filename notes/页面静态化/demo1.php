<?  
ob_start();  
echo "<html>".  
"<head>".  
"<title>PHP网站静态化教程</title>".  
"</head>".  
"<body>欢迎访问PHP网站开发教程网www.leapsoul.cn，本文主要介绍PHP网站页面静态化的方法</body>".  
"</html>";  
$out1 = ob_get_contents();  
ob_end_clean();  
$fp = fopen("leapsoulcn.html","w");  
if(!$fp)  
{  
echo "System Error";  
exit();  
}  
else  
{  
fwrite($fp,$out1);  
fclose($fp);  
echo "Success";  
}  
?>  