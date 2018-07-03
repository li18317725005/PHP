<?php
//对象适配器使用的是委派

//目标角色
interface UserInterface {    
    function getUserInfo1();  //源角色中有
    function getUserInfo2();  //源角色中没有
}  


//源角色    
class User {    
    public $name;
    public $sex;

    function __construct($name, $sex) {    
        $this->name = $name;    
        $this->sex = $sex;
    }    

    public function getUserInfo1() {    
        return $this->name;    
    }

    public function test1($param) {
        return $param;
    }

    public function test2($param) {
        return $param;
    }

    public function test3($param) {
        return $param;
    }
}   


//类适配器角色 
class UserInfo implements UserInterface {    
    protected $user;    

    function __construct($user) {    
        $this->user = $user;
    }    

    public function getUserInfo1() {    
        return $this->user->getUserInfo1();    
    }

    public function getUserInfo2(){
        return $this->user->sex;
    }

    public function __call($function, $params) {
        if (is_callable(array($this->user, $function))) {  
            return $this->user->$function($params[0]);  
        }
    }

}   

$userInfo = new UserInfo(new User('李先生', '男'));    
echo $userInfo->test1(1);

