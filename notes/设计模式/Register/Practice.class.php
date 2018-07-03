<?php
//单例模式
class Single {
	public $param1;
	public $param2;
	private static $obj=null;

	private function __construct($param1, $param2) {
		$this->param1 = $param1;
		$this->param2 = $param2;
	}

	public function getSum(){
		return $this->param1 + $this->param2;
	}

	public static function getObj($param1, $param2) {
		if (self::$obj instanceof self) {
			return self::$obj;
		}
		self::$obj = new self($param1, $param2);
		return self::$obj;
	}
}


//工厂模式
class MyFactory {
	public static function getObj($class, $params) {
		switch ($class) {
			case 'single':
				return Single::getObj($params[0], $params[1]);
				break;
		}
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


//应用
$params = [1,2];
Register::set('single', MyFactory::getObj('single', $params));
echo Register::get('single')->getSum();
