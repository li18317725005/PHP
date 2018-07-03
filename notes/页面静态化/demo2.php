<?php  
$gid  = $_GET['gid']+0;//商品id  
$goods_statis_file = "goods_file_".$gid.".html";//对应静态页文件  
$expr = 3600*24*10;//静态文件有效期，十天  
if(file_exists($goods_statis_file)){  
      $file_ctime =filectime($goods_statis_file);//文件创建时间  
      if($file_ctime+$expr-->time()){//如果没过期  
         echo file_get_contents($goods_statis_file);//输出静态文件内容  
         exit;  
      }else{//如果已过期  
            unlink($goods_statis_file);//删除过期的静态页文件  
            ob_start();  
   
            //从数据库读取数据，并赋值给相关变量  
   
            //include ("xxx.html");//加载对应的商品详情页模板  
   
            $content = ob_get_contents();//把详情页内容赋值给$content变量  
            file_put_contents($goods_statis_file,$content);//写入内容到对应静态文件中  
            ob_end_flush();//输出商品详情页信息  
      }  
}else{  
  ob_start();  
   
  //从数据库读取数据，并赋值给相关变量  
   
  //include ("xxx.html");//加载对应的商品详情页模板  
   
  $content = ob_get_contents();//把详情页内容赋值给$content变量  
  file_put_contents($goods_statis_file,$content);//写入内容到对应静态文件中  
  ob_end_flush();//输出商品详情页信息  
   
}  
   
?>  