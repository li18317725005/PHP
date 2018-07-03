<?php
header('content-type:text/html;charset=utf-8');

$subject = "这是网址http://www.baidu.com这是网址https://login.baidu.com这是网址ftp://image.sohu.com这是网址ftps://music.yahoo.com这是网址";
$pattern = "/(https?|ftps?):\/\/(\w+)\.(\w+)\.(com|cn|net|org)/i";
$replace = "<a href='\\1://\\2.\\3.\\4'>\\1://\\2.\\3.\\4</a>";
$result = preg_replace($pattern,$replace,$subject);
echo $result;