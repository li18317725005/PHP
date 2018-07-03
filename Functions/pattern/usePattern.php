<?php
header("Content-Type:text/html;charset=utf-8");
//验证电话号码合法性的函数
function matchPhone($phone){
	//对phone进行正则匹配，当匹配到结果match不为空时
	//phone是正确的电话号码，否则phone是不正确的电话号码
	$pattern = "/^1[3-8]\d{9}$/";
	preg_match($pattern,$phone,$match);
	if(!empty($match)){
		return true;
	}else{
		return false;
	}
}
//如何用正则表达式来匹配电话号码
if($_POST){
	$username = isset($_POST["username"])?trim($_POST["username"]):"";	
	if($username==""){
		echo "用户名不能为空";
		exit;
	}
	//对于用户输入的用户名（电话号码）的合法性进行判断
	//matchPhone($username) 当电话号码合法时 返回true
	//                      当电话号码不合法时 返回false
	$isRealPhone = matchPhone($username); 
	if($isRealPhone==false){
		echo "用户名码不合法";
		exit;
	}   
 
	$password = isset($_POST['password'])?trim($_POST['password']):"";
	if($password==""){
		echo "密码不得为空";
		exit;
	} 
	if(!(strlen($password)>=6&&strlen($password)<=8)){
		echo "密码长度不符";
		exit;
	}
	 
	//连接数据库	
	mysql_connect("localhost","root","");
	
	//选择数据库
	mysql_select_db("cms");
	
	//操作
	$query = "insert into user(username,password)
			  values 
			  ('".$username."','".$password."')";
	
	$result = mysql_query($query);
	
	if(mysql_affected_rows()>0){
		echo "注册成功";
	}else{
		echo "注册失败";
	}
	
	
	
	
}

?>
<form action="" method="post" >
用户名：<input type="text" name="username" /><span style="color:#ccc">用户名为电话号码</span><br/><br/> 
密码：<input type="password" name="password" /> <span style="color:#ccc">密码要求6~8位</span><br/><br/>
<input type="submit" value="注册" /> 
</form>









