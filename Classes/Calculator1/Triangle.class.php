<?php
header('content-type:text/html;charset=utf-8');

class Triangle extends Shape{
	public  $side1;
	public $side2;
	public $side3;
	public $name = "三角形";
	function __construct($arr = array()){
		if(!empty($arr)){
			$this->side1 = $arr['side1'];
			$this->side2 = $arr['side2'];
			$this->side3 = $arr['side3'];
		}
	}
	function circum(){
		return $this->side1 + $this->side2 + $this->side3;
	}
	
	function area(){
		$p = ($this->side1 + $this->side2 + $this->side3) / 2;
		return sqrt($p * ($p - $this->side1) * ($p - $this->side1) * ($p - $this->side1));
	}
	function view(){
		echo "<form method='post' action=''>";
		echo $this->name . "的边长1是<input type='text' name='side1' /><br/><br/>";
		echo $this->name . "的边长2是<input type='text' name='side2' /><br/><br/>";
		echo $this->name . "的边长3是<input type='text' name='side3' /><br/><br/>";
		echo "<input type='submit' value='计算' />";
		echo "</form>";
	}
}