<?php
/*// php内部支持

// SplSubject 接口，它代表着被观察的对象，
interface SplSubject{
    public function attach(SplObserver $observer);
    public function detach(SplObserver $observer);
    public function notify();
}

// SplObserver 接口，它代表着充当观察者的对象，
interface SplObserver{ 
    public function update(SplSubject $subject);
}*/

//具体主题
class Math implements SplSubject {
	private $_observers=array();
	public $len;

	public function __construct($len) {
		$this->len = $len;
	}

	//注册观察者
	public function attach(SplObserver $Observer) {
		$this->_observers[] = $Observer;
	}

	//删除观察者
	public function detach(SplObserver $observer) {
		$index = array_search($observer, $this->_observers);
		if ($index === false || !array_key_exists($index, $this->_observers)) {
			return false;
		}
		unset($this->_observers[$index]);
		return true;
	}

	//通知观察者
	public function notify(){
		foreach ($this->_observers as $observer) {
			$observer->update($this);
		}
	}

}

//观察者
class Length implements SplObserver {
	public function update(SplSubject $obj) {
		echo '正方形边长是: ' . $obj->len;
	}
}

class Area implements SplObserver {
	public function update(SplSubject $obj) {
		echo '<hr/>正方形面积是: ' . pow($obj->len, 2) * 6;
	}
}
 
class Bulk implements SplObserver {
	public function update(SplSubject $obj) {
		echo '<hr/>正方形体积是: ' . pow($obj->len, 3);
	}
}

//运行
$obj = new Math(2);
$obj->attach( new Length() );
$obj->attach( new Area() );
$obj->attach( new Bulk() );
$obj->notify();