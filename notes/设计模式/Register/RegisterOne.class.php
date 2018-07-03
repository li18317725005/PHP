<?php
class Register{
    protected static  $objects;

    //将对象注册到全局的树上
    function set($alias,$object){
        self::$objects[$alias]=$object;//将对象放到树上
    }

    static function get($name){
        return self::$objects[$name];//获取某个注册到树上的对象
    }

    function _unset($alias){
        unset(self::$objects[$alias]);//移除某个注册到树上的对象。
    }
}


//要经常使用的类
class One{
    public function test() {
        echo '哈哈';
    }
}

class Two{
    public function test() {
        echo '嘻嘻';
    }
}


//使用
$obj = new Register();
$obj->set('one', new One());
$obj->set('two', new Two());
// $obj->_unset('two');
Register::get('two')->test();

