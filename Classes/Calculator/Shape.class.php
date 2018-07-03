<?php
header('content-type:text/html;charset=utf-8');

abstract class Shape{
	//计算周长
	abstract function circum();
	//计算面积
	abstract function area();
	//输出表单
	abstract function view();
}