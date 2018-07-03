<?php
header('Content-Type:text/html;charset=utf-8');
// 主题接口
interface Subject{
    public function register(Observer $observer);
    public function notify();
}


// 观察者接口
interface Observer{
    public function watch($param1, $param2);
}


// 主题
class Action implements Subject{
     private $_observers = array();
     public  $username = '李先生';
     public  $phone = '18317725005';

     //注册
     public function register(Observer $observer){
         $this->_observers[]=$observer;
     }

     //通知
     public function notify(){
         foreach ($this->_observers as $observer) {
             $observer->watch($this, $this->phone);
         }

     }
 }


// 观察者
class Cat implements Observer{
     public function watch($param1, $param2){
        echo $param1->username .'--'. $param2;
        echo "<br/>"; 
     }
 } 

 class Dog implements Observer{
     public function watch($param1, $param2){
         echo $param1->username .'--'. $param2;
         echo "<br/>";
     }
 } 

 class People implements Observer{
     public function watch($param1, $param2){
        echo $param1->username .'--'. $param2;
        echo "<br/>";
     }
 }



// 应用实例
$action=new Action();
$action->register(new Cat());
$action->register(new People());
$action->register(new Dog());
$action->notify();
