<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	
    	$this->display();
    }
    public function upload_img()
    {
    	$data=I('post.');
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $data['img'], $result)){
        	dump($result);
            $type = $result[2];
            $new_file ="./public/news_img/".$data['activeid']."/";
            if(!file_exists($new_file))
            {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $save_name=time().'_'.mt_rand(100,999);
            $suolv=$new_file.'sss_'.$save_name.".{$type}";
            $new_file = $new_file.$save_name.".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $data['img'])))){
            	$this->ajaxReturn('OK');
            }else{
            	$this->ajaxReturn('NO');
            }
        }
    }
}