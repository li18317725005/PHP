<?php
session_start();
header('content-type:text/html;charset=utf-8');
include '../VCode.class.php';

$v = new VCode(80,40,4);
$_SESSION['vcode'] = $v->word;
$v->outImage();