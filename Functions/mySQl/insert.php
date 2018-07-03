<?php
/**
*向数据表插入记录
*@param  string $table,数据表名称
*@param  array $bind,由字段名称和字段值组成的关联数组
*@return string $sql,标准的INSERT语句字符串
*/
function insert($table,$bind){
   $keys = join(',',array_keys($bind));
   $vals = join('\',\'',$bind);
   $sql = 'INSERT ' . $table . '(' . $keys . ') VALUES(\'' . $vals . '\')';
   return $sql;
 
}
