<?php
/**
 * 格式化数据
 */
function P($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

/**
 * 打印数据格式
 */
function V($data){
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
}

/**
 * 分页
 * @param  int  $total      总记录数
 * @param  int  $listRows   每页显示记录数
 * @param  string  $params  参数
 * @return [type]           [description]
 */
function getPage($total, $pageSize, $params){
	$page = new \Think\Pages($total, $pageSize, $params);
	$pageArr['pageStr'] = $page->fpage(array(2, 3, 4, 6, 7));
	$pageArr['offset']  = $page->offset;
	return $pageArr;
}

/**
 * 生成uuid（唯一标识）
 * @return string
 */
function get_uuid(){
	if (function_exists('com_create_guid')){
		return com_create_guid();
	}else{
		mt_srand((double)microtime()*10000);
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45);// "-"
		$uuid = substr($charid, 0, 8).$hyphen
		.substr($charid, 8, 4).$hyphen
		.substr($charid,12, 4).$hyphen
		.substr($charid,16, 4).$hyphen
		.substr($charid,20,12);
		return $uuid;
	}
}


/**
 * 字符串长度限定
 * @param  [type] $text   [description]
 * @param  [type] $length [description]
 * @return [type]         [description]
 */
function subtext($text, $length){
    if(mb_strlen($text, 'utf8') > $length) 
    return mb_substr($text, 0, $length, 'utf8').'...';
    return $text;
}


/**
 * curl请求接口
 * @param $url 请求网址
 * @param array $params 请求参数
 * @param int $ispost 请求方式 0 get 方式  1 post 方式
 * @param int $https https协议 0 http 协议 1 https 协议
 * @return bool|mixed
 */
function curl($url, $params = false, $ispost = 0, $https = 0)
{
	$httpInfo = array();
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	if ($https) {
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
	}
	if ($ispost) {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_URL, $url);
	} else {

		if ($params) {
			if (is_array($params)) {
				$params = http_build_query($params);
			}
			curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
		} else {
			curl_setopt($ch, CURLOPT_URL, $url);
		}
	}
	$response = curl_exec($ch);
	if ($response === FALSE) {
		//echo "cURL Error: " . curl_error($ch);
		return false;
	}
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$httpInfo = array_merge($httpInfo, curl_getinfo($ch));
	curl_close($ch);
	return $response;
}

/**
 * $expTitle  文件名称 
 * $expCellName  列名称 二维 数组 
 * $expTableData 列数据 二维
 */
function exportExcel($expTitle,$expCellName,$expTableData){
    ob_clean();
    $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
    $fileName = $expTitle.'_'.date('YmdHis',time()).rand(100000,999999);//or $xlsTitle 文件名称可根据自己情况设定
    $cellNum = count($expCellName);// 有几列
    $dataNum = count($expTableData);// 有几行数据
	vendor('PHPExcel.PHPExcel','','.php');
	vendor('PHPExcel.PHPExcel.IOFactory','','.php');
	// 一定要加根 命名空间   \
    $objPHPExcel = new \PHPExcel();
    $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
    //将第一行合并单元格
    $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');
   // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
    // 循环取出列名并写入表格中  从第二行开始写入列名数据
    for($i=0;$i<$cellNum;$i++){
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
    } 
    // Miscellaneous glyphs, UTF-8   
    // 循环取出数据列， 
    for($i=0;$i<$dataNum;$i++){
      for($j=0;$j<$cellNum;$j++){
        $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
      }             
    }  
    // 设置头信息
    header('pragma:public');
    header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
    header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
	// 一定要加根 命名空间   \
	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
    $objWriter->save('php://output'); 
    exit;   
}

