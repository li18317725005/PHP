<?
//��д����ʵ��ҳ�澲̬��
  
$out1 = "<html><head><title>PHP��վ��̬���̳�</title></head><body>��ӭ����PHP��վ�����̳���www.leapsoul.cn��������Ҫ����PHP��վҳ�澲̬���ķ���</body></html>";  
$fp = fopen("leapsoulcn.html","w");  
if(!$fp)  
{  
echo "System Error";  
exit();  
}  
else  
{  
fwrite($fp,$out1);  
fclose($fp);  
echo "Success";  
}  
?>  