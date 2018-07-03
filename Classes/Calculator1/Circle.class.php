<?php
header('content-type:text/html;charset=utf-8');

class Circle extends Shape{
	public $r;
	public $name = "圆";
	function __construct($arr = array()){
		if (!empty($arr)) {
			$this->r = $arr['r'];
		}
	}
	function circum(){
		return 2 * pi() * $this->r;
	}
	function area(){
		return pi() * $this->r * $this->r;
	}
	function view(){
		echo "<form method='post' action=''>";
		echo $this->name . "半径是<input type='text' name='r' /><br/><br/>";
		echo "<input type='submit' value='计算' />";
		echo "</form>";
	}
}