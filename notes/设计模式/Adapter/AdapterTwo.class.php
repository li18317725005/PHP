<?php
//类适配器使用的是继承

//目标角色
interface UserInterface{
	function getUserInfo1();  //源角色中有
    function getUserInfo2();  //源角色中没有
}


//源角色  
class User {
	public $username;
	public $sex;

	public function __construct($username, $sex) {
		$this->username = $username;
		$this->sex = $sex;
	}

	public function getUserInfo1() {
		return $this->username;
	}
}


//类适配器角色 
class UserInfo extends User implements UserInterface {
	public function  getUserInfo2() {
		return $this->sex;
	}
}

$userInfo = new UserInfo('李先生', '男');
echo $userInfo->getUserInfo1();
echo $userInfo->getUserInfo2();
