<?php
//所有数据表基类
abstract class Model{
	protected $tableName = "";
	protected $pdo = "";
	function __construct(){
		$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USERNAME,DB_PASSWORD);
		$pdo->exec("set names ".DB_CHARSET);
		$this->pdo = $pdo;
		$this->tableName = strtolower(substr(get_class($this),0,-5));
		$this->init();
	}
	protected function init(){
		
	}
	//增  
	function insert($arr){
		$keys = "";
		$values = "";
		foreach ($arr as $k => $v){
			$keys .= "," . $k;
			$values .= ",'" . $v ."'";
		}
		$keys = substr($keys, 1);
		$values = substr($values, 1);
		$query = "insert into {$this->tableName} ({$keys}) values ({$values})";
		$result = $this->pdo->exec($query);
		//测试 echo $query;exit;
		if ($result) {
			return $this->pdo->lastInsertId();
		}else{
			return false;
		}
	}
	
	
	//删
	function delete($where=NULL){
		$query = "delete from {$this->tableName} " . ($where == NULL?NULL:" where $where");
		//测试 echo $query;exit;
		return $this->pdo->exec($query);
	}
	
	
	//改
	function update($arr,$where=NULL){
		foreach ($arr as $key => $value){
			$sql .= ($sql == NULL?NULL:",") . $key . "='" .$value ."'"; 
		}
		$query = "update {$this->tableName} set $sql" . ($where == NULL?NULL:" where  $where");
		//测试  echo $query;exit;
		return $this->pdo->exec($query);
	}
	
	
	//查
	//查一条信息
	function selectByPk($id){
		$statm = $this->pdo->query("desc ".$this->tableName);
		$arr = $statm->fetchAll(PDO::FETCH_ASSOC);
		foreach ($arr as $v){
			if ($v['Key'] == "PRI"){
				$fieldName = $v['Field'];
				break;
			}
		}
		$query = "select * from {$this->tableName} where $fieldName=$id";
		//测试 echo $query;exit;
		$statm = $this->pdo->query($query);
		return $statm->fetch(PDO::FETCH_ASSOC);
	}
	//查多条信息
	function selectAll($arr=array()){
		//select 字段列表 from 表名
		//where 条件 group by 字段 having 条件 order by 字段 desc|asc limit start,length
		//select 字段列表 from 表1 as t1 join 表2 as t2 on t1.字段=t2.字段 
		//拼sql语句
		$field = isset($arr['field']) ? $arr['field']:"*";
		$alias = isset($arr['alias']) ? " as " . $arr['alias']:"";
		$join = isset($arr['join']) ? " join " . $arr['join']:"";
		$where = isset($arr['where']) ? " where " . $arr['where']:"";
		$group = isset($arr['group']) ? " group by " . $arr['group']:"";
		$having =isset($arr['having']) ? " having " . $arr['having']:"";
		$order = isset($arr['order']) ? " order by " . $arr['order']:"";
		$limit = isset($arr['limit']) ? " limit " . $arr['limit']:"";
		$query = "select $field from {$this->tableName} $alias $join $where $group $having $order $limit";
		//测试 echo $query;exit;
		$statm = $this->pdo->query($query);
		if (is_object($statm)) {
			return $statm->fetchAll(PDO::FETCH_ASSOC);
		}else {
			return array();
		}
	}
	
	
}





























