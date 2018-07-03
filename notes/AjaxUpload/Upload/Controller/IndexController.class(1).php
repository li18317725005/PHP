<?php
namespace Upload\Controller;
use Think\Controller;
class IndexController extends Controller 
{
    public function index(){
       	$this->display();
    }

    //执行添加动作
    public function doAdd(){
    	echo "<pre>";
    	print_r($_POST);
    	print_r($_FILES);
    	echo "</pre>";
    	die();
    	//处理文件上传
    	$upload = new \Think\Upload();// 实例化上传类 
		$upload->maxSize = 3145728 ;  // 设置附件上传大小 
		$upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型 
		$upload->rootPath = './Upload/'; // 设置附件上传根目录 
		$upload->savePath = ''; // 设置附件上传（子）目录
		$result = $upload->upload();
		// $info  = $upload->uploadOne($_FILES['img']);
		// $info2 = $upload->upload(array('pic'=>$_FILES['pic']));
		// $info  = uploadImgOne($_FILES['img'], './Upload/');
    	// $info2 = uploadImg('./Upload/', true, array('pic'=>$_FILES['pic']));
		echo "<pre>";
		print_r($result);
		// print_r($info);
		// print_r($info2);
		echo "</pre>";
    }
}