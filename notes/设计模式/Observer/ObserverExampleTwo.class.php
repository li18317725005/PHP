<?php
/**
 * 应用场景
 * 用户付款成功后,给用户递个小纸条(发送短信/系统消息/email)
 */

//用户主题类=========================================================
class User implements SplSubject {
	private $id;
	private $username;
	private $email;
	private $phone;
	public $_observers = array();

	public function __construct ($id, $username, $email, $phone){
		$this->id = $id;
		$this->username = $username;
		$this->email = $email;
		$this->phone = $phone;
		$this->_observers = new SplObjectStorage();
	}

	//注册观察者
	public function attach(SplObserver $observer) {
		$this->_observers->attach($observer);
	}

	//删除观察者
	public function detach(SplObserver $observer) {
		$this->_observers->detach($observer);
	}

	//通知观察者
	public function notify() {
		$userInfo = array (
				'id' 		=> $this->id,
				'username'  => $this->username,
				'email'		=> $this->email,
				'phone'		=> $this->phone,
			);
		foreach ($this->_observers as $observer) {
			$observer->update($this, $userInfo);
		}
	}
}


//观察者==========================================================
//发送短信
class NoteMessage implements SplObserver {
	public function update (SplSubject $subject){
		if (func_num_args() == 2){
			$userInfo = func_get_arg(1);
		}
		// print_r($userInfo);
		// echo "<pre>";
		// print_r($subject->_observers);
		// echo "</pre>";
		echo '短信通知: ' . $userInfo['username'] . '您已付款<br/>';
	}
}

//发送email
class Email implements SplObserver {
	public function update (SplSubject $subject){
		if (func_num_args() == 2){
			$userInfo = func_get_arg(1);
		}
		// print_r($userInfo);
		echo '邮件通知: ' . $userInfo['username'] . '您已付款<br/>';
	}
}

//发送消息
class News implements SplObserver {
	public function update (SplSubject $subject){
		if (func_num_args() == 2){
			$userInfo = func_get_arg(1);
		}
		// print_r($userInfo);
		echo '消息通知: ' . $userInfo['username'] . '您已付款<br/>';
	}
}

//微信通知
class Wechat implements SplObserver {
	public function update (SplSubject $subject){
		if (func_num_args() == 2){
			$userInfo = func_get_arg(1);
		}
		// print_r($userInfo);
		echo '微信通知: ' . $userInfo['username'] . '您已付款<br/>';
	}
}

//应用
$user = new User(1, '李先生', '1191108454@qq.com', '18317725005');
$user->attach(new NoteMessage());
$user->attach(new Email());
$user->attach(new News());
$wechat = new Wechat();
$user->attach($wechat);
// $user->detach($wechat);
$user->notify();