/**
 * 保存文件
 * @param  [type]  $url      [description]
 * @param  string  $save_dir [description]
 * @param  string  $filename [description]
 * @param  integer $type     [description]
 * @return [type]            [description]
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

function thumb($filename, $per = '0.2') {
        list($width, $height)=getimagesize($filename);
        $n_w=$width*$per;
        $n_h=$height*$per;
        $new=imagecreatetruecolor($n_w, $n_h);
        $img=imagecreatefrompng($filename);
        //copy部分图像并调整
        imagecopyresized($new, $img,0, 0,0, 0,$n_w, $n_h, $width, $height);
        //图像输出新图片、另存为
        imagepng($new, $filename);
        imagedestroy($new);
        imagedestroy($img);
    }

function water($dst_path, $src_path) {
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $src = imagecreatefromstring(file_get_contents($src_path));
        //获取水印图片的宽高
        list($src_w, $src_h) = getimagesize($src_path);
        //将水印图片复制到目标图片上，最后个参数50是设置透明度，这里实现半透明效果
//        imagecopymerge($dst, $src, 10, 10, 0, 0, $src_w, $src_h, 50);
        //如果水印图片本身带透明色，则使用imagecopy方法
         imagecopy($dst, $src, 10, 10, 0, 0, $src_w, $src_h);
        //输出图片
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
            case 1://GIF
                header('Content-Type: image/gif');
                imagegif($dst);
                break;
            case 2://JPG
                header('Content-Type: image/jpeg');
                imagejpeg($dst);
                break;
            case 3://PNG
                header('Content-Type: image/png');
                imagepng($dst);
                break;
            default:
                break;
        }
        imagedestroy($dst);
        imagedestroy($src);
    }

/**
 * 水印图片
 * @return [type] [description]
 */
    function water2() {
        $dst_path = 'dst.jpg';
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        //打上文字
        $font = './simsun.ttc';//字体
        $black = imagecolorallocate($dst, 0x00, 0x00, 0x00);//字体颜色
        imagefttext($dst, 13, 0, 20, 20, $black, $font, '快乐编程');
        //输出图片
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
            case 1://GIF
                header('Content-Type: image/gif');
                imagegif($dst);
                break;
            case 2://JPG
                header('Content-Type: image/jpeg');
                imagejpeg($dst);
                break;
            case 3://PNG
                header('Content-Type: image/png');
                imagepng($dst);
                break;
            default:
                break;
        }
        imagedestroy($dst);
    }



/**
 * 加logo
 */
function addQrLogo($QR, $logo, $newImg) {
    $QR = imagecreatefromstring(file_get_contents($QR)); 
    $logo = imagecreatefromstring(file_get_contents($logo)); 
    if (imageistruecolor($logo)) {
        imagetruecolortopalette($logo, false, 65535); //添加这行代码来解决颜色失真问题
    }
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
    //输出图片 
    imagepng($QR, $newImg); 
}

/**
 * 将网上图片存到本地
 * @param [type] $url      [description]
 * @param string $filename [description]
 */
function saveImg($url, $filename = ""){
    //如果url地址为空,直接退出
    if ( empty($url) ){
        return false;
        die;
    }
    //如果没有指定文件名
    if ( empty($filename) ){
        $ext = strrchr($url, "."); //获取图片格式
        //如果图片格式不为.gif或者.jpg直接退出
        if( ext != ".gif" && $ext != '.jpg'){
            return false;
            die;
        }
        $filename = date("dMYHis") . $ext;
    }
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

/**
 * 获取签名
 */
function getSign($data, $type, $time, $signKey = '') {
    if (!$signKey) {
        $signKey = S('config')['app_sign_key'];
    }
    ksort($data);
    $str1 = '';
    foreach ($data as $d) {
        $str1 .= $d;
    }
    $str2 = md5($str1);
    $str3 = $signKey . $str2 . $time . $type;
    return md5($str3);
}

//中文字符串截取
function m_substr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
    if (function_exists("mb_substr")) {
        if ($suffix && strlen($str) > $length)
            return mb_substr($str, $start, $length, $charset) . "...";
        else
            return mb_substr($str, $start, $length, $charset);
    }
    elseif (function_exists('iconv_substr')) {
        if ($suffix && strlen($str) > $length)
            return iconv_substr($str, $start, $length, $charset) . "...";
        else
            return iconv_substr($str, $start, $length, $charset);
    }
    $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("", array_slice($match[0], $start, $length));
    if ($suffix)
        return $slice . "…";
    return $slice;
}

