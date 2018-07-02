<?php
/**
 * 短信验证码入口接口
 * User: haijaing
 * Date: 2017/04/14
 * Time: 19:00
 */
namespace NoteMessage\Controller;
use Think\Controller;
vendor('ChuanglanSmsApi');
//此处继承HomebaseController为了适应ThinkCMF这个框架
class IndexController extends Controller
{
	//发送短信
	public function index(){
		$phone = $_POST['phone'];
		$checkResult = $this->sendBeforeCheck($phone);
		if ($checkResult !== true){
			echo json_encode($checkResult);die();
		}
		$clapi  = new \ChuanglanSmsApi();
		$code = rand(100000,999999);
		$result = $clapi->sendSMS("$phone", '您好，您的验证码是'.$code,'true');
		$result = $clapi->execResult($result);
		if($result[2]){
			$_SESSION['get_note_message'][$phone] = $code;
		}else{
			session($phone, null);
			echo json_encode('出现异常！');
		}
	}

	//发送验证码前进行判断
	public function sendBeforeCheck($phone){
		//判断提交时间间隔
		$time = time();
		if (!$_SESSION['get_note_time'][$phone]){
			$_SESSION['get_note_time'][$phone] = $time;
		}else{
			$intervalTime = $time - $_SESSION['get_note_time'][$phone]; //用户获取验证码的间隔时间
			if ($intervalTime < 60){
				return '操作频繁！';die();
			}else{
				$_SESSION['get_note_time'][$phone] = $time;
			}
		}
		//判断今日发送验证码是否超过10次
		$admin_uuid = session('admin_uuid');
		$user_uuid = session('user_uuid');
		$userInfo = D('Common/UserSelect')->getUserData($admin_uuid, $user_uuid);
		$date = date('Y-m-d', time());
		if ($date == $userInfo['send_time']){ //最后一次发送短信在今天
			if ($userInfo['message_num'] >= 10){ //今日请求次数大于10
				unset($_SESSION['get_note_time'][$phone]);
				return '今日请求次数过多！';die();
			}else{
				D('User')->setIncMessageNum($user_uuid);
			}
		}else{
			D('User')->saveMessageInfo($user_uuid, $date);
		}
		return true;
	}


	//检验验证码
	public function checkCode($phone, $code){
		$checkCode = $_SESSION['get_note_message'][$phone]; //session中存的短信验证码
		if ($checkCode){
			if ($code == $checkCode){
				$msg = true;
				unset($_SESSION['get_note_message'][$phone]);
				unset($_SESSION['get_note_time'][$phone]);
			}else{
				$msg = '短信验证码错误！';
			}
		}else{
			$msg = '请重新获取验证码！';
		}
		return $msg;
	}
}