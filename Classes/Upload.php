<?php
class Upload{
	public $allowType=array("image/png","image/jpeg","image/gif");
	public $allowSize=2000000;
	protected $error="";
	/**
	 * 获取扩展名 $_FILES['name']
	 * $name="PHP总监咨询日 (1).a.b.png";
	 */
	private function getExtension($name){
		$arr=explode(".",$name);
		//获取最后一个元素，并返回
		return end($arr);
	}
	function uploadOne($savePath="./",$keyName='upload'){
		//判断是否出错
		if($_FILES && $_FILES[$keyName]['error']===0){
			//判断类型
			$type=$_FILES[$keyName]['type'];
			if(in_array($type,$this->allowType)){
				//判断大小
				$size=$_FILES[$keyName]['size'];
				if($size<=$this->allowSize){
					//给新文件起名
					$fileName=uniqid(mt_rand(1000,9999),true);
					$newFileName=$fileName.".".$this->getExtension($_FILES[$keyName]['name']);
					//$_FILES 的格式,保存图片
					//echo $savePath."/".$newFileName;
					$re=move_uploaded_file($_FILES[$keyName]['tmp_name'],$savePath."/".$newFileName);
					if($re){
						return $newFileName;
					}else{
						$this->error="文件保存失败";
						return false;
					}
				}else{
					$this->error="文件过大";
					return false;
				}
				
			}else{
				$this->error="文件类型错误";
				return false;
			}
			
		}else{
			//哪错了
			$this->error=$_FILES[$keyName]['error'];
			return false;
		}
		
		
	}
	function uploadAll($savePath="./",$keyName="upload"){
		if($_FILES){
			$returnArr=array();
			foreach($_FILES[$keyName]['error'] as $k=>$v){
				if($v===0){
					//判断类型
					$type=$_FILES[$keyName]['type'][$k];
					if(in_array($type,$this->allowType)){
						//判断大小
						$size=$_FILES[$keyName]['size'][$k];
						if($size<=$this->allowSize){
							//起名
							$ext=$this->getExtension($_FILES[$keyName]['name'][$k]);
							$fileName=uniqid(mt_rand(1000,9999),true).".".$ext;
							$re=move_uploaded_file($_FILES[$keyName]['tmp_name'][$k], $savePath."/".$fileName);
							if($re){
								$returnArr[$k]=$fileName;
							}else{
								$this->error[$k]="保存失败";
							}
						}else{
							$this->error[$k]="文件过大";
						}
					}else{
						$this->error[$k]="类型错误";
					}
				}else{
					$this->error[$k]=$v;
				}
			}
			return $returnArr;
		}
		return false;
	}
	//获取错误信息
	function getError(){
		return $this->error;
	}
}