<?php

class DB{
	/////成员属性
	public $server;
	public $username;
	public $password;
	public $dbname;
	function __construct($server,$username,$password,$dbname){
		$this -> server = $server;
		$this -> username = $username;
		$this -> password = $password;
		$this -> dbname = $dbname;
		$this -> connect(); /// 省略步骤
		$this -> selectdb();/// 省略步骤
	}
	
	/////打开选择数据库
	function connect(){
		mysql_connect($this -> server,$this -> username,$this -> password);
	}
	function selectdb(){
		mysql_select_db($this->dbname);
	}
	
	/////增
	function insert($tablename,$bind){
		$keys_array   = array_keys($bind);
		$keys         = join(',' , $keys_array);
		$values       = implode("','" , $bind);
		$query  = "INSERT into $tablename ($keys) VALUES ('" .$values. "')";
		$result = mysql_query($query);
		return $result;
	}
	
	/////删
	function delete($tablename,$where=NULL){
		$query  = "DELETE FROM $tablename " .($where == NULL?NULL:'WHERE ' . $where);
		$result = mysql_query($query);
		return $result;
	}
	
	/////改
	function update($tablename,$bind,$where=NULL){
		foreach ($bind as $key => $value){
			$sql .= ($sql == NULL?NULL:',') . $key . ' = \'' . $value . '\'';
		}
		$query  = "UPDATE $tablename SET $sql" . ($where == NULL?NULL:' WHERE ' . $where);
		$result = mysql_query($query);
		return $result;
	}
	
	/////查
	
	function select($table,$fileds,$where="",$limit=""){
		if($where!=""){
			$where = " where $where";
		}
		if($limit!=""){
			$limit = " limit $limit";
		}
		$query = "select $fileds from $table $where $limit";		
		$result = mysql_query($query);
		return $result;
	}	
	/////关闭数据库
	function __destruct(){
		mysql_close();
	}
}































