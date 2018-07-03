<?php

class VCode{
	public $img;
	public $width;
	public $height;
	public $length;
	public $word;
	
	function __construct($width,$height,$lenght){
		$this->width = $width;
		$this->height = $height;
		$this->length = $lenght;
		$this->word = $this->getWord();
	}
	//统一出口
	function outImage(){
		$this->bg();
		$this->printWord();
		$this->disturb();
		$this->printImage();
	}
	//创建画布
	function bg(){
		$this->img = imagecreatetruecolor($this->width,$this->height);
		$bgcolor   = imagecolorallocate($this->img,rand(200,225),rand(200,225),rand(200,225));
		imagefill($this->img,0,0,$bgcolor);
	}
	//写字
	function getWord(){
		$char = '1234567890';
		$code = '';
		for($i=0;$i<$this->length;$i++){
			$code .= substr($char,rand(0,strlen($char)-1),1);
		}
		return $code;
	}
	function printWord(){
		for($i=0;$i<$this->length;$i++){
			$color = imagecolorallocate($this->img,rand(0,100),rand(0,100),rand(0,100));
			$font  = rand(15,20);
			$angle = rand(-30,30);
			$x = ($this->width/$this->length) * $i + 5;
			$y = rand(25,35);
			imagettftext($this->img,$font,$angle,$x,$y,$color,'songti.ttc',substr($this->word,$i,1));
		}
	}
	//干扰
	function disturb(){
		$x = $this->width - 1;
		$y = $this->height - 1;
		for($i=0;$i<=100;$i++){
			$color = imagecolorallocate($this->img,rand(100,200),rand(100,200),rand(100,200));
			imagesetpixel($this->img,rand(1,$x),rand(1,$y),$color);
		}
		for($n=0;$n<=10;$n++){
			$color = imagecolorallocate($this->img,rand(100,200),rand(100,200),rand(100,200));
			imageline($this->img,rand(1,$x),rand(1,$y),rand(1,$x),rand(1,$y),$color);
		}
	}
	//展示
	function printImage(){
		header('content-type:image/png');
		imagepng($this->img);
	}
	//释放画布
	function __destruct(){
		imagedestroy($this->img);
	}
	
}
