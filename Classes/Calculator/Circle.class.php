<?php
header('content-type:text/html;charset=utf-8');

class Circle extends Shape{
	public $radius;
	public $name = '圆';
	
	function __construct($arr=array()){
		if(!empty($arr)){
			$this->radius = $arr['radius'];
		}
	}
	//计算周长=2πr
	function circum(){
		return 2 * pi() * $this->radius;
	}
	//计算面积=π * r的平方
	function area(){
		return pi() * $this->radius * $this->radius;
	}
	//输出表单
	function view(){
		echo "<form method='post' action=''>";
		echo $this->name."的半径:<input type='text' name='radius' /><br/><br/>";
		echo "<input type='submit' value='计算' />";
		echo "</form>";
	}
}