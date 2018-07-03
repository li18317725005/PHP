<?php
interface Rule {
	public function run();
}

class One implements Rule {
	public function run() {
		echo '嘻嘻';
	}
}

class Two implements Rule {
	public function run() {
		echo '哈哈';
	}
}

class Three implements Rule {
	public function run() {
		echo '嘿嘿';
	}
}


class MyFactory {
	public static function getObj($class) {
		switch ($class) {
			case 'One':
				return new One();
				break;
			case 'Two':
				return new Two();
				break;
			case 'Three':
				return new Three();
				break;
		}
	}
}

//使用
MyFactory::getObj('Three')->run();
