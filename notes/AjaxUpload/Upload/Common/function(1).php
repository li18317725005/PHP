<?php
/**
 * 单个文件上传
 * @param  [type] $rootPath [description]
 * @param  [type] $savePath [description]
 * @return [type]           [description]
 */
function uploadImgOne($file, $rootPath, $savePath="", $saveName=array('uniqid','')){
	$upload = new \Think\Upload();// 实例化上传类 
	$upload->maxSize = 3145728 ;// 设置附件上传大小 
	$upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型 
	$upload->rootPath = $rootPath; // 设置附件上传根目录 
	$upload->savePath = $savePath; // 设置附件上传（子）目录 // 上传文件
	$upload->saveName = $saveName;
	// $upload->replace  = true;
	$info = $upload->uploadOne($file);
	if (!$info){
		$info = $upload->getError();
	}
	return $info;
}


/**
 * 多文件上传 
 * @param  str  $rootPath 文件上传根目录
 * @param  bool $type     true 将上传文件的文件名以逗号拼接并返回, false不拼接返回
 * @param  str  $savePath 文件上传子目录, 如果为空则以时间(2017-05-18)创建
 * @param  bool $autoSub  是否创建子目录
 * @param  str  saveName  上传后的文件名称
 * @param  bool replace   是否同名覆盖
 * @return arr  
 */
function uploadImg($rootPath, $type=false, $params="", $savePath='', $autoSub=true, $saveName=array('uniqid',''), $replace=false){
	$upload = new \Think\Upload();// 实例化上传类 
	$upload->maxSize = 3145728 ;  // 设置附件上传大小 
	$upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型 
	$upload->rootPath = $rootPath; // 设置附件上传根目录 
	$upload->savePath = $savePath; // 设置附件上传（子）目录
	$upload->autoSub  = $autoSub;  //是否创建子目录
	$upload->saveName = $saveName; //上传后文件的名称
	$upload->replace  = $replace;  //是否同名覆盖
	$info = $upload->upload($params);
	if (!$info){
		$data['code'] = 100;
		$data['info'] = $upload->getError();
	}else{
		$data['code'] = 200;
		if ($type){
			$data['info'] = "";
			foreach ($info as $v){
				$data['info'] .= ($data['info'] ? ',' : '') . $rootPath . $v['savepath'] . $v['savename'];
			}
		}else{
			$data['info'] = $info;
		}
	}
	return $data;
}