//是否为手机端
function is_mobile_request() {
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
    $mobile_browser = 0;
    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
        $mobile_browser++;
    if ((isset($_SERVER['HTTP_ACCEPT'])) and ( strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'applicationnd.wap.xhtml+xml') !== false))
        $mobile_browser++;
    if (isset($_SERVER['HTTP_X_WAP_PROFILE']))
        $mobile_browser++;
    if (isset($_SERVER['HTTP_PROFILE']))
        $mobile_browser++;
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
        'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
        'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
        'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
        'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
        'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
        'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
        'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
        'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-'
    );
    if (in_array($mobile_ua, $mobile_agents))
        $mobile_browser++;
    if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
        $mobile_browser++;
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
        $mobile_browser = 0;
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
        $mobile_browser++;
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
        $mobile_browser++;
    if ($mobile_browser > 0)
        return true;
    else
        return false;
}

//时间 今天 昨天前天
function tranTime($time) {
    $rtime = date("Y-m-d H:i", $time);
    $htime = date("H:i", $time);
    $time = time() - $time;
    if ($time < 60) {
        $str = '刚刚';
    } elseif ($time < 60 * 60) {
        $min = floor($time / 60);
        $str = $min . '分钟前';
    } elseif ($time < 60 * 60 * 24) {
        $h = floor($time / (60 * 60));
        $str = $h . '小时前 ';
    } elseif ($time < 60 * 60 * 24 * 3) {
        $d = floor($time / (60 * 60 * 24));
        if ($d == 1)
            $str = '昨天 ' . $htime;
        else
            $str = '前天 ' . $htime;
    }
    else {
        $str = $rtime;
    }
    return $str;
}

/**
 * 根据条件删除文件夹
 */
function delAssDir($dirName, $where = array(), $type = '0') {
    if (!empty($where)) {
        if ($handle = opendir("$dirName")) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    if (in_array($item, $where)) {
                        continue;
                    } else {
                        if (is_dir("$dirName/$item")) {
                            delAssDir("$dirName/$item", $where, '1');
                        } else {
                            unlink("$dirName/$item");
                        }
                    }
                }
            }
            closedir($handle);
            if ($type == '1') {
                rmdir($dirName);
            }
        }
    }
}

/**
 * 合并目录
 * @param $source 要合并的文件夹
 * @param $target 要合并的目的地
 * @return int 处理的文件数
 */
function copy_merge($source, $target) {
    // 路径处理
    $source = preg_replace('#/\\\\#', DIRECTORY_SEPARATOR, $source);
    $target = preg_replace('#\/#', DIRECTORY_SEPARATOR, $target);
    $source = rtrim($source, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    $target = rtrim($target, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    // 记录处理了多少文件
    $count = 0;
    // 如果目标目录不存在，则创建。
    if (!is_dir($target)) {
        mkdir($target, 0777, true);
        $count ++;
    }
    // 搜索目录下的所有文件
    foreach (glob($source . '*') as $filename) {
        if (is_dir($filename)) {
            // 如果是目录，递归合并子目录下的文件。
            $count += copy_merge($filename, $target . basename($filename));
        } elseif (is_file($filename)) {
            // 如果是文件，判断当前文件与目标文件是否一样，不一样则拷贝覆盖。
            // 这里使用的是文件md5进行的一致性判断，可靠但性能低，应根据实际情况调整。
            if (!file_exists($target . basename($filename)) || md5(file_get_contents($filename)) != md5(file_get_contents($target . basename($filename)))) {
                copy($filename, $target . basename($filename));
                $count ++;
            }
        }
    }

    // 返回处理了多少个文件
    return $count;
}

/**
 * 删除文件夹
 * */
function delDirAndFile($dirName) {
    if ($handle = opendir("$dirName")) {
        while (false !== ($item = readdir($handle))) {
            if ($item != "." && $item != "..") {
                if (is_dir("$dirName/$item")) {
                    delDirAndFile("$dirName/$item");
                } else {
                    unlink("$dirName/$item");
                }
            }
        }
        closedir($handle);
        rmdir($dirName);
    }
}

/**
 * 替换数组中的指定字符串
 * 
 */
function strReplace(&$array, $find, $str) {
    $array = str_replace($find, $str, $array);

    if (is_array($array)) {
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                strReplace($array[$key], $find, $str);
            }
        }
    }
}

