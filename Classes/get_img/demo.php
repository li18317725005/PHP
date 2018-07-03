<?php

/**
	 * host 生成链接地址
	 * fileName 二维码名字
	 * level 容错级别 
	 * size 图片大小
	 */
	function createCode($url='',$fileName='' , $level=3, $size=6){
	  
		Vendor('phpqrcode.phpqrcode');
		  
		$object = new \QRcode();
        $object->png($url, $fileName, $level, $size);
	}


/*申请vip成功,生成会员专用二维码和发展下线的二维码*/
	function createVipCode( $headimgurl, $phone, $invit ){
		//创建5元 20元支付二维码
		$url_5  = 'http://hongbao.hnwwxxkj.com/Home/Pay/index?type=1';
		$url_20 = 'http://hongbao.hnwwxxkj.com/Home/Pay/index?type=2';
		$filePathName_5  = './data/upload/PayCode/Vip_code5/' . $phone . '_5.png';
		$filePathName_20 = './data/upload/PayCode/Vip_code20/' . $phone . '_20.png';
		createCode( $url_5, $filePathName_5 );
		createCode( $url_20, $filePathName_20 );
		//创建发展下线的二维码
		$url_down = 'http://hongbao.hnwwxxkj.com/Home/Child/addInvitUser/p_invit/' . $invit;
		$filePathName_down = './data/upload/PayCode/Vip_down/' . $phone . '_down.png';
		createCode( $url_down, $filePathName_down );

		//将微信头像保存到本地
		$logoPathName = './data/upload/PayCode/Vip_logo/' . $phone . '.png';
		$logoPathName = saveImg( $headimgurl, $logoPathName );

		//将头像作为logo做到二维码上
		addErWeiMaLogo( $logoPathName, $filePathName_5, $filePathName_5 );
		addErWeiMaLogo( $logoPathName, $filePathName_20, $filePathName_20 );
		addErWeiMaLogo( $logoPathName, $filePathName_down, $filePathName_down);
	}



	//-----------------------------------------------------------------------//
/**
 * 将网上图片存到本地
 * @param [type] $url      [description]
 * @param string $filename [description]
 */
function saveImg($url, $filename = ""){
	ob_start(); //打开输出
	readfile( $url ); //输出图片文件
	$img = ob_get_contents(); //得到浏览器的输出
	ob_end_clean(); //清除输出并关闭
	$size = strlen($img); //得到图片大小
	$fp2 = @fopen($filename, "a");
	fwrite($fp2, $img); //向当前目录写入图片文件, 并重新命名
	fclose($fp2);
	return $filename; //返回新的文件名
}


/*
*功能：php完美实现下载远程图片保存到本地
*参数：文件url,保存文件目录,保存文件名称，使用的下载方式
*当保存文件名称为空时则使用远程文件原来的名称
*/
function getImage($url,$save_dir='',$filename='',$type=0){
  if(trim($url)==''){
 return array('file_name'=>'','save_path'=>'','error'=>1);
 }
 if(trim($save_dir)==''){
 $save_dir='./';
 }
  if(trim($filename)==''){//保存文件名
    $ext=strrchr($url,'.');
    if($ext!='.gif'&&$ext!='.jpg'){
  return array('file_name'=>'','save_path'=>'','error'=>3);
 }
    $filename=time().$ext;
  }
 if(0!==strrpos($save_dir,'/')){
 $save_dir.='/';
 }
 //创建保存目录
 if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
 return array('file_name'=>'','save_path'=>'','error'=>5);
 }
  //获取远程文件所采用的方法
  if($type){
 $ch=curl_init();
 $timeout=5;
 curl_setopt($ch,CURLOPT_URL,$url);
 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
 curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
 $img=curl_exec($ch);
 curl_close($ch);
  }else{
   ob_start();
   readfile($url);
   $img=ob_get_contents();
   ob_end_clean();
  }
  //$size=strlen($img);
  //文件大小
  $fp2=@fopen($save_dir.$filename,'a');
  fwrite($fp2,$img);
  fclose($fp2);
 unset($img,$url);
  return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
  }


/**
 * 将远程图片保存到本地
 * @param  str $url      远程图片路径
 * @param  str $folder   要保存到的目录
 * @param  str $pic_name 要保存的文件名字
 * @return [type]        [description]
 */
  function get_file($url,$folder,$pic_name){  
        set_time_limit(24*60*60); //限制最大的执行时间
        $destination_folder=$folder?$folder.'/':''; //文件下载保存目录
        $newfname=$destination_folder.$pic_name;//文件PATH
        $file=fopen($url,'rb');
         
        if($file){        
            $newf=fopen($newfname,'wb');
            if($newf){              
                while(!feof($file)){                    
                    fwrite($newf,fread($file,1024*8),1024*8);
                }
            }
            if($file){              
                fclose($file);
            }
            if($newf){              
                fclose($newf);
            }
        }       
    }

 /**
  * 给二维码添加logo
  * @param str $logo   logo的路径及名字
  * @param str $QR     二维码的路径及名字
  * @param str $newFileName 合成的图片的路径及名字
  */
 function addErWeiMaLogo( $logo, $QR, $newFileName ){
 	Vendor('phpqrcode.phpqrcode');
		if ($logo !== FALSE) {   
		    $QR = imagecreatefromstring(file_get_contents($QR));   
		    $logo = imagecreatefromstring(file_get_contents($logo));   
		    $QR_width = imagesx($QR);//二维码图片宽度   
		    $QR_height = imagesy($QR);//二维码图片高度   
		    $logo_width = imagesx($logo);//logo图片宽度   
		    $logo_height = imagesy($logo);//logo图片高度   
		    $logo_qr_width = $QR_width / 5;   
		    $scale = $logo_width/$logo_qr_width;   
		    $logo_qr_height = $logo_height/$scale;   
		    $from_width = ($QR_width - $logo_qr_width) / 2;   
		    //重新组合图片并调整大小   
		    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,   
		    $logo_qr_height, $logo_width, $logo_height);   
		}   
		//输出图片
		imagepng($QR, $newFileName);
 }