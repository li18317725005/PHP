<?php
header('content-type:text/html;charset=utf-8');

class Rectangle extends  Shape{
	public $width;
	public $height;
	public $name = "矩形";
	function __construct($arr = array()){
		if(!empty($arr)){
			$this->width = $arr['width'];
			$this->height = $arr['height'];
		}
	}
	function circum(){
		return ($this->width + $this->height) * 2;
	}
	function area(){
		return $this->width * $this->height;
	}
	function view(){
		echo "<form method='post' action=''>";
		echo $this->name . "的长是<input type='text' name='width' /><br/><br/>";
		echo $this->name . "的宽是<input type='text' name='height'/><br/><br/>";
		echo "<input type='submit' value='计算' />";
		echo "</form>";
	}
}

