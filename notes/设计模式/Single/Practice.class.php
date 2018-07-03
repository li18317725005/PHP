<?php
class Single {
	public $username;
	private static $obj = null;

	private function __construct($username){
		$this->username = $username;
	}

	public static function getObj($username){
		if (self::$obj instanceof self){
			return self::obj;
		}
		self::$obj = new self($username);
		return self::$obj;
	}

	public function run(){
		return $this->username;
	}
}

//应用
echo Single::getObj('李先生')->run();