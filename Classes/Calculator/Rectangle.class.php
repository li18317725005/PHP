<?php

class Rectangle extends Shape{
	public $width;
	public $height;
	public $name = '矩形';
	
	function __construct($arr=array()){
		if(!empty($arr)){
			$this->width = $arr['width'];
			$this->height = $arr['height'];
		}
	}
	//计算周长=(长+宽)*2
 	function circum(){
 		return ($this->width + $this->height) * 2;
 	}
	//计算面积=长*宽
	function area(){
		return $this->width * $this->height;
	}
	//输出表单
	function view(){
		echo "<form method='post' action=''>";
		echo $this->name."的宽:<input type='text' name='width' /><br/><br/>";
		echo $this->name."的高:<input type='text' name='height' /><br/><br/>";
		echo "<input type='submit' value='计算' />";
		echo "</form>";
	}
}