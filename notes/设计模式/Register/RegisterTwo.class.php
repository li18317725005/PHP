<?php
//单例模式
class Single {
	public $username;
	private static $obj = null;

	private function __construct($username) {
		$this->username = $username;
	}

	public static function getObj($username) {
		if (self::$obj instanceof self) {
			return self::$obj;
		}
		self::$obj = new self($username);
		return self::$obj;
	}

	public function ceshi() {
		return $this->username;
	}
}

//注册(树)模式
class Register {
	protected static $objects;

	public static function set($key, $value) {
		self::$objects[$key] = $value;
	}

	public static function get($key) {
		return self::$objects[$key];
	}

	public static function _unset($key) {
		unset(self::$objects[$key]);
	}
}

//使用
Register::set('single', Single::getObj('李先生'));
echo Register::get('single')->ceshi();