/**
 * 获取当前页面完整URL地址
 */
function get_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
}

/**
 * 生成随机字符串
 * @param type $length 生成长度
 * @param type $Big 是否包含大写字母
 * @param type $Num 是否包含数字
 * @param type $lower 是否包含小写字母
 * @param type $s 是否包含符号
 * @return type 生成的字符串
 */
function getRandChar($length, $Big = true, $Num = true, $lower = true, $s = false) {
    $str = null;
    $strPol .= $Big ? "ABCDEFGHIJKLMNOPQRSTUVWXYZ" : '';
    $strPol .= $Num ? "0123456789" : '';
    $strPol .= $lower ? "abcdefghijklmnopqrstuvwxyz" : '';
    $strPol .= $s ? "~!@#$%^&*()_+|<>?:;,.=-" : '';




    $max = strlen($strPol) - 1;

    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)]; //rand($min,$max)生成介于min和max两个数之间的一个随机整数
    }

    return $str;
}


/**
 * 加密方法
 * 生成用户pwd字段密码（高加密）
 * @param type $username 帐号
 * @param type $passwordOneMd5 密码
 * @param type $userSalt 用户盐值
 * @param type $PUB_SALT 公共盐值
 * @return type 加密结果
 */
function createPwd($username, $passwordOneMd5, $userSalt, $PUB_SALT) {
    if ($username && $passwordOneMd5 && $userSalt && $PUB_SALT) {
        return md5(md5($userSalt) . md5($username) . md5($passwordOneMd5) . md5($PUB_SALT));
    } else {
        return null;
    }
}

/**
 * 判断安卓/IOS
 * @param $allowIpad 是否允许ipad扫描下载
 */
function get_open_type($allowIpad = false) {
    //全部变成小写字母
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $type = 'other';
    //分别进行判断
    if ($allowIpad) {
        if (strpos($agent, 'iphone') || strpos($agent, 'ipad')) {
            $type = 'ios';
        }
    } else {
        if (strpos($agent, 'iphone')) {
            $type = 'ios';
        }
    }
    if (strpos($agent, 'android')) {
        $type = 'android';
    }
    return $type;
}


/**
 * 下载文件
 * @param $fileName 下载后的文件名称, 带后缀
 * @param $filePath 下载文件的项目根路径
 */
function downloadFile($fileName, $filePath) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . mb_convert_encoding($fileName, "gb2312", "utf-8"));  //转换文件名的编码
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));
    ob_clean();
    flush();
    readfile($filePath);
}

/**
 * 文件上传配置
 * @param  [type] $rootPath [description]
 * @param  [type] $savePath [description]
 * @return [type]           [description]
 */
function uploadImg($rootPath, $savePath) {
    $upload = new \Think\Upload(); // 实例化上传类 
    $upload->maxSize = 3145728; // 设置附件上传大小 
    $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型 
    $upload->rootPath = $rootPath; // 设置附件上传根目录 
    $upload->savePath = $savePath; // 设置附件上传（子）目录 // 上传文件  
    $info = $upload->upload();
    if (!$info) {
        $info = $upload->getError();
    }
    return $info;
}

function uploadImgOne($file, $rootPath, $savePath) {
    $upload = new \Think\Upload(); // 实例化上传类 
    $upload->maxSize = 3145728; // 设置附件上传大小 
    $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型 
    $upload->rootPath = $rootPath; // 设置附件上传根目录 
    $upload->savePath = $savePath; // 设置附件上传（子）目录 // 上传文件  
    $info = $upload->uploadOne($file);
    if (!$info) {
        $info = $upload->getError();
    }
    return $info;
}

function thumbImg($file, $newFile, $w, $h) {
    $img = new \Think\Image();
    $img->open($file)->thumb($w, $h)->save($newFile);
}



