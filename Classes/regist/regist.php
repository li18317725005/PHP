<?php
session_start();
header('content-type:text/html;charset=utf-8');
include '../DB.class.php';
if ($_POST) {
	$vcode = isset($_POST['vcode'])?$_POST['vcode']:null;
	if ($vcode == null){
		echo '验证码不能为空';
		echo "<a href='regist.php'>重新注册</a>";
		exit;
	}else if($vcode != $_SESSION['vcode']){
		echo '验证码错误';
		echo "<a href='regist.php'>重新注册</a>";
		exit;
	}
	$username = isset($_POST['username'])?$_POST['username']:null;
	if ($username == null){
		echo '用户名不能为空';
		echo "<a href='regist.php'>重新注册</a>";
		exit;
	}
	$password = isset($_POST['password'])?$_POST['password']:null;
	if ($password == null){
		echo '密码不能为空';
		echo "<a href='regist.php'>重新注册</a>";
		exit;
	}
	$db  = new DB('localhost','root','root','mr');
	$arr = array(username => $username,
			     password => $password			    
	          ); 
	$db->insert('users',$arr);
}

?>
<center>用户注册</center><br/><br/>
<form action="" method="post">
用户名:<input type="text" name="username" /><br/><br/>
密&nbsp;码:<input type="password" name="password" /><br/><br/>
验证码:<input type="text" name="vcode" /><img src="vcode.php"/><br/><br/>
<input type="submit" value="注册" />
</